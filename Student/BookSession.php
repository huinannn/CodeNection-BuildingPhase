<?php
session_start();
include '../conn.php';
if(!isset($_SESSION['student_id'])){
    header("Location: Login/login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Get student school
$studentQuery = $dbConn->prepare("SELECT school_id FROM student WHERE student_id = ?");
$studentQuery->bind_param("s", $student_id);
$studentQuery->execute();
$studentResult = $studentQuery->get_result()->fetch_assoc();
$school_id = $studentResult['school_id'];
$studentQuery->close();

// Get counselors for this school
$counselorQuery = $dbConn->prepare("SELECT counselor_id, counselor_name FROM counselor WHERE school_id = ?");
$counselorQuery->bind_param("i", $school_id);
$counselorQuery->execute();
$counselorResult = $counselorQuery->get_result();

$counselors = [];
while($row = $counselorResult->fetch_assoc()){
    $counselors[] = $row;
}
$counselorQuery->close();

// Define fixed time slots
$time_slots = [
    '09:00:00' => '9:00 AM - 10:00 AM',
    '14:00:00' => '2:00 PM - 3:00 PM',
    '15:00:00' => '3:00 PM - 4:00 PM',
    '17:00:00' => '5:00 PM - 6:00 PM',
    '19:30:00' => '7:30 PM - 8:30 PM'
];

// Handle form submission (Book Now)
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $counselor_id = $_POST['counselor'];
    $booking_date = $_POST['booking_date'];
    $start_time = $_POST['start_time'];
    $remark = $_POST['remark'];

    // Calculate end time
    switch($start_time){
        case '09:00:00': $end_time = '10:00:00'; break;
        case '14:00:00': $end_time = '15:00:00'; break;
        case '15:00:00': $end_time = '16:00:00'; break;
        case '17:00:00': $end_time = '18:00:00'; break;
        case '19:30:00': $end_time = '20:30:00'; break;
    }

    // Insert booking
    $insertQuery = $dbConn->prepare("INSERT INTO booking (booking_date, booking_start_time, booking_end_time, remark, counselor_id, student_id, booking_status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
    $insertQuery->bind_param("ssssss", $booking_date, $start_time, $end_time, $remark, $counselor_id, $student_id);
    if($insertQuery->execute()){
        $booking_success = true;
    } else {
        $error = "Error: ".$dbConn->error;
    }
    $insertQuery->close();
}

// Function to get available slots
function getAvailableSlots($dbConn, $counselor_id, $booking_date, $time_slots){
    $available = [];
    foreach($time_slots as $start => $label){
        switch($start){
            case '09:00:00': $end = '10:00:00'; break;
            case '14:00:00': $end = '15:00:00'; break;
            case '15:00:00': $end = '16:00:00'; break;
            case '17:00:00': $end = '18:00:00'; break;
            case '19:30:00': $end = '20:30:00'; break;
        }

        $check = $dbConn->prepare("
            SELECT * FROM booking
            WHERE counselor_id = ? AND booking_date = ?
            AND NOT (booking_end_time < ? OR booking_start_time > ?)
        ");
        $check->bind_param("isss", $counselor_id, $booking_date, $start, $end);
        $check->execute();
        $result = $check->get_result();

        if($result->num_rows == 0){
            $available[$start] = $label;
        }
        $check->close();
    }
    return $available;
}

// Get available slots if date and counselor selected
$available_slots = [];
if(isset($_GET['counselor']) && isset($_GET['booking_date'])){
    $available_slots = getAvailableSlots($dbConn, $_GET['counselor'], $_GET['booking_date'], $time_slots);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book a Session</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Itim&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

:root {
    --primary: #e8b45e;
    --white: #ffffff;
    --black: #000000;
    --max-width: 480px;
    --itim: 'Itim', cursive;
    --roboto: 'Roboto', sans-serif;
}

* { box-sizing: border-box; margin:0; padding:0; }

body {
    font-family: var(--roboto);
    background: #f5f5f5;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 20px;
    min-height: 70vh;
}

.container {
    height: 680px;
    max-width: var(--max-width);
    width: 100%;
    background: var(--white);
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.back-arrow {
    max-width: 15px;
    height: auto;
    margin-right: 10px;
    cursor: pointer;
}

h2 {
    font-family: var(--itim);
    font-size: 1.6em;
    color: #F48C8C;
    padding-bottom: 5px;
}

form { display: flex; flex-direction: column; }

label {
    margin: 10px 0 5px;
    font-weight: 500;
}

select, input[type="date"], textarea {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #d7e4ffff;
    font-size: 1em;
    width: 100%;
    margin-bottom: 15px;
    font-family: var(--roboto);
}

textarea { resize: none; }

button {
    background-color: var(--primary);
    color: var(--white);
    padding: 12px;
    font-size: 1em;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
    font-family: var(--roboto);
}

button:hover { background-color: #d19d4e; }

p { margin-top: 10px; }
p[style*="color:green"], p[style*="color:red"] { font-weight: bold; }

/* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 100;
    left:0;
    top:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: var(--roboto);
}

.modal-content {
    background: var(--white);
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    max-width: 90%;
    font-family: var(--roboto);
}

.modal-content h3 {
    font-family: var(--itim);
    margin-bottom: 10px;
}

.modal-content p {
    margin-bottom: 20px;
}

.modal-content button {
    width: 120px;
}
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <a href="counseling.php">
            <img src="../image/icons/back.png" class="back-arrow" alt="Back">
        </a>
        <h2>Book a Session</h2>
    </div>

    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <!-- Select Counselor and Date -->
    <form method="GET">
        <label for="counselor" style="font-family:var(--itim);">Select Counsellor:</label>
        <select name="counselor" id="counselor" required onchange="this.form.submit()" style="font-family:var(--itim);">
            <option value="">Select</option>
            <?php foreach($counselors as $c): ?>
                <option value="<?= $c['counselor_id'] ?>" <?= (isset($_GET['counselor']) && $_GET['counselor']==$c['counselor_id']) ? 'selected' : '' ?>>
                    <?= $c['counselor_name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="booking_date" style="font-family:var(--itim);">Select Date:</label>
        <input type="date" name="booking_date" id="booking_date" value="<?= isset($_GET['booking_date']) ? $_GET['booking_date'] : '' ?>" min="<?= date('Y-m-d') ?> " style="width:93.5%;font-family:var(--itim);" required>
    </form>

    <!-- Available Slots and Book Now -->
    <?php if(!empty($available_slots) && isset($_GET['counselor']) && isset($_GET['booking_date'])): ?>
    <form method="POST">
        <input type="hidden" name="counselor" value="<?= $_GET['counselor'] ?>">
        <input type="hidden" name="booking_date" value="<?= $_GET['booking_date'] ?>">

        <label for="start_time" style="font-family:var(--itim);">Select Time Slot:</label>
        <select name="start_time" id="start_time" style="font-family:var(--itim);"required>
            <option value="" style="font-family:var(--itim);">Select</option>
            <?php foreach($available_slots as $start => $label): ?>
                <option value="<?= $start ?>" style="font-family:var(--itim);"><?= $label ?></option>
            <?php endforeach; ?>
        </select>

        <label for="remark">Remark/Message:</label>
        <textarea name="remark" id="remark" rows="4" style="height:200px;" required style="font-family:var(--itim);" ></textarea>

        <button type="submit">Book Now</button>
    </form>
    <?php elseif(isset($_GET['counselor']) && isset($_GET['booking_date'])): ?>
        <p style="font-family:var(--itim);">No available time slots for this counselor on selected date.</p>
    <?php endif; ?>
</div>

<!-- Success Modal -->
<?php if(isset($booking_success) && $booking_success): ?>
<div class="modal" id="successModal">
    <div class="modal-content">
        <h3>Booking Successful!</h3>
        <p style="font-family:var(--itim);">You will be notified before your session is about to begin.</p>
        <button onclick="window.location.href='counseling.php'" style="font-family:var(--itim);">Confirm</button>
    </div>
</div>

<script>
document.getElementById('successModal').style.display = 'flex';
</script>
<?php endif; ?>

</body>
</html>
