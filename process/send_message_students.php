<?php
session_start();
require_once 'db_connection.php';

header('Content-Type: application/json');

// Connect to the database
$conn = getDbConnection();

$mod_id = $_SESSION['id'];
$student_id = $_POST['student_id'];
$message = $_POST['message'];
$sent_by = $_SESSION['account_type'];

// Insert message into database
$query = "INSERT INTO chat (mod_id, student_id, content, sent_by) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiss", $student_id, $mod_id, $message, $sent_by);

if ($stmt->execute()) {
    // Respond with success
    echo json_encode(['status' => 'success']);
} else {
    // Respond with error
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
