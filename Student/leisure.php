<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Unicare</title>
    <link rel="icon" href="image/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="leisure.css" />
</head>
<body>
<div class="leisure">
    <div class="header" style="background-color: white;">
        <div class="header1">
            <h1 style="padding-left:10px">Leisure</h1>
            <img src="../image/leisure/Leisure.png" alt="Leisure Icon" class="leisure-icon">
        </div>
        <div class="header2">
            <div class="header-scroller">
                <button class="All active">All</button>
                <button class="Sleep">Sleep</button>
                <button class="Game">Game</button>
                <button class="Music">Music</button>
                <button class="Breathing">Breathing</button>
                <button class="Meditation">Meditation</button>
            </div>
        </div>
    </div>

    <div class="content">
       <a href="calm-meditation.php" class="leisure-card" style="width:175px" data-category="Breathing,Meditation,Sleep">
            <img src="../image/leisure/Meditation.jpg" alt="Calm Meditation">
            <p>Calm Meditation</p>
        </a>

        <a href="Splash.html" class="leisure-card" style="width:175px" data-category="Game">
            <img src="../image/leisure/Splash.jpg" alt="Colour Splash">
            <p>Colour Splash</p>
        </a>

        <a href="Lucky_Scratch.html" class="leisure-card" style="width:175px" data-category="Game">
            <img src="../image/leisure/Lucky.jpg" alt="lucky-scratch">
            <p>Lucky Scratch</p>
        </a>
        <a href="Motivation_Music.html" class="leisure-card" style="width:175px" data-category="Music">
            <img src="../image/leisure/Motivation.jpg" alt="Motivation-music">
            <p>Motivation Music</p>
        </a>
        
        <a href="RandomThrow.html" class="leisure-card" style="width:175px" data-category="Game">
            <img src="../image/leisure/Throw.jpg" alt="Random_Throw">
            <p>Random Throw</p>
        </a>

        <a href="Squishy.html" class="leisure-card" style="width:175px" data-category="Game">
            <img src="../image/leisure/Squishy.jpg" alt="Squishy">
            <p>Squish & Bounce</p>
        </a>
    </div>

    <div class="space" style="padding-bottom:100px;"></div>
</div>

<?php include 'navigation.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.header-scroller button');
    const cards = document.querySelectorAll('.leisure-card');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const category = btn.textContent;

            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            cards.forEach(card => {
                const categories = card.dataset.category.split(',');

                if(category === 'All' || categories.includes(category)) {
                    card.style.display = 'inline-block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>
</body>
</html>