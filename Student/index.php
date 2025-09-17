<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Unicare</title>
    <link rel="icon" href="../image/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="index">
        <img src="../image/logo.png" alt="">
        <div class="spinner_container" style="margin-top: 100px">
            <div class="spinner"></div>
        </div>
    </div>
    <script>
        const container = document.querySelector('.index');

        setTimeout(() => {
            container.classList.add('loading');
        }, 2000);

        setTimeout(() => {
            window.location.href = 'test.php';
        }, 3000);
    </script>
</body>
</html>