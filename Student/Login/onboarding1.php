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
        <div class="onboarding" data-page="onboarding1">
            <a href="login.php" class="skip">Skip</a>

            <div class="progress">
                <div class="progress-bar">
                    <div class="active"></div>
                    <div></div>
                    <div></div>
                </div>
                    <div class="progress-text">1/3</div>
            </div>

            <div class="title">Wellbeing</div>

            <div class="subtitle">What would you like to focus on?</div>

            <form class="options">
                <label class="option">
                    <input type="checkbox"/>
                    <span class="custom-box"></span>
                    🌱 Manage stress & anxiety
                </label>

                <label class="option">
                    <input type="checkbox"/>
                    <span class="custom-box"></span>
                    📚 Handle exam pressure
                </label>

                <label class="option">
                    <input type="checkbox"/>
                    <span class="custom-box"></span>
                    🤝 Improve relationships & social life
                </label>

                <label class="option">
                    <input type="checkbox"/>
                    <span class="custom-box"></span>
                    🌞 Feel more positive & motivated
                </label>

                <label class="option">
                    <input type="checkbox" />
                    <span class="custom-box"></span>
                    ✨ Others
                </label>
            </form>

            <div class="btn-row">
                <a href="welcome.php" class="btn btn-1">Back</a>
                <a href="onboarding2.php" class="btn btn-2">Continue</a>
            </div>
        </div>
    </body>
    <script src="login.js"></script>
</html>