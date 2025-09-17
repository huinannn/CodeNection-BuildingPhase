<!-- To use this navigation.php, 
    in your file at the bottom of <body> add:
    include 'navigation.php' 
    in php environment -->

<link rel="stylesheet" href="style.css" />
<style>
    .bottom_nav .nav {
        background-color: #1e293b !important;
    }

    .bottom_nav .nav .each_nav p {
        color: white !important;
    }

    .bottom_nav .nav .each_nav.active p {
        color: var(--primary) !important;
    }
</style>
<div class="bottom_nav">
    <div class="nav">
        <div class="each_nav" onclick="window.location.href='answers.php'">
            <img src="image/icons/answers_white.png" alt="">
            <p>Answers</p>
        </div>
        <div class="each_nav" onclick="window.location.href='sad_corner.php'">
            <img src="image/icons/confessions_white.png" alt="">
            <p>Confessions</p>
        </div>
        <div class="each_nav" onclick="window.location.href='dashboard.php'">
            <img src="image/icons/home_white.png" alt="">
            <p>Home</p>
        </div>
        <div class="each_nav" onclick="window.location.href='leisure.php'">
            <img src="image/icons/leisure_white.png" alt="">
            <p>Leisure</p>
        </div>
        <div class="each_nav" onclick="window.location.href='counseling.php'">
            <img src="image/icons/counseling_white.png" alt="">
            <p>Counseling</p>
        </div>
    </div>
</div>
<script>
    const tabs = document.querySelectorAll('.bottom_nav .nav .each_nav');

    // Function to set active tab
    function setActiveTab(tab) {
        tabs.forEach(t => {
            t.classList.remove('active');
            const img = t.querySelector('img');
            const name = t.querySelector('p').innerText.toLowerCase();
            img.src = `image/icons/${name}_white.png`;
        });

        tab.classList.add('active');
        const activeImg = tab.querySelector('img');
        const activeName = tab.querySelector('p').innerText.toLowerCase();
        activeImg.src = `image/icons/${activeName}_brown.png`;
    }

    // Highlight the correct tab based on current URL
    const currentPage = window.location.pathname.split('/').pop().split('?')[0]; 
    // e.g. "happy_zone.php" (ignores query params like ?id=123)

    let matched = false;
    tabs.forEach(tab => {
        const hrefMatch = tab.getAttribute('onclick').match(/'([^']+)'/);
        if (hrefMatch && hrefMatch[1] === currentPage) {
            setActiveTab(tab);
            matched = true;
        }
    });

    // If no match found, default to Home
    if (!matched) {
        const homeTab = Array.from(tabs).find(t => t.querySelector('p').innerText === 'Home');
        if (homeTab) {
            setActiveTab(homeTab);
        }
    }

</script>