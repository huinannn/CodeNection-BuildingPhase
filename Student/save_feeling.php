<?php
    session_start();
    include '../conn.php';
    if(!isset($_SESSION['student_id'])) {
        echo json_encode(['success' => false]);
        exit();
    }
    $student_id = $_SESSION['student_id'];
    $feeling_status = $_POST['feeling_status'];
    if(!$feeling_status){
        echo json_encode(['success' => false, 'error' => 'No feeling provided']);
        exit();
    }
    $encouragements = [
        'happy' => "Keep up the positivity!",
        'calm' => "Stay balanced and serene!",
        'manic' => "Take a deep breath, you're doing great!",
        'angry' => "It's okay to feel angry. Try to relax!",
        'sad' => "It's okay to feel sad. Remember, brighter days are ahead!"
    ];

    // Check if already submitted today
    $today = date('Y-m-d');
    $stmt = $dbConn->prepare("SELECT feeling_date_time FROM feeling WHERE student_id = ? AND DATE(feeling_date_time) = ?");
    $stmt->bind_param("ss", $student_id, $today);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows > 0){
        echo json_encode(['success' => false]);
        exit();
    }
    $stmt->close();

    // Insert new feeling
    $stmt2 = $dbConn->prepare("INSERT INTO feeling (student_id, feeling_status, feeling_date_time) VALUES (?, ?, NOW())");
    $stmt2->bind_param("ss", $student_id, $feeling_status);
    $stmt2->execute();
    $stmt2->close();

    echo json_encode([
        'success' => true,
        'encouragement' => $encouragements[$feeling_status]
    ]);
?>