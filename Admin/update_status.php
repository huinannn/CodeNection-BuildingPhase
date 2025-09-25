<?php
session_start();
include '../conn.php';

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];       // confession / comment / reply
    $id   = $_POST['id'];         // id of the item
    $new_status = $_POST['status'];

    // Choose table and primary key based on type
    switch ($type) {
        case "confession":
            $table = "confession";
            $id_field = "confession_id";
            break;
        case "comment":
            $table = "comment";
            $id_field = "comment_id";
            break;
        case "reply":
            $table = "reply";
            $id_field = "reply_id";
            break;
        default:
            echo json_encode(["status" => "error", "message" => "Invalid type"]);
            exit();
    }

    $sql = "UPDATE $table SET {$type}_status = ? WHERE $id_field = ?";
    $stmt = $dbConn->prepare($sql);
    $stmt->bind_param("si", $new_status, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "new_status" => $new_status]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update"]);
    }
    $stmt->close();
    exit();
}
