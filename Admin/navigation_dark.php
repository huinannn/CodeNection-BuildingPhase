<!-- To use this navigation.php, 
    in your file at the top of <body> add:
    include 'navigation.php' 
    in php environment,
    make sure your page has 300px margin left for the sidebar!-->

<?php
    session_start();
    include '../conn.php';

    $admin_id = $_SESSION['admin_id'];
    $school_id = $_SESSION['school_id'];

    $school_sql = "SELECT * FROM school WHERE school_id = ?";
    $school_stmt = $dbConn->prepare($school_sql);
    $school_stmt->bind_param("i", $school_id);
    $school_stmt->execute();
    $school_result = $school_stmt->get_result();

    $school_name = "";
    $school_logo = "";
    if ($row = $school_result->fetch_assoc()) {
    $school_name = $row['school_name'];
    $school_logo = $row['school_logo'];
    }
?>

<link rel="stylesheet" href="style.css" />

<style>
    body {
        background-color: #212934 !important;
    }

    p {
        color: white;
        margin: 0;
    }

    .side-nav .nav li.active p {
        color: black;
    }
</style>

<div class="side-nav">
    <div class="logo">
        <img src="../image/favicon.png" alt="Unicare">
    </div>
    <ul class="nav">
        <li data-page="StudentAccount/studentaccount.php"><img src="../image/icons/student.png" alt=""><p>Student Accounts</p></li>
        <li data-page="bookings.php"><img src="../image/icons/booking.png" alt=""><p>Bookings</p></li>
        <li data-page="reviews.php"><img src="../image/icons/reviews.png" alt=""><p>Reviews</p></li>
        <li data-page="check-in.php"><img src="../image/icons/check-in.png" alt=""><p>Personal Check-In</p></li>
    </ul>
    <div class="spacer"></div>
    <ul class="other">
        <li class="school">
            <img src="../image/school_logo/<?php echo htmlspecialchars($school_logo); ?>" alt="School Logo">
            <p><?php echo htmlspecialchars($school_name); ?></p>
        </li>
    </ul>
    <div class="horizontal"></div>
    <ul class="other">
        <li class="logout" onclick="window.location.href = 'Login/logout.php'">
            <p>LOG OUT</p> &nbsp; &nbsp; &nbsp;<img src="../image/icons/logout.png">
        </li>
    </ul>
</div>

<div class="main-content" style="display: none;">
    This site is not available on small screens 📱 (Only available on 1000px screens & above)
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Alert for small screens
        function checkScreenSize() {
            if (window.innerWidth < 1000) {
                alert("⚠️ This site is only available on screens 1000px and above! Please use a computer to access.");
            }
        }
        checkScreenSize();
        window.addEventListener("resize", checkScreenSize);

        // Select all nav tabs
        const tabs = document.querySelectorAll(".side-nav .nav li");

        // Determine current page filename
        const currentPage = window.location.pathname.split("/").pop().split("?")[0]; 

        function setActiveTab(tab) {
            tabs.forEach(t => t.classList.remove("active"));
            tab.classList.add("active");
        }

        let matched = false;
        tabs.forEach(tab => {
            const target = tab.getAttribute("data-page"); 
            if (target === currentPage) {
                setActiveTab(tab);
                matched = true;
            }

            // Handle click navigation
            tab.addEventListener("click", () => {
                setActiveTab(tab);
                if (target) {
                    window.location.href = target;
                }
            });
        });

        // Default to first tab if no match
        if (!matched && tabs.length > 0) {
            setActiveTab(tabs[0]);
        }
    });
</script>