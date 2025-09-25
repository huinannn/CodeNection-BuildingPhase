<?php
session_start();
include '../conn.php';

if(!isset($_SESSION['student_id'])){
    http_response_code(403);
    exit();
}

$id = $_POST['id'] ?? null;
$type = $_POST['type'] ?? null;

if ($id && $type) {
    if ($type === 'Admin') {
        $stmt = $dbConn->prepare("UPDATE notification_admin SET read_status = 'read' WHERE message_id = ?");
    } else {
        $stmt = $dbConn->prepare("UPDATE notification_system SET read_status = 'read' WHERE notification_id = ?");
    }
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->close();
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
?>
