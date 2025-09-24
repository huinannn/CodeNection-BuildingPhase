<?php
    session_start();
    include '../conn.php';

    if(isset($_POST['login'])) {
        $admin_id = mysqli_real_escape_string($dbConn, trim($_POST['admin_id']));
        $password = mysqli_real_escape_string($dbConn, trim($_POST['password']));

        $query = "SELECT * FROM admin WHERE admin_id='$admin_id' AND admin_password='$password' LIMIT 1";
        $result = mysqli_query($dbConn, $query);

        if($result && mysqli_num_rows($result) > 0) {
            $school_id = (int)substr($admin_id, -3); 
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['school_id'] = $school_id;

            header("Location: reviews.php");
            exit();
        } else {
            header("Location: Login/tryagain.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Unicare</title>
    <link rel="stylesheet" href="Login/login.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<body>
    <div class="header-bar"></div>

    <div class="login-container">
        <div class="login-card">
            <img class="login-image" src="../image/logo.png" alt="Logo"/>

            <div class="login-title">Login</div>

            <form class="login-form" id="loginForm" action="" method="POST">
                <div class="input-group">
                    <label for="admin-id">Admin ID</label>
                    <div class="input-field">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="admin-id" name="admin_id" placeholder="Type here...">
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Type here...">
                    </div>
                </div>

                <div class="btn-row">
                    <button type="reset" class="btn btn-1 reset-btn">Reset</button>
                    <button type="submit" name="login" class="btn btn-2 login-btn">Login</button>
                </div>
            </form>

            <div id="snackbar">Please fill in all the required fields!</div>
        </div>
    </div>
    <script src="Login/login.js"></script>
</body>
</html>
