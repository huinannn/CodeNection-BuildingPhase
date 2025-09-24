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
        $success = "Booking successfully submitted!";
    } else {
        $error = "Error: ".$dbConn->error;
    }
    $insertQuery->close();
}

// Function to get available slots (no overlap or touching)
function getAvailableSlots($dbConn, $counselor_id, $booking_date, $time_slots){
    $available = [];
    foreach($time_slots as $start => $label){
        // Determine end time
        switch($start){
            case '09:00:00': $end = '10:00:00'; break;
            case '14:00:00': $end = '15:00:00'; break;
            case '15:00:00': $end = '16:00:00'; break;
            case '17:00:00': $end = '18:00:00'; break;
            case '19:30:00': $end = '20:30:00'; break;
        }

        // Check if slot overlaps or touches existing booking
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

// If counselor and date are selected, get available slots
$available_slots = [];
if(isset($_GET['counselor']) && isset($_GET['booking_date'])){
    $available_slots = getAvailableSlots($dbConn, $_GET['counselor'], $_GET['booking_date'], $time_slots);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Book a Session</title>
</head>
<body>
<h2>Book a Counselling Session</h2>

<?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<!-- Select Counselor and Date -->
<form method="GET">
    <label for="counselor">Select Counsellor:</label>
    <select name="counselor" id="counselor" required onchange="this.form.submit()">
        <option value="">Select</option>
        <?php foreach($counselors as $c): ?>
            <option value="<?= $c['counselor_id'] ?>" <?= (isset($_GET['counselor']) && $_GET['counselor']==$c['counselor_id']) ? 'selected' : '' ?>>
                <?= $c['counselor_name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="booking_date">Select Date:</label>
    <input type="date" name="booking_date" id="booking_date" value="<?= isset($_GET['booking_date']) ? $_GET['booking_date'] : '' ?>" min="<?= date('Y-m-d') ?>" required onchange="this.form.submit()">
</form>

<!-- Available Slots and Book Now -->
<?php if(!empty($available_slots) && isset($_GET['counselor']) && isset($_GET['booking_date'])): ?>
<form method="POST">
    <input type="hidden" name="counselor" value="<?= $_GET['counselor'] ?>">
    <input type="hidden" name="booking_date" value="<?= $_GET['booking_date'] ?>">

    <label for="start_time">Select Time Slot:</label>
    <select name="start_time" id="start_time" required>
        <option value="">Select</option>
        <?php foreach($available_slots as $start => $label): ?>
            <option value="<?= $start ?>"><?= $label ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label for="remark">Remark/Message:</label>
    <textarea name="remark" id="remark" rows="4" cols="50" required></textarea>
    <br><br>

    <button type="submit">Book Now</button>
</form>
<?php elseif(isset($_GET['counselor']) && isset($_GET['booking_date'])): ?>
<p>No available time slots for this counselor on selected date.</p>
<?php endif; ?>
</body>
</html>
