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

    $sql = "SELECT student_id, student_name, student_account_status, last_login_date, last_login_time
            FROM student
            WHERE school_id = ?
            ORDER BY student_id";
    $stmt = $dbConn->prepare($sql);
    $stmt->bind_param("i", $school_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $student_id = $row['student_id'];

        if ($row['last_login_date'] === '0000-00-00' || $row['last_login_time'] === '00:00:00') {
            $lastLogin = 'not login';
            $status = 'not login';
        } else {
            $lastLoginTimestamp = strtotime($row['last_login_date'] . ' ' . $row['last_login_time']);
            $oneMonthAgo = strtotime('-1 month');

            $status = ($lastLoginTimestamp < $oneMonthAgo) ? 'inactive' : 'active';
            $lastLogin = date("d M Y", strtotime($row['last_login_date'])) . ", " . date("H:i", strtotime($row['last_login_time']));
        }

        $students[] = [
            'student_id' => $student_id,
            'student_name' => $row['student_name'],
            'student_account_status' => $status,
            'lastLogin' => $lastLogin
        ];

        $update_sql = "UPDATE student SET student_account_status = ? WHERE student_id = ?";
        $update_stmt = $dbConn->prepare($update_sql);
        $update_stmt->bind_param("ss", $status, $student_id);
        $update_stmt->execute();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Unicare</title>
    <link rel="icon" href="../../image/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="studentaccount.css" />
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
            <li data-page="../reviews.php"><img src="../../image/icons/reviews.png" alt=""><p>Reviews</p></li>
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
            <div class="student-title">Student Accounts</div>
            <div class="actions">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input type="text" id="searchInput" placeholder="Search here...">
                </div>
                <button class="icon-btn" onclick="window.location.href='addstudent.php'">
                    <i class="fa-solid fa-user-plus"></i> Add New
                </button>
            </div>
        </div>

        <div class="student-list-container">
            <div class="student-list">
                <table id="studentTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Account Status</th>
                            <th>Last Login</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php
                            $i = 1;
                            foreach ($students as $row) {
                                $statusClass = strtolower(str_replace(' ', '-', $row['student_account_status']));
                                echo "<tr>
                                        <td>{$i}</td>
                                        <td>{$row['student_id']}</td>
                                        <td>{$row['student_name']}</td>
                                        <td><span class='status {$statusClass}'>{$row['student_account_status']}</span></td>
                                        <td>{$row['lastLogin']}</td>
                                    </tr>";
                                $i++;
                            }
                            ?>
                    </tbody>
                </table>

                <div id="notFoundContainer">
                    <i class="fa-solid fa-magnifying-glass notfound-icon"></i>
                    <div class="notfound-text">Not Found</div>
                </div>
            </div>
        </div>
    </div>
    <script src="studentaccount.js"></script>
</body>
</html>