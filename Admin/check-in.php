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

    // Feeling icons (emojis)
    $feelingIcons = [
        'Relaxed' => '😌',
        'Joyful' => '😃',
        'Calm' => '🌿',
        'Happy' => '😊',
        'Thankful' => '🙏',
        'Affectionate' => '❤️',
        'Confident' => '💪',
        'Sad' => '😢',
        'Stressed' => '😫',
        'Angry' => '😡',
        'Tired' => '🥱',
        'Lonely' => '😞',
        'Anxious' => '😰',
        'Frustrated' => '😤'
    ];

    // Each feeling has its own bubble background color
    $feelingColors = [
        'Relaxed' => '#76D7C4',     // teal
        'Joyful' => '#F7DC6F',      // yellow
        'Calm' => '#85C1E9',        // light blue
        'Happy' => '#F5B041',       // orange
        'Thankful' => '#BB8FCE',    // purple
        'Affectionate' => '#E74C3C',// red
        'Confident' => '#28B463',   // green
        'Sad' => '#5DADE2',         // blue
        'Stressed' => '#A93226',    // dark red
        'Angry' => '#922B21',       // deeper red
        'Tired' => '#7F8C8D',       // gray
        'Lonely' => '#566573',      // dark gray
        'Anxious' => '#D68910',     // amber
        'Frustrated' => '#884EA0'   // violet
    ];

    // Positivity colors (text)
    $positivityColors = [
        'Positive' => '#2E86C1',
        'Negative' => '#C0392B'
    ];

    // Did admin check-in this morning (8–10)?
    $morning_done = false;
    $evening_done = false;
    foreach ($today_checkins as $row) {
        $hour = (int)date("H", strtotime($row['admin_feeling_datetime']));
        if ($hour >= 8 && $hour <= 12) $morning_done = true;
        if ($hour >= 21 && $hour <= 23) $evening_done = true;
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
    $show_morning_prompt = ($currentHour >= 8 && $currentHour < 12 && !$morning_done && !$already_done_today);
    $show_evening_prompt = ($currentHour >= 21 && $currentHour < 23 && !$evening_done && !$already_done_today);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Personal Check-In</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <style>
        body, h1, h2, h3, h4, h5, h6, p, small, strong, div, span,
        button, input, textarea, select, label {
            font-family: 'Itim', cursive, sans-serif !important;
        }
        body { font-family: 'Itim', cursive, sans-serif; background: white; margin: 0; }
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
        .left-card {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .card {
            background: #f8f6f3;
            padding: 20px;
            border-radius: 12px;
            height: 300px;
        }
        h1, h2, p { margin: 0 0 10px 0; font-family: 'Itim';}
        /* Mood entry bubble look */
        .mood-entry {
            background: white;
            border-radius: 12px;
            padding: 12px 16px;
            margin: 10px 0;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.2s ease, background 0.2s ease;
        }
        .mood-entry:hover {
            background: #f0f0f0;
            transform: translateY(-2px);
        }
        .mood-entry strong {
            font-weight: 600;
            font-size: 18px;
        }
        .mood-entry small {
            font-size: 15px;
        }
        .mood-bubble {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }
        .mood-counts { justify-content: center; display: flex; gap: 10px; margin-bottom: 10px; }
        .mood-counts div { background: white; padding: 10px 15px; border-radius: 10px; }

        /* Feeling ball drop animation */
        @keyframes dropIn {
            0% { transform: translateY(-100px) scale(0.5); opacity: 0; }
            70% { transform: translateY(20px) scale(1.05); opacity: 1; }
            100% { transform: translateY(0) scale(1); }
        }

        .feeling-ball {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 10px;
            border: none;
            cursor: pointer;
            color: white;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            animation: dropIn 0.6s ease forwards;
        }

        /* Mood Journey scroll */
        .card_journey {
            max-height: calc(100vh - 145px);
            overflow-y: auto;
            background: #f8f6f3;
            padding: 20px;
            border-radius: 12px;
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

        #checkinModal, #noteModal {
            z-index: 9999; /*force modal on top */
        }

        /* Modal text */
        #chosenFeelingText {
            font-size: 22px !important; /* larger feeling text */
        }

        #noteFeelingCircle {
            width: 120px !important;   /* was 100px */
            height: 120px !important;  /* was 100px */
            font-size: 48px !important; /* bigger emoji */
        }

        #noteFeelingText {
            font-size: 24px !important; /* larger for emphasis */
        }
    </style>
</head>
<body>
    <?php include 'navigation.php'; ?>
    
    <div class="top-bar">
        <h1>Personal Check-In</h1>
    </div>
    <div class="main-content">
        <div class="left-card">
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

                <?php elseif ($morning_done && $currentHour < 23): ?>
                    <h2>Thank you for checking in your mood for the morning.</h2>
                    <p>See you later!</p>
                <?php endif; ?>
            </div>

            <!-- Today's Check-In -->
            <div class="card" style="text-align: center;">
                <h2>Today's Check-In</h2>
                <div class="mood-counts">
                    <div style="font-family: Itim;"><?= count(array_filter($today_checkins, fn($m)=>$m['positivity_feeling']=='Positive')) ?> Positive Feelings</div>
                    <div style="font-family: Itim;"><?= count(array_filter($today_checkins, fn($m)=>$m['positivity_feeling']=='Negative')) ?> Negative Feelings</div>
                </div>
                <?php foreach ($today_checkins as $mood): ?>
                    <div class="mood-entry mood-clickable"
                        data-datetime="<?= htmlspecialchars($mood['admin_feeling_datetime']) ?>"
                        data-positivity="<?= htmlspecialchars($mood['positivity_feeling']) ?>"
                        data-feeling="<?= htmlspecialchars($mood['admin_feeling']) ?>"
                        data-journal="<?= htmlspecialchars($mood['mini_journal']) ?>">
                        <div style="height: 60px;">
                            <small><?= date("D, M j · g:i A", strtotime($mood['admin_feeling_datetime'])) ?></small><br>
                            <strong style="color: <?= $positivityColors[$mood['positivity_feeling']] ?? 'black' ?>">
                                Feeling <?= htmlspecialchars($mood['admin_feeling']) ?>
                            </strong>
                        </div>
                        <div class="mood-bubble" style=" width: 50px; height: 50px; background: <?= $feelingColors[$mood['admin_feeling']] ?? '#eee' ?>;">
                            <?= $feelingIcons[$mood['admin_feeling']] ?? '🙂' ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Mood Journey -->
        <div class="card_journey" style="text-align: center;">
            <h2>Mood Journey</h2>
            <div class="mood-counts">
                <div style="font-family: Itim;"><?= $positive_count ?> Positive Feelings</div>
                <div style="font-family: Itim;"><?= $negative_count ?> Negative Feelings</div>
            </div>
            <?php foreach ($mood_journey as $mood): ?>
            <div class="mood-entry mood-clickable"
                data-datetime="<?= htmlspecialchars($mood['admin_feeling_datetime']) ?>"
                data-positivity="<?= htmlspecialchars($mood['positivity_feeling']) ?>"
                data-feeling="<?= htmlspecialchars($mood['admin_feeling']) ?>"
                data-journal="<?= htmlspecialchars($mood['mini_journal']) ?>">
                <div style="height: 60px;">
                    <small><?= date("D, M j · g:i A", strtotime($mood['admin_feeling_datetime'])) ?></small><br>
                    <strong style="color: <?= $positivityColors[$mood['positivity_feeling']] ?? 'black' ?>">
                        Feeling <?= htmlspecialchars($mood['admin_feeling']) ?>
                    </strong>
                </div>
                <div class="mood-bubble" style="width: 50px; height: 50px; background: <?= $feelingColors[$mood['admin_feeling']] ?? '#eee' ?>;">
                    <?= $feelingIcons[$mood['admin_feeling']] ?? '🙂' ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Mood Check-in Modal -->
    <div id="checkinModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
        <div style="background:#f8f6f3; width:700px; height:700px; margin:auto; position:absolute; top:0; bottom:0; left:0; right:0; border-radius:12px; padding:20px; overflow:auto;">
            <button onclick="closeModal()" style="position:absolute; top:10px; right:10px; border:none; background:none; font-size:18px; cursor:pointer;">✖</button>

            <!-- Step 1 -->
            <div id="step1">
                <h3>Tap the colour that represents your feeling right now</h3>
                <button onclick="selectPositivity('Positive')" class="circle-btn" style="background:#5DADE2; width:200px; height:200px;">Positive</button>
                <button onclick="selectPositivity('Negative')" class="circle-btn" style="background:#E74C3C;width:200px; height:200px;">Negative</button>
            </div>

            <!-- Step 2 -->
            <div id="step2" style="display:none;">
                <h3>How do you feel?</h3>
                <div id="feelingsPool"></div>
                <button onclick="backToStep1()" style="margin-top:20px;">⬅ Back</button>
            </div>

            <!-- Step 3 -->
            <div id="step3" style="display:none; text-align:center;">
                <h3 style="margin-bottom:20px;">Mini Journal</h3>
                <form method="POST" action="save_checkin.php" style="max-width:400px; margin:auto;">
                    <input type="hidden" name="positivity_feeling" id="positivityInput">
                    <input type="hidden" name="admin_feeling" id="feelingInput">

                    <!-- Emoji Circle -->
                    <div id="chosenFeelingCircle"
                        style="width:80px; height:80px; border-radius:50%; margin:auto; display:flex; align-items:center; justify-content:center; font-size:32px; color:white;">
                    </div>

                    <!-- Feeling Text -->
                    <p style="margin-top:10px;">I'm feeling</p>
                    <p id="chosenFeelingText" style="font-weight:bold; font-size:18px;"></p>

                    <!-- Journal Input -->
                    <textarea name="mini_journal" placeholder="Type a message"
                            style="width:100%; border-radius:8px; padding:8px; border:1px solid #ccc; margin-top:15px;"></textarea>

                    <!-- Save Button -->
                    <button type="submit"
                            style="background:#d4a373; border:none; padding:10px 20px; border-radius:8px; color:white; cursor:pointer; margin-top:20px;">
                        Save
                    </button>
                </form>
                <button onclick="backToStep2()" style="margin-top:20px; background:none; border:none; cursor:pointer;">⬅ Back</button>
            </div>
        </div>
    </div>

    <!-- Mood Details Modal -->
    <div id="noteModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
        <div style="background:#f8f6f3; width:700px; height:700px; margin:auto; position:absolute; top:0; bottom:0; left:0; right:0; border-radius:12px; padding:20px; overflow:auto; text-align:center;">
            <button onclick="closeNoteModal()" style="position:absolute; top:10px; right:10px; border:none; background:none; font-size:18px; cursor:pointer;">✖</button>

            <!-- Emoji Circle -->
            <div id="noteFeelingCircle"
                style="width:100px; height:100px; border-radius:50%; margin:20px auto; display:flex; align-items:center; justify-content:center; font-size:40px; color:white;">
            </div>

            <!-- Feeling Text -->
            <h2 id="noteFeelingText" style="margin:10px 0;"></h2>

            <!-- Other Info -->
            <p><strong>Positivity:</strong> <span id="notePositivity"></span></p>
            <p><strong>Date & Time:</strong> <span id="noteDatetime"></span></p>

            <!-- Journal -->
            <h3 style="margin-top:20px;">Mini Journal</h3>
            <p id="noteJournal" style="white-space:pre-wrap; background:white; padding:10px; border-radius:8px;"></p>
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
            btn.className = "feeling-ball";
            btn.style.background = (type === 'Positive') ? "#5DADE2" : "#E74C3C";
            // btn.className = "circle-btn";
            // btn.style.background = "#ccc";
            btn.onclick = (e) => { e.preventDefault(); selectFeeling(f); };
            pool.appendChild(btn);
        });
    }

    // Step 2 → Step 3
    function selectFeeling(feeling) {
        document.getElementById('feelingInput').value = feeling;
        document.getElementById('chosenFeeling').innerText = feeling;

        // Emoji + color lookup from PHP arrays (inject them into JS)
        const feelingIcons = <?= json_encode($feelingIcons) ?>;
        const feelingColors = <?= json_encode($feelingColors) ?>;

        let circle = document.getElementById('chosenFeelingCircle');
        circle.innerText = feelingIcons[feeling] || '🙂';
        circle.style.background = feelingColors[feeling] || '#ccc';

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

    // Mood details modal
    function openNoteModal(data) {
        const feelingIcons = <?= json_encode($feelingIcons) ?>;
        const feelingColors = <?= json_encode($feelingColors) ?>;
        const positivityColors = <?= json_encode($positivityColors) ?>;

        // Emoji Circle
        let circle = document.getElementById('noteFeelingCircle');
        circle.innerText = feelingIcons[data.feeling] || '🙂';
        circle.style.background = feelingColors[data.feeling] || '#ccc';

        // Feeling Text
        let feelingText = document.getElementById('noteFeelingText');
        feelingText.innerText = data.feeling;
        feelingText.style.color = feelingColors[data.feeling] || '#333';

        // Positivity + datetime + journal
        document.getElementById('notePositivity').innerText = data.positivity;
        document.getElementById('notePositivity').style.color = positivityColors[data.positivity] || '#333';
        document.getElementById('noteDatetime').innerText = new Date(data.datetime).toLocaleString();
        document.getElementById('noteJournal').innerText = data.journal || "(No journal entry)";

        document.getElementById('noteModal').style.display = 'block';
    }

    function closeNoteModal() {
        document.getElementById('noteModal').style.display = 'none';
    }

    // document.querySelector('.btn-track-mood').addEventListener('click', openModal);

    // Attach click events after DOM is loaded
    document.addEventListener("DOMContentLoaded", () => {
        const trackBtn = document.querySelector('.btn-track-mood');
        if (trackBtn) {
            trackBtn.addEventListener('click', openModal);
        }

        document.querySelectorAll('.mood-clickable').forEach(el => {
            el.addEventListener('click', () => {
                openNoteModal({
                    datetime: el.dataset.datetime,
                    positivity: el.dataset.positivity,
                    feeling: el.dataset.feeling,
                    journal: el.dataset.journal
                });
            });
        });
    });

    // Prevent logout if missed
    <?php if (($currentHour >= 8 && $currentHour < 12 && !$morning_done) ||
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