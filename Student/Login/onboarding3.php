<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Unicare</title>
        <link rel="stylesheet" href="login.css" />
    </head>
    <body>
        <div class="onboarding" data-page="onboarding3">
            <a href="login.php" class="skip">Skip</a>

            <div class="progress">
                <div class="progress-bar">
                    <div class="active"></div>
                    <div class="active"></div>
                    <div class="active"></div>
                </div>
                    <div class="progress-text">3/3</div>
            </div>

            <div class="title">Getting Support</div>

            <div class="subtitle">How would you like to start today?</div>

            <form class="options">
                <label class="option">
                    <input type="checkbox"/>
                    <span class="custom-box"></span>
                    📖 Quick tips & guidance
                </label>

                <label class="option">
                    <input type="checkbox"/>
                    <span class="custom-box"></span>
                    💭 Share your thoughts freely
                </label>

                <label class="option">
                    <input type="checkbox"/>
                    <span class="custom-box"></span>
                    🎮 Relax with calming activities
                </label>

                <label class="option">
                    <input type="checkbox"/>
                    <span class="custom-box"></span>
                    🗨️ Guided support & advice
                </label>

                <label class="option">
                    <input type="checkbox"/>
                    <span class="custom-box"></span>
                    ✨ Others
                </label>
            </form>

            <div class="btn-row">
                <a href="onboarding2.php" class="btn btn-1">Back</a>
                <a href="login.php" class="btn btn-2">Finish</a>
            </div>
        </div>
    </body>
    <script src="login.js"></script>
</html>