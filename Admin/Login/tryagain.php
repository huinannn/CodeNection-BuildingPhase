<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Failed</title>
    <link rel="stylesheet" href="login.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="main-content" style="display: none;"> 
        This site is not available on small screens 📱 (Only available on 1000px screens & above) 
    </div>

    <div class="header-bar"></div>

    <div class="login-container">
        <div class="login-card">
            <i class="fa-solid fa-triangle-exclamation icon"></i>

            <div class="login-title">Login failed</div>

            <div class="login-content">
                Your id or password are incorrect!
            </div>

            <div class="button">
                <button class="btn btn-2 login-btn" onclick="window.location.href='../index.php'">
                    Try again
                </button>
            </div>
        </div>
    </div>
    <script src="../StudentAccount/studentaccount.js"></script>
</body>
</html>