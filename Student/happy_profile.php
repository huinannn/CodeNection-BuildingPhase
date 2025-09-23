<?php
session_start();
include '../conn.php';


if (!isset($_SESSION['student_id'])) {
    // Not logged in, redirect to login page
    header("Location: Login/login.php");
    exit();
}

$student_id = "";
$student_name = "";
$confessions = [];

if (isset($_SESSION['student_id'])) {
    $id = $_SESSION['student_id'];

    $sql = 'SELECT c.*, s.student_name
            FROM confession c
            JOIN student s ON c.student_id = s.student_id
            WHERE c.mode = "happy" 
              AND c.confession_status = "approved" 
              AND c.student_id = ?
            ORDER BY c.confession_date_time DESC;';
    $stmt = $conn->prepare($sql);  
    $stmt->bind_param('s', $id);   
    $stmt->execute();             
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // fetch first row to extract student info
        $firstRow = $result->fetch_assoc();
        $student_id = $firstRow['student_id'];
        $student_name = $firstRow['student_name'];

        // put the first row into confessions array
        $confessions[] = $firstRow;

        // fetch rest of confessions
        while ($row = $result->fetch_assoc()) {
            $confessions[] = $row;
        }
    } else {
        $student_sql = 'SELECT student_name
                FROM student
                WHERE student_id = ?';
        $student_stmt = $conn->prepare($student_sql);
        $student_stmt->bind_param('s', $id);
        $student_stmt->execute();
        $student_result = $student_stmt->get_result();

        if ($student_result->num_rows > 0) {
            $row = $student_result->fetch_assoc();
            $student_id = $id;
            $student_name = $row['student_name'];
        }

    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Unicare</title>
    <link rel="icon" href="../image/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="style.css" />
    <style>
        .img {
            background-color: #F6DCA8;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;              
            justify-content: center;  
            align-items: center; 
        }

        .img img {
            width: 50px !important;
            height: 50px !important;
        }

        .header_left, .header_right {
            margin-top: 50px;
        }

        .vertical {
            margin: 0 10px;
            width: 3px;
            height: 50px;
            background-color: #C96319B3;
        }
        
        .profile p {
            margin: 0;
            font-size: 13px;
            font-weight: 600;
        }

        .header_right img {
            width: 25px !important;
            height: 25px !important;
            margin-right: 10px;
        }

        .content {
            margin-top: 180px !important;
        }
    </style>
</head>
<body>
    <div class="confessions">
        <div class="header">
            <div class="back" onclick="window.location.href='happy_zone.php'">
                <img src="../image/icons/back.png" alt="">
            </div>
            <div class="header_left">
                <div class="img" >
                    <img src="../image/icons/profile.png" alt="">
                </div>
                <div class="vertical"></div>
                <div class="profile">
                    <p><?php echo $student_id ?></p>
                    <p><?php echo $student_name ?></p>
                </div>
            </div>
            <div class="spacer"></div>
            <div class="header_right">
                <img src="../image/icons/add.png" alt="" onclick="window.location.href='happy_add.php';">
            </div>
        </div>
        <div class="content">
            <?php
                if (!empty($confessions)) {
                    foreach ($confessions as $row) {
            ?>
            <div class="each_content" onclick="window.location.href='#'">
                <img src="../image/confessions/happy/<?php echo $row['confession_post'] ?>" alt="">
                <p><?php echo $row['confession_title'] ?></p>
            </div>
            <?php
                    }
                }
            ?>
        </div>
        <div class="end">
            <div class="line"></div>
            <!-- <br> <span onclick="">Refresh!</span> -->
            <p>End</p>
            <div class="line"></div>
        </div>
    </div>
</body>
</html>