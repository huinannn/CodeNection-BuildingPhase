<?php
    session_start();
    include '../../conn.php';

    $error = $_SESSION['error'] ?? '';
    $prev_student_id = $_SESSION['prev_student_id'] ?? '';
    $prev_school_id = $_SESSION['prev_school_id'] ?? '';
    $prev_password = $_SESSION['prev_password'] ?? '';

    $schools = mysqli_query($dbConn, "SELECT * FROM school");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Failed</title>
    <link rel="icon" href="../../image/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="login.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div id="snackbar"><span></span></div>

    <div class="login">
        <img class="picture" src="../../image/logo.png" alt="Logo">
        <div class="text"><span>Login Failed</span></div>

        <form method="POST" action="login.php" id="loginForm">
            <div class="form">
                <div class="input-label">
                    <label>Student ID</label>
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" value="<?= htmlspecialchars($prev_student_id) ?>" readonly>
                    </div>
                </div>

                <div class="input-label">
                    <label>School Name</label>
                    <div class="input-icon">
                        <i class="fas fa-building"></i>
                        <select disabled>
                            <?php while($row = mysqli_fetch_assoc($schools)): ?>
                                <option value="<?= $row['school_id'] ?>" <?= ($prev_school_id==$row['school_id'])?'selected':'' ?>>
                                    <?= $row['school_name'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="input-label">
                    <label>Password</label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" value="<?= htmlspecialchars($prev_password) ?>" readonly>
                    </div>
                </div>

                <div class="button-tryagain">
                    <button type="button" id="tryAgain" class="btn btn-2">Try Again</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        window.SUCCESS = "";
        window.ERROR = "<?= $error ?>";

        document.addEventListener('DOMContentLoaded', () => {
            const tryBtn = document.getElementById('tryAgain');
            tryBtn.addEventListener('click', () => {
                <?php
                    unset($_SESSION['prev_student_id']);
                    unset($_SESSION['prev_school_id']);
                    unset($_SESSION['prev_password']);
                    unset($_SESSION['error']);
                ?>
                window.location.href = 'login.php';
            });
        });
    </script>
    <script src="login.js"></script>
</body>
</html>