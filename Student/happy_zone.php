<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Unicare</title>
    <link rel="icon" href="image/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="confessions">
      <div class="header">
        <div class="header_left">
          <img src="image/icons/sun.png" alt="">
          <h1>Happy Zone</h1>
        </div>
        <div class="spacer"></div>
        <div class="header_right">
          <img src="image/icons/user.png" alt="">
          <div class="dark_light">
            <div class="dark_light">
              <input type="checkbox" onchange="goSadCorner(this)">
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="each_content" onclick="window.location.href='#'">
          <img src="image/confessions/happy.jpg" alt="">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        </div>
        <div class="each_content" onclick="window.location.href='#'">
          <img src="image/confessions/happy.jpg" alt="">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        </div>
        <div class="each_content" onclick="window.location.href='#'">
          <img src="image/confessions/happy.jpg" alt="">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        </div>
        <div class="each_content" onclick="window.location.href='#'">
          <img src="image/confessions/happy.jpg" alt="">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        </div>
        <div class="each_content" onclick="window.location.href='#'">
          <img src="image/confessions/happy.jpg" alt="">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        </div>
        <div class="each_content" onclick="window.location.href='#'">
          <img src="image/confessions/happy.jpg" alt="">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        </div>
        <div class="each_content" onclick="window.location.href='#'">
          <img src="image/confessions/happy.jpg" alt="">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        </div>
        <div class="each_content" onclick="window.location.href='#'">
          <img src="image/confessions/happy.jpg" alt="">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        </div>
        <div class="each_content" onclick="window.location.href='#'">
          <img src="image/confessions/happy.jpg" alt="">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        </div>
        <div class="each_content" onclick="window.location.href='#'">
          <img src="image/confessions/happy.jpg" alt="">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        </div>
        <div class="each_content" onclick="window.location.href='#'">
          <img src="image/confessions/happy.jpg" alt="">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        </div>
        <div class="each_content" onclick="window.location.href='#'">
          <img src="image/confessions/happy.jpg" alt="">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        </div>
        <div class="each_content" onclick="window.location.href='#'">
          <img src="image/confessions/happy.jpg" alt="">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        </div>
      </div>
      <div class="end">
        <div class="line"></div>
        <!-- <br> <span onclick="">Refresh!</span> -->
        <p>Nothing new to see</p>
        <div class="line"></div>
      </div>
    </div>
    <!-- Warning for Sad Corner -->
     <div class="overlay" id="overlay">
      <div class="popup">
        <p>This space is for sharing struggles. It may feel heavy!</p>
        <p>Are you feeling ready to continue?</p>
        <button class="confirm" id="confirmBtn"><div class="spacer"></div>Yes, I'm ready!</button> 
        <button id="cancelBtn"><div class="spacer"></div>No, I'll stay positive</button>
      </div>
     </div>
    <script>
      const overlay = document.getElementById("overlay");
      const confirmBtn = document.getElementById("confirmBtn");
      const cancelBtn = document.getElementById("cancelBtn");
      function goSadCorner(checkbox) {
        if (checkbox.checked) {
          overlay.style.display = "flex";
        }
      }

      confirmBtn.addEventListener("click", function() {
        window.location.href = "sad_corner.php";
      });

      cancelBtn.addEventListener("click", function() {
        overlay.style.display = "none";
        document.querySelector('input[type="checkbox"]').checked = false;
      })

      document.querySelector('input[type="checkbox"]').checked = false;
    </script>
    <?php include 'navigation.php'; ?>
</body>
</html>