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
        <title>Unicare</title>
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