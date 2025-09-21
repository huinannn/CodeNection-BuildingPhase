<?php
    $quote = "🌱 Every day is a new chance to grow stronger, calmer, and happier 🌱";

    try {
        $response = @file_get_contents("https://zenquotes.io/api/random");
        if ($response !== false) {
            $data = @json_decode($response, true);
            if (isset($data[0]['q']) && isset($data[0]['a'])) {
                $quote = "🌱 " . $data[0]['q'] . " — " . $data[0]['a'] . " 🌱";
            }
        }
    } catch (Exception $e) {
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
        <link rel="stylesheet" href="../style.css" />
        <link rel="stylesheet" href="login.css" />
    </head>
    <body>
        <div class="welcome">
            <img class="logo" src="../../image/logo.png" alt="">
            
            <div class="outline-box"></div>

            <div class="text">
                <span>Welcome to </span>
                <span class="highlight">Unicare</span>
                <span>!</span>
            </div>

            <div class="subsubtext"><?= htmlspecialchars($quote) ?></div>

            <a href="../dashboard.php" class="button">Okay</a>
        </div>
    </body>
</html>