<?php
    session_start();
    include '../conn.php';
    if(!isset($_SESSION['student_id'])){
        header("Location: Login/login.php");
        exit();
    }

    $student_id = $_SESSION['student_id'];
    $todayDate = date('Y-m-d');

    // Get booked dates for calendar
    $booked_query = "SELECT DATE(booking_date) as date FROM booking WHERE student_id = ?";
    $stmt = $dbConn->prepare($booked_query);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $booked_dates = [];
    while($row = $result->fetch_assoc()){
        $booked_dates[] = $row['date'];
    }
    $stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Book Counselling</title>
    <link rel="icon" href="image/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Itim', cursive; background: #fff; margin: 0; padding-bottom: 25%; }
        /* body { font-family: 'Itim', cursive; background: #fff; margin: 0; padding-bottom: 25%; } */
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
        .profile-dropdown {
            position: relative;
            cursor: pointer;
        }

        .profile-dropdown-content {
            display: none;
            position: absolute;
            top: 36px;
            right: 0;
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
            font-size: 0.95rem;
            font-weight: normal;
        }

        .profile-dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .profile-dropdown:hover .profile-dropdown-content {
            display: block;
        }

        .profile-dropdown-content a.logout-link {
            display: flex;
            align-items: center;
            gap: 15px; 
            text-decoration: none;
            color: #000; 
            font-size: 0.95rem;
        }

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

        @media (max-width: 500px) {
            .calendar-section { margin: 10px; }
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        Counselling
        <div class="dashboard-icons">
            
            <div class="profile-dropdown">
                <img src="../image/icons/profile.png" alt="Profile" />
                <div class="profile-dropdown-content">
                     <a href="../Student/Login/logout.php" class="logout-link">
                        <i class="fa-solid fa-right-from-bracket"></i> Log Out
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <!-- your code -->
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
        // Calendar booked dates from PHP
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

        generateCalendar();
    </script>
</body>
</html>