<?php
session_start();
include '../conn.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: Login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $positivity = $_POST['positivity_feeling'];
    $feeling = $_POST['admin_feeling'];
    $journal = $_POST['mini_journal'];
    $admin_id = $_SESSION['admin_id'];
    $datetime = date("Y-m-d H:i:s");

    $sql = "INSERT INTO feeling_admin 
            (positivity_feeling, admin_feeling, mini_journal, admin_feeling_datetime, admin_id) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $dbConn->prepare($sql);
    $stmt->bind_param("sssss", $positivity, $feeling, $journal, $datetime, $admin_id);
    
    if ($stmt->execute()) {
        header("Location: check-in.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
