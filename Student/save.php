<?php
session_start();
include '../conn.php';

header('Content-Type: application/json');

if (!isset($_SESSION['student_id'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit;
}


$student_id = $_SESSION['student_id'];
$type = $_POST['type'] ?? '';


// Submit Comment
if ($type === "comment") {
    $confession_id = $_POST['confession_id'] ?? '';
    $comment_message = trim($_POST['comment_message'] ?? '');

    if ($comment_message !== '') {
        $stmt = $conn->prepare("INSERT INTO comment (confession_id, comment_message, comment_date_time, comment_status) 
                                VALUES (?, ?, NOW(), 'pending')");
        $stmt->bind_param("ss", $confession_id, $comment_message);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Your comment has been submitted and is awaiting admin approval."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to save comment"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Empty comment"]);
    }
    exit();

}

// Submit Reply
if ($type === "reply") {
    $comment_id = $_POST['comment_id'] ?? '';
    $reply_message = trim($_POST['reply_message'] ?? '');

    if ($reply_message !== '') {
        $stmt = $conn->prepare("INSERT INTO reply (comment_id, reply_message, reply_date_time, reply_status) 
                                VALUES (?, ?, NOW(), 'pending')");
        $stmt->bind_param("ss", $comment_id, $reply_message);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Your reply has been submitted and is awaiting admin approval."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to save reply"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Empty reply"]);
    }
    exit();

}

// Submit Post
if (isset($_POST['title'], $_POST['post_input'], $_POST['mode'])) {
    $title = trim($_POST['title']);
    $message = trim($_POST['post_input']) !== '' ? trim($_POST['post_input']) : null;
    $mode = ($_POST['mode'] === 'happy') ? 'happy' : 'sad'; // only allow happy/sad
    $uploadedFiles = [];

    // Handle multiple media upload (optional)
    if (!empty($_FILES['media']['name'][0])) {
        // ✅ Save inside different folder based on mode
        $uploadsDir = __DIR__ . "/../image/confessions/" . $mode . "/";
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }

        $maxFileSize = 5 * 1024 * 1024; // 5 MB per file

        foreach ($_FILES['media']['name'] as $key => $name) {
            if ($_FILES['media']['error'][$key] === UPLOAD_ERR_OK) {
                // Check file size
                if ($_FILES['media']['size'][$key] > $maxFileSize) {
                    echo json_encode([
                        "status" => "error",
                        "message" => "File " . htmlspecialchars($name) . " exceeds the 5MB limit."
                    ]);
                    exit();
                }

                // Create safe filename
                $fileName = time() . "_" . basename($name);
                $targetFile = $uploadsDir . $fileName;

                if (move_uploaded_file($_FILES['media']['tmp_name'][$key], $targetFile)) {
                    // ✅ Store relative path for DB (not absolute server path)
                    $uploadedFiles[] = "/../image/confessions/" . $mode . "/" . $fileName;
                }
            }
        }
    }

    // Store uploaded files as JSON or null
    $filePath = !empty($uploadedFiles) ? json_encode($uploadedFiles) : null;

    // ✅ Validation: require title AND (message or file)
    if ($title === '' || ($message === '' && empty($uploadedFiles))) {
        echo json_encode([
            "status" => "error",
            "message" => "Please provide a title and at least text or one media file."
        ]);
        exit();
    }

    $sqlInsert = "INSERT INTO confession 
        (confession_title, confession_message, confession_post, confession_date_time, mode, confession_status, student_id)
        VALUES (?, ?, ?, NOW(), ?, 'pending', ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("sssss", $title, $message, $fileName, $mode, $student_id);

    if ($stmtInsert->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Your confession has been submitted and is awaiting admin approval."
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Insert confession failed"]);
    }
    $stmtInsert->close();
    exit();
}




?>