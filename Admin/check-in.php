<?php
    session_start();
    include '../conn.php';
    if(!isset($_SESSION['admin_id'])){
        header("Location: Login/login.php");
        exit();
    }

    $admin_id = $_SESSION['admin_id'];

    // Malaysia timezone
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $now = new DateTime();
    $currentHour = (int)$now->format('H');
    $today = $now->format("Y-m-d");

    $sql_today = "
        SELECT * FROM feeling_admin 
        WHERE admin_id = ? 
        AND DATE(admin_feeling_datetime) = ?
        ORDER BY admin_feeling_datetime DESC 
        LIMIT 2
    ";
    $stmt_today = $dbConn->prepare($sql_today);
    $stmt_today->bind_param("ss", $admin_id, $today);
    $stmt_today->execute();
    $result_today = $stmt_today->get_result();
    $today_checkins = $result_today->fetch_all(MYSQLI_ASSOC);

    
    // Did admin check-in this morning (8–10)?
    $morning_done = false;
    $evening_done = false;
    foreach ($today_checkins as $row) {
        $hour = (int)date("H", strtotime($row['admin_feeling_datetime']));
        if ($hour >= 8 && $hour <= 10) $morning_done = true;
        if ($hour >= 21 && $hour <= 22) $evening_done = true;
    }

    // Fetch last 30 mood entries
    $sql_journey = "
        SELECT * FROM feeling_admin 
        WHERE admin_id = ? 
        ORDER BY admin_feeling_datetime DESC 
        LIMIT 30
    ";
    $stmt_journey = $dbConn->prepare($sql_journey);
    $stmt_journey->bind_param("s", $admin_id);
    $stmt_journey->execute();
    $result_journey = $stmt_journey->get_result();
    $mood_journey = $result_journey->fetch_all(MYSQLI_ASSOC);

    // Count positive/negative
    $sql_counts = "
        SELECT 
            SUM(CASE WHEN positivity_feeling = 'Positive' THEN 1 ELSE 0 END) AS positives,
            SUM(CASE WHEN positivity_feeling = 'Negative' THEN 1 ELSE 0 END) AS negatives
        FROM feeling_admin WHERE admin_id = ?
    ";
    $stmt_counts = $dbConn->prepare($sql_counts);
    $stmt_counts->bind_param("s", $admin_id);
    $stmt_counts->execute();
    $result_counts = $stmt_counts->get_result()->fetch_assoc();

    $positive_count = $result_counts['positives'] ?? 0;
    $negative_count = $result_counts['negatives'] ?? 0;

    // Determine prompt state
    $already_done_today = (count($today_checkins) >= 2);
    $show_morning_prompt = ($currentHour >= 8 && $currentHour < 10 && !$morning_done && !$already_done_today);
    $show_evening_prompt = ($currentHour >= 21 && $currentHour < 22 && !$evening_done && !$already_done_today);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Personal Check-In</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        body { font-family: 'Itim'; background: white; margin: 0; }
        .top-bar {
            padding-top: 30px;
            margin-left: 350px;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-left: 300px;
        }
        .card {
            background: #f8f6f3;
            padding: 20px;
            border-radius: 12px;
        }
        h1, h2, p { margin: 0 0 10px 0; font-family: 'Itim';}
        .mood-entry {
    background: white;
    border-radius: 10px;
    padding: 10px;
    margin: 8px 0;
    }
    .mood-counts { display: flex; gap: 10px; margin-bottom: 10px; }
    .mood-counts div { background: white; padding: 10px 15px; border-radius: 10px; }

    /* Mood Journey scroll */
    .card.journey {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    /* Modal buttons */
    .circle-btn {
        width: 80px; height: 80px;
        border-radius: 50%;
        margin: 8px;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 14px;
    }
    </style>
</head>
<body>
    <?php include 'navigation.php'; ?>
    
    <div class="top-bar">
        <h1>Personal Check-In</h1>
    </div>
    <div class="main-content">
        <!-- Check-in prompt -->
        <div class="card">
            <?php if ($already_done_today || $evening_done): ?>
                <h2>You've completed your mood check-in for the day.</h2>
                <p>See you tomorrow!</p>

            <?php elseif ($show_morning_prompt || $show_evening_prompt): ?>
                <h2>Today might be rough, but you passed it!</h2>
                <p>How you'd feel?</p>
                <span class="btn-track-mood" style="cursor:pointer;">
                    <img src="../image/icons/track_mood.png" alt="Track Mood" />
                </span>

            <?php elseif ($morning_done && $currentHour < 21): ?>
                <h2>Thank you for checking in your mood for the morning.</h2>
                <p>See you later!</p>
            <?php endif; ?>
        </div>

        <!-- Mood Journey -->
        <div class="card journey">
            <h2>Mood Journey</h2>
            <div class="mood-counts">
                <div><?= $positive_count ?> Positive Feelings</div>
                <div><?= $negative_count ?> Negative Feelings</div>
            </div>
            <?php foreach ($mood_journey as $mood): ?>
                <div class="mood-entry">
                    <small><?= date("D, M j · g:i A", strtotime($mood['admin_feeling_datetime'])) ?></small>
                    <strong>Feeling <?= htmlspecialchars($mood['admin_feeling']) ?></strong>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Today's Check-In -->
        <div class="card">
            <h2>Today's Check-In</h2>
            <div class="mood-counts">
                <div><?= count(array_filter($today_checkins, fn($m)=>$m['positivity_feeling']=='Positive')) ?> Positive Feelings</div>
                <div><?= count(array_filter($today_checkins, fn($m)=>$m['positivity_feeling']=='Negative')) ?> Negative Feelings</div>
            </div>
            <?php foreach ($today_checkins as $mood): ?>
                <div class="mood-entry">
                    <small><?= date("D, M j · g:i A", strtotime($mood['admin_feeling_datetime'])) ?></small>
                    <strong>Feeling <?= htmlspecialchars($mood['admin_feeling']) ?></strong>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Mood Check-in Modal -->
    <div id="checkinModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
        <div style="background:#f8f6f3; width:900px; height:900px; margin:auto; position:absolute; top:0; bottom:0; left:0; right:0; border-radius:12px; padding:20px; overflow:auto;">
            <button onclick="closeModal()" style="position:absolute; top:10px; right:10px; border:none; background:none; font-size:18px; cursor:pointer;">✖</button>

            <!-- Step 1 -->
            <div id="step1">
                <h3>Tap the colour that represents your feeling right now</h3>
                <button onclick="selectPositivity('Positive')" class="circle-btn" style="background:#5DADE2;">Positive</button>
                <button onclick="selectPositivity('Negative')" class="circle-btn" style="background:#E74C3C;">Negative</button>
            </div>

            <!-- Step 2 -->
            <div id="step2" style="display:none;">
                <h3>How do you feel?</h3>
                <div id="feelingsPool"></div>
                <button onclick="backToStep1()" style="margin-top:20px;">⬅ Back</button>
            </div>

            <!-- Step 3 -->
            <div id="step3" style="display:none;">
                <h3>Mini Journal</h3>
                <form method="POST" action="save_checkin.php">
                    <input type="hidden" name="positivity_feeling" id="positivityInput">
                    <input type="hidden" name="admin_feeling" id="feelingInput">
                    <p>I'm feeling <span id="chosenFeeling" style="font-weight:bold;"></span></p>
                    <textarea name="mini_journal" rows="4" style="width:100%; border-radius:8px;"></textarea><br><br>
                    <button type="submit" style="background:#d4a373; border:none; padding:10px 20px; border-radius:8px; color:white; cursor:pointer;">Save</button>
                </form>
                <button onclick="backToStep2()" style="margin-top:20px;">⬅ Back</button>
            </div>
        </div>
    </div>

    <script>
    function openModal() {
        document.getElementById('checkinModal').style.display = 'block';
    }
    function closeModal() {
        document.getElementById('checkinModal').style.display = 'none';
    }

    // Step 1 → Step 2
    function selectPositivity(type) {
        document.getElementById('positivityInput').value = type;
        document.getElementById('step1').style.display = 'none';
        document.getElementById('step2').style.display = 'block';

        let pool = document.getElementById('feelingsPool');
        pool.innerHTML = '';
        let feelings = (type === 'Positive')
            ? ['Relaxed','Joyful','Calm','Happy','Thankful','Affectionate','Confident']
            : ['Sad','Stressed','Angry','Tired','Lonely','Anxious','Frustrated'];

        feelings.forEach(f => {
            let btn = document.createElement('button');
            btn.textContent = f;
            btn.className = "circle-btn";
            btn.style.background = "#ccc";
            btn.onclick = (e) => { e.preventDefault(); selectFeeling(f); };
            pool.appendChild(btn);
        });
    }

    // Step 2 → Step 3
    function selectFeeling(feeling) {
        document.getElementById('feelingInput').value = feeling;
        document.getElementById('chosenFeeling').innerText = feeling;
        document.getElementById('step2').style.display = 'none';
        document.getElementById('step3').style.display = 'block';
    }

    function backToStep1() {
        document.getElementById('step2').style.display = 'none';
        document.getElementById('step1').style.display = 'block';
    }
    function backToStep2() {
        document.getElementById('step3').style.display = 'none';
        document.getElementById('step2').style.display = 'block';
    }

    document.querySelector('.btn-track-mood').addEventListener('click', openModal);

    // Prevent logout if missed
    <?php if (($currentHour >= 8 && $currentHour < 10 && !$morning_done) ||
            ($currentHour >= 21 && $currentHour < 22 && !$evening_done)): ?>
        document.addEventListener("DOMContentLoaded", () => {
            let logoutBtn = document.querySelector("a[href*='logout'], button.logout");
            if (logoutBtn) {
                logoutBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    alert("You must complete your mood check-in before logging out!");
                });
            }
        });
    <?php endif; ?>
    </script>
</body>
</html>