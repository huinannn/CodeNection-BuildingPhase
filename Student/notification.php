<?php
    session_start();
    include '../conn.php';
    if(!isset($_SESSION['student_id'])){
        header("Location: Login/login.php");
        exit();
    }

    $student_id = $_SESSION['student_id'];

    // Query notifications from notification_admin
    $sql = "
        SELECT na.booking_id, na.message, na.message_date_time 
        FROM notification_admin na
        INNER JOIN booking b ON na.booking_id = b.booking_id
        WHERE b.student_id = ?
        ORDER BY na.message_date_time DESC
    ";
    $stmt = $dbConn->prepare($sql);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = [
            'id' => $row['booking_id'], // unique key
            'title' => 'Admin',
            'message' => mb_strimwidth($row['message'], 0, 60, "..."), // preview
            'fullMessage' => $row['message'],
            'time' => timeAgo($row['message_date_time'])
        ];
    }
    $stmt->close();

    // function to convert datetime → "x day ago"
    function timeAgo($datetime) {
        $time = strtotime($datetime);
        $diff = time() - $time;

        if ($diff < 60) return $diff . " sec";
        $diff = floor($diff / 60);
        if ($diff < 60) return $diff . " min";
        $diff = floor($diff / 60);
        if ($diff < 24) return $diff . " hour";
        $diff = floor($diff / 24);
        return $diff . " day";
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notifications</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        body { font-family: 'Poppins', Arial, sans-serif; background: #FAF6F2; margin: 0; }
        .notif-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px 18px 0 18px;
        }
        .notif-header .back-arrow {
            font-size: 1.5rem;
            cursor: pointer;
        }
        .notif-title {
            font-size: 1.2rem;
            font-weight: 500;
            letter-spacing: 1px;
        }
        .notif-list {
            margin: 18px;
            padding: 0;
            list-style: none;
        }
        .notif-item {
            padding: 14px 0;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            position: relative;
        }
        .notif-item:last-child { border-bottom: none; }
        .notif-item .notif-title-row {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
        }
        .notif-item .notif-message {
            font-size: 0.97rem;
            color: #444;
            margin-bottom: 2px;
        }
        .notif-item .notif-time {
            font-size: 0.92rem;
            color: #aaa;
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 4px;
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
        /* Modal styles */
        .notif-modal-bg {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.08);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }
        .notif-modal {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 18px 18px 12px 18px;
            max-width: 350px;
            width: 90vw;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            position: relative;
        }
        .notif-modal .close-btn {
            position: absolute;
            top: 10px; right: 12px;
            font-size: 1.2rem;
            color: #888;
            cursor: pointer;
        }
        .notif-modal .notif-title-row {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 8px;
        }
        .notif-modal .notif-message-full {
            font-size: 0.97rem;
            color: #444;
            margin-bottom: 12px;
            white-space: pre-line;
        }
        .notif-modal .notif-time {
            font-size: 0.92rem;
            color: #aaa;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="notif-header">
        <span class="back-arrow" onclick="goBack()">&#8592;</span>
        <span class="notif-title">Notifications</span>
    </div>
    <ul class="notif-list" id="notifList"></ul>

    <!-- Modal for notification detail -->
    <div class="notif-modal-bg" id="notifModalBg">
        <div class="notif-modal">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <div class="notif-title-row" id="modalTitle"></div>
            <div class="notif-message-full" id="modalMessage"></div>
            <div class="notif-time" id="modalTime"></div>
        </div>
    </div>

    <script>
        // Simulate notifications data (could be loaded from backend)
        const notifications = <?php echo json_encode($notifications); ?>;

        // Use localStorage to track read/unread
        function getReadStatus() {
            let readStatus = localStorage.getItem('notifReadStatus');
            return readStatus ? JSON.parse(readStatus) : {};
        }
        function setReadStatus(status) {
            localStorage.setItem('notifReadStatus', JSON.stringify(status));
        }

        function renderNotifications() {
            const list = document.getElementById('notifList');
            list.innerHTML = '';
            const readStatus = getReadStatus();
            notifications.forEach(n => {
                const li = document.createElement('li');
                li.className = 'notif-item';
                li.onclick = () => openModal(n.id);

                // Title row
                const titleRow = document.createElement('div');
                titleRow.className = 'notif-title-row';
                titleRow.textContent = n.title;
                if (!readStatus[n.id]) {
                    const greenDot = document.createElement('span');
                    greenDot.className = 'notification-green-dot';
                    titleRow.appendChild(greenDot);
                }
                li.appendChild(titleRow);

                // Message preview
                const msg = document.createElement('div');
                msg.className = 'notif-message';
                msg.textContent = n.message;
                li.appendChild(msg);

                // Time
                const timeRow = document.createElement('div');
                timeRow.className = 'notif-time';
                timeRow.textContent = n.time;
                li.appendChild(timeRow);

                list.appendChild(li);
            });
        }

        function openModal(id) {
            const n = notifications.find(x => x.id === id);
            if (!n) return;
            document.getElementById('modalTitle').textContent = n.title;
            document.getElementById('modalMessage').textContent = n.fullMessage;
            document.getElementById('modalTime').textContent = n.time + " ago";
            document.getElementById('notifModalBg').style.display = 'flex';

            // Mark as read
            const readStatus = getReadStatus();
            readStatus[n.id] = true;
            setReadStatus(readStatus);
            renderNotifications();
        }

        function closeModal() {
            document.getElementById('notifModalBg').style.display = 'none';
        }

        function goBack() {
            window.location.href = 'dashboard.php';
        }

        // On page load, mark all as "seen" so dashboard red dot disappears
        window.onload = function() {
            renderNotifications();
            // Optionally, mark all as seen for dashboard logic
            localStorage.setItem('notifSeen', 'true');
        };
    </script>
</body>
</html>