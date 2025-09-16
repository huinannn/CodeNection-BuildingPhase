<!-- To use this navigation.php, 
    in your file at the bottom of <body> add:
    include 'navigation.php' 
    in php environment -->

<div class="bottom_nav">
    <div class="nav">
        <div class="each_nav" onclick="window.location.href='answers.php'">
            <img src="../image/icons/answers.png" alt="">
            <p>Answers</p>
        </div>
        <div class="each_nav" onclick="window.location.href='confessions.php'">
            <img src="../image/icons/confessions.png" alt="">
            <p>Confessions</p>
        </div>
        <div class="each_nav" onclick="window.location.href='dashboard.php'">
            <img src="../image/icons/home.png" alt="">
            <p>Home</p>
        </div>
        <div class="each_nav" onclick="window.location.href='leisure.php'">
            <img src="../image/icons/leisure.png" alt="">
            <p>Leisure</p>
        </div>
        <div class="each_nav" onclick="window.location.href='counseling.php'">
            <img src="../image/icons/counseling.png" alt="">
            <p>Counseling</p>
        </div>
    </div>
</div>
<script>
    const tabs = document.querySelectorAll('.bottom_nav .nav .each_nav');

    tabs.forEach(tab => {
        // Set click event
        tab.addEventListener('click', () => {
            tabs.forEach(t => {
                t.classList.remove('active');
                const img = t.querySelector('img');
                const name = t.querySelector('p').innerText.toLowerCase();
                img.src = `../image/icons/${name}.png`;
            });

            // Set active tab
            tab.classList.add('active');
            const activeImg = tab.querySelector('img');
            const activeName = tab.querySelector('p').innerText.toLowerCase();
            activeImg.src = `../image/icons/${activeName}_brown.png`;
        });
    });

    // Set Home as default active
    const homeTab = Array.from(tabs).find(t => t.querySelector('p').innerText === 'Home');
    if (homeTab) {
        homeTab.classList.add('active');
        const img = homeTab.querySelector('img');
        img.src = '../image/icons/home_brown.png';
    }

</script>