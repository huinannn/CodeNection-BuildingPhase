<?php
    session_start();
    include '../conn.php';
    if(!isset($_SESSION['student_id'])){
        header("Location: login.php");
        exit();
    }

    $student_id = $_SESSION['student_id'];
    $todayDate = date('Y-m-d');
    $todayFeeling = null;
    
    // 1. Get today's feeling (single row check)
    $checkToday = $dbConn->prepare("SELECT feeling_status FROM feeling WHERE student_id = ? AND DATE(feeling_date_time) = ? LIMIT 1");
    $checkToday->bind_param("ss", $student_id, $todayDate);
    $checkToday->execute();
    $checkToday->bind_result($todayFeeling);
    $checkToday->fetch();
    $checkToday->close();

    // 2. Get the latest 30 feelings for the chart
    $feelings_query = "SELECT feeling_status, DATE(feeling_date_time) as date FROM feeling WHERE student_id = ? ORDER BY feeling_date_time DESC LIMIT 30";
    $stmt = $dbConn->prepare($feelings_query);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Count each feeling type
    $feeling_counts = [
        'happy' => 0,
        'calm' => 0,
        'manic' => 0,
        'angry' => 0,
        'sad' => 0
    ];
    while($row = $result->fetch_assoc()){
        $status = strtolower($row['feeling_status']);
        if(isset($feeling_counts[$status])) $feeling_counts[$status]++;
        if($row['date'] == $todayDate) $todayFeeling = $status;
    }
    $stmt->close();

    // 2. Get booked dates for calendar
    $booked_query = "SELECT DATE(booking_date) as date FROM booking WHERE student_id = ?";
    $stmt2 = $dbConn->prepare($booked_query);
    $stmt2->bind_param("s", $student_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $booked_dates = [];
    while($row = $result2->fetch_assoc()){
        $booked_dates[] = $row['date'];
    }
    $stmt2->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Unicare</title>
    <link rel="icon" href="image/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="style.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Poppins', Arial, sans-serif; background: #fff; margin: 0; padding-bottom: 25%; }
        .dashboard-header {
            color: #F48C8C;
            font-size: 2rem;
            font-weight: bold;
            margin: 20px 20px 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dashboard-icons { display: flex; gap: 16px; }
        .dashboard-icons img { width: 28px; height: 28px; }
        .feelings-section { margin: 20px; }
        .feelings-title { font-size: 1.1rem; margin-bottom: 10px; }
        .feelings-options { display: flex; gap: 18px; margin-bottom: 18px; }
        .feeling-btn { border: none; background: none; cursor: pointer; display: flex; flex-direction: column; align-items: center; }
        .feeling-icon { width: 48px; height: 48px; border-radius: 12px; margin-bottom: 4px; display: flex; align-items: center; justify-content: center; font-size: 2rem; }
        .happy { background: #F48C8C; }
        .calm { background: #A7D8F5; }
        .manic { background: #B6E3C6; }
        .angry { background: #FFD59E; }
        .sad { background: #B7E5B7; }
        .feeling-label { font-size: 0.95rem; color: #444; }
        .emotion-journey-row {
            background: #FFF6F0;
            border-radius: 18px;
            padding: 12px;
            margin: 0 20px 12px 20px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .emotion-journey-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            flex: 1;
            align-items: flex-start;
        }
        .emotion-title { font-size: 1.1rem; font-weight: 500; margin-bottom: 8px; }
        .emotion-message { font-size: 0.98rem; color: #888; margin-bottom: 10px; }
        .emotion-chart {
            width: 80px;
            height: 80px;
            margin-bottom: 0;
            box-shadow: 0 2px 8px rgba(244, 140, 140, 0.18);
            background: #FFF6F0;
            border-radius: 50%;
            display: block;
        }
        .action-buttons { display: flex; gap: 18px; margin: 0 20px 18px 20px; }
        .action-btn { flex: 1; background: #E6D3C7; border-radius: 12px; padding: 14px 0; text-align: center; font-size: 1.1rem; font-weight: 500; color: #7A5C3A; border: none; cursor: pointer; }
        .calendar-section { margin: 0 20px 20px 20px; }
        .calendar-title { color: #F48C8C; font-size: 1.2rem; font-weight: bold; margin-bottom: 8px; }
        .calendar-table { width: 100%; border-collapse: collapse; }
        .calendar-table th, .calendar-table td { width: 14%; text-align: center; padding: 6px 0; }
        .calendar-table th { color: #F48C8C; font-weight: 500; }
        .calendar-table td { color: #444; border-radius: 0; }
        .calendar-today {
            background: #F48C8C;
            color: #fff !important;
            font-weight: bold;
            border-radius: 5px !important;
        }
        .calendar-weekend { color: #E8B45E !important; font-weight: 500; }
        .calendar-today.calendar-weekend, .calendar-weekend.calendar-today { color: #fff !important; }
        .calendar-booked {
            background: #CD661C;
            color: #fff !important;
            font-weight: bold;
            border-radius: 5px !important;
        }
        .calendar-month { background: #FFA85C; color: #fff; border-radius: 8px; padding: 2px 10px; font-size: 0.95rem; margin-bottom: 6px; display: inline-block; text-align: center; }
        @media (max-width: 700px) {
            .emotion-journey-row { flex-direction: row; gap: 8px; padding: 8px; margin: 0 8px 8px 8px; }
            .emotion-chart { width: 60px; height: 60px; }
            .emotion-journey-info { align-items: flex-start; }
        }
        @media (max-width: 500px) {
            .emotion-journey-row { margin: 6px; }
            .emotion-chart { width: 46px; height: 46px; }
        }
        @media (max-width: 500px) {
            .dashboard-header, .calendar-section, .feelings-section, .emotion-journey-row, .action-buttons { margin: 10px; }
        }

        .notification-bell {
            position: relative;
            display: inline-block;
        }
        .notification-red-dot {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 10px;
            height: 10px;
            background: #FF3B3B;
            border-radius: 50%;
            border: 2px solid #fff;
            z-index: 2;
            pointer-events: none;
        }
        .notification-green-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #2ECC40;
            border-radius: 50%;
            margin-left: 6px;
            vertical-align: middle;
        }

        .profile-dropdown {
            position: relative;
            cursor: pointer;
        }

        .profile-dropdown-content {
            display: none;
            position: absolute;
            top: 36px;
            right: 0;
            background: white;
            box-shadow: 0px 8px 24px rgba(0,0,0,0.12);
            border-radius: 8px;
            min-width: 140px;
            z-index: 10;
        }

        .profile-dropdown-content a {
            display: block;
            padding: 12px 16px;
            text-decoration: none;
            color: #3D3D3D;
            font-family: 'Poppins', Arial, sans-serif;
            font-size: 0.95rem;
        }

        .profile-dropdown-content a:hover {
            background-color: #f1f1f1;
            font-weight: bold;
        }

        .profile-dropdown:hover .profile-dropdown-content {
            display: block;
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        Dashboard
        <div class="dashboard-icons">
            <span class="notification-bell" onclick="openNotifications()" style="cursor:pointer;">
                <img src="../image/icons/notification.png" alt="Notifications" />
                <span id="notificationRedDot" class="notification-red-dot" style="display:none;"></span>
            </span>
            <div class="profile-dropdown">
                <img src="../image/icons/profile.png" alt="Profile" />
                <div class="profile-dropdown-content">
                    <a href="../Student/Login/logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </div>

    <div class="feelings-section">
        <div class="feelings-title" id="feelings-question">How are you feeling today?</div>
        <?php if ($todayFeeling): ?>
            <!-- Show encouragement only -->
            <div id="encouragement-message" style="font-size:1rem; color:#888; margin-top:10px;">
                <?php
                    $encouragements = [
                        'happy' => "Keep up the positivity!",
                        'calm' => "Stay balanced and serene!",
                        'manic' => "Take a deep breath, you're doing great!",
                        'angry' => "It's okay to feel angry. Try to relax!",
                        'sad' => "It's okay to feel sad. Remember, brighter days are ahead!"
                    ];
                    echo $encouragements[$todayFeeling];
                ?>
            </div>
        <?php else: ?>
            <!-- Show feeling options -->
            <div class="feelings-options" id="feelings-options">
                <button class="feeling-btn" onclick="selectFeeling('happy')">
                    <div class="feeling-icon happy">😊</div>
                    <span class="feeling-label">Happy</span>
                </button>
                <button class="feeling-btn" onclick="selectFeeling('calm')">
                    <div class="feeling-icon calm">☯️</div>
                    <span class="feeling-label">Calm</span>
                </button>
                <button class="feeling-btn" onclick="selectFeeling('manic')">
                    <div class="feeling-icon manic">🌪️</div>
                    <span class="feeling-label">Manic</span>
                </button>
                <button class="feeling-btn" onclick="selectFeeling('angry')">
                    <div class="feeling-icon angry">😠</div>
                    <span class="feeling-label">Angry</span>
                </button>
                <button class="feeling-btn" onclick="selectFeeling('sad')">
                    <div class="feeling-icon sad">😢</div>
                    <span class="feeling-label">Sad</span>
                </button>
            </div>
            <div id="encouragement-message" style="display:none; font-size:1rem; color:#888; margin-top:10px;"></div>
        <?php endif; ?>
    </div>
    <div class="emotion-journey-row">
        <div class="emotion-journey-info">
            <div class="emotion-title">Emotions journey for the last 30 days:</div>
            <div class="emotion-message" id="emotion-message">
                <?php
                    if($todayFeeling){
                        echo $encouragements[$todayFeeling];
                    } else {
                        echo "Keep up the positivity!";
                    }
                ?>
            </div>
        </div>
        <canvas id="emotionChart" class="emotion-chart"></canvas>
    </div>
    <div class="action-buttons">
        <button class="action-btn" onclick="location.href='unibot.php'">Unibot</button>
        <button class="action-btn" onclick="location.href='leisure.php'">Leisure</button>
    </div>
    <div class="calendar-section">
        <div class="calendar-title">Calendar</div>
        <div style="width:100%; text-align:center;">
            <span class="calendar-month">September</span>
        </div>
        <table class="calendar-table">
            <thead>
                <tr>
                    <th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th><th>Su</th>
                </tr>
            </thead>
            <tbody id="calendar-body">
                <!-- Calendar rows will be generated by JS -->
            </tbody>
        </table>
    </div>
    <?php include 'navigation.php' ?>
    <script>
        // Example notifications data (should match notification.php)
        let notifications = [
            { id: 1, title: "Admin", message: "Dear student, sorry to tell that the time of appointment is currently full, please reschedule a new......", time: "1 day" },
            { id: 2, title: "System", message: "Your appointment have successfully booked, please check your calendar!", time: "4 day" }
        ];

        // Check localStorage for read status
        function hasUnreadNotifications() {
            let readStatus = localStorage.getItem('notifReadStatus');
            readStatus = readStatus ? JSON.parse(readStatus) : {};
            return notifications.some(n => !readStatus[n.id]);
        }

        function updateNotificationBell() {
            document.getElementById('notificationRedDot').style.display = hasUnreadNotifications() ? 'block' : 'none';
        }

        function openNotifications() {
            // Mark all as seen for dashboard logic (optional)
            localStorage.setItem('notifSeen', 'true');
            window.location.href = 'notification.php';
        }

        // Call this on page load
        updateNotificationBell();

        // 1. Chart data from PHP
        const emotions = <?php echo json_encode($feeling_counts); ?>;
        const emotionColors = {
            happy: '#F48C8C',
            calm: '#A7D8F5',
            manic: '#B6E3C6',
            angry: '#FFD59E',
            sad: '#B7E5B7'
        };

        function updateEmotionChart() {
            const ctx = document.getElementById('emotionChart').getContext('2d');
            if (window.emotionChartInstance) window.emotionChartInstance.destroy();
            window.emotionChartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(emotions),
                    datasets: [{
                        data: Object.values(emotions),
                        backgroundColor: Object.values(emotionColors),
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '70%',
                    plugins: { legend: { display: false } }
                }
            });
        }

        // 2. Restrict feeling selection to once per day
        function selectFeeling(feeling) {
            // AJAX to save feeling to DB
            fetch('../Student/save_feeling.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'feeling_status=' + feeling
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    document.getElementById('feelings-question').textContent = "Thank you for sharing!";
                    document.getElementById('emotion-message').textContent = data.encouragement;
                    document.getElementById('feelings-options').style.display = "none";
                    document.getElementById('encouragement-message').textContent = data.encouragement;
                    document.getElementById('encouragement-message').style.display = "block";
                    // Optionally reload chart data
                    location.reload();
                } else {
                    alert("You already submitted your feeling today.");
                }
            });
        }

        // 3. Calendar booked dates from PHP
        const bookedDates = <?php echo json_encode($booked_dates); ?>;

        function generateCalendar() {
            const today = new Date();
            const year = today.getFullYear();
            const month = today.getMonth(); // September = 8
            const firstDay = new Date(year, month, 1).getDay(); // 0=Sun
            const daysInMonth = 30; // For September

            let html = '';
            let day = 1;
            for (let row = 0; row < 6; row++) {
                html += '<tr>';
                for (let col = 1; col <= 7; col++) {
                    let cellDay = (row === 0 && col < ((firstDay === 0 ? 7 : firstDay))) ? '' : day <= daysInMonth ? day : '';
                    let classes = '';
                    if (cellDay) {
                        // Format date for comparison
                        let cellDate = year + '-09-' + (cellDay < 10 ? '0' + cellDay : cellDay);
                        if (cellDay === today.getDate()) classes += ' calendar-today';
                        if (col === 6 || col === 7) classes += ' calendar-weekend';
                        if (bookedDates.includes(cellDate)) classes += ' calendar-booked';
                    }
                    html += `<td class="${classes}">${cellDay ? cellDay : ''}</td>`;
                    if (cellDay) day++;
                }
                html += '</tr>';
                if (day > daysInMonth) break;
            }
            document.getElementById('calendar-body').innerHTML = html;
        }

        // Initial render
        updateEmotionChart();
        generateCalendar();
    </script>
</body>
</html>