<?php
    session_start();
    include '../../conn.php';

    if (!isset($_SESSION['admin_id'])) {
        header("Location: ../index.php");
        exit();
    }

    $admin_id = $_SESSION['admin_id'];
    $admin_sql = "SELECT s.*
                FROM admin a 
                JOIN school s ON a.school_id = s.school_id 
                WHERE a.admin_id = ?";
    $admin_stmt = $dbConn->prepare($admin_sql);
    $admin_stmt->bind_param("s", $admin_id);
    $admin_stmt->execute();
    $admin_result = $admin_stmt->get_result();

    if ($row = $admin_result->fetch_assoc()) {
        $school_id = $row['school_id'];
        $school_name = $row['school_name'];
        $school_logo = $row['school_logo'];
    }

    $prefix = 'ST'; 

    if (stripos($school_name, 'Asia Pacific University') !== false) {
        $prefix = 'TP';
    } elseif (preg_match('/\((.*?)\)/', $school_name, $matches)) {
        $prefix = strtoupper($matches[1]);
    }

    $id_sql = "SELECT student_id 
                FROM student 
                WHERE student_id LIKE ? 
                ORDER BY CAST(SUBSTRING(student_id, LENGTH(?) + 1) AS UNSIGNED) DESC
                LIMIT 1";
    $id_stmt = $dbConn->prepare($id_sql);
    $likePattern = $prefix . '%';
    $id_stmt->bind_param("ss", $likePattern, $prefix);
    $id_stmt->execute();
    $id_result = $id_stmt->get_result();
    $id_row = $id_result->fetch_assoc();

    if ($id_row && isset($id_row['student_id'])) {
        $last_id = $id_row['student_id'];
        $num = (int)substr($last_id, strlen($prefix)); 
        $num++;
        $new_student_id = $prefix . str_pad($num, 4, '0', STR_PAD_LEFT);
    } else {
        $new_student_id = $prefix . '0001';
    }

    $success = false;
    $showSnackbar = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $student_name = $_POST['student_name'] ?? '';
        $student_password = $_POST['student_password'] ?? '';

        if ($student_name && $student_password) {
            $account_status = 'not login';
            $last_login_date = '0000-00-00';
            $last_login_time = '00:00:00';

            $insert_sql = "INSERT INTO student 
                (student_id, student_name, student_password, student_account_status, last_login_date, last_login_time, school_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = $dbConn->prepare($insert_sql);
            $insert_stmt->bind_param("ssssssi", $new_student_id, $student_name, $student_password, $account_status, $last_login_date, $last_login_time, $school_id);
            $insert_stmt->execute();

            $success = true;
        } else {
            $showSnackbar = true; 
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unicare</title>
    <link rel="icon" href="../../image/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="studentaccount.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="side-nav">
        <div class="logo">
            <img src="../../image/logo.png" alt="">
        </div>
        <ul class="nav">
            <li data-page="studentaccount.php"><img src="../../image/icons/student.png" alt=""><p>Student Accounts</p></li>
            <li data-page="../bookings.php"><img src="../../image/icons/booking.png" alt=""><p>Bookings</p></li>
            <li data-page="../reviews_post_happy.php"><img src="../../image/icons/reviews.png" alt=""><p>Reviews</p></li>
            <li data-page="../check-in.php"><img src="../../image/icons/check-in.png" alt=""><p>Personal Check-In</p></li>
        </ul>
        <div class="spacer"></div>
        <ul class="other">
            <li class="school"><img src="../../image/school_logo/<?php echo $school_logo ?>" alt=""><p><?php echo $school_name ?></p></li>
        </ul>
        <div class="horizontal"></div>
        <ul class="other">
            <li class="logout" onclick="window.location.href = '../Login/logout.php'"><p>LOG OUT</p> &nbsp; &nbsp; &nbsp;<img src="../../image/icons/logout.png"></li>
        </ul>
    </div>

    <div class="main-content" style="display: none;"> 
        This site is not available on small screens 📱 (Only available on 1000px screens & above) 
    </div>

    <div class="content">
        <div class="student-header">
            <div class="student-title">Add New Student Account</div>
            <?php if (!$success) : ?>
                <div class="actions">
                    <button class="icon-btn" onclick="window.location.href='studentaccount.php'">
                        <i class="fa-solid fa-arrow-left"></i> Back
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <div class="add-list-container">
            <?php if ($success) : ?>
                <div class="success-box">
                    <div class="icon-check">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="title">Student Account Added</div>
                    <div class="message">The new student account is added successfully!</div>
                    <button class="add-btn" onclick="window.location.href='studentaccount.php'">Finish</button>
                </div>

            <?php else : ?>
                <div class="page-title">Add New Student Account</div>
                <form class="student-form" method="POST" action="addstudent.php">
                    <div class="form-group">
                        <label>Student ID</label>
                        <div class="input-with-icon">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="student_id" value="<?php echo $new_student_id; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Student Name</label>
                        <div class="input-with-icon">
                            <i class="fa-solid fa-id-card"></i>
                            <input type="text" name="student_name" placeholder="Type here...">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Student Password</label>
                        <div class="input-with-icon">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" name="student_password" placeholder="Type here...">
                        </div>
                    </div>

                    <button type="submit" class="add-btn">Add</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <div id="snackbar">Please fill in all the required fields!</div>
    
    <script>
        <?php if (!empty($showSnackbar) && $showSnackbar): ?>
            const snackbar = document.getElementById('snackbar');
            snackbar.classList.add('show');
            setTimeout(() => {
                snackbar.classList.remove('show');
            }, 3000);
        <?php endif; ?>
    </script>
    <script src="studentaccount.js"></script>
</body>
</html>