<?php
session_start();
require_once 'db_connection.php';

header('Content-Type: application/json');

// Connect to the database
$conn = getDbConnection();

$student_id = $_SESSION['id']; // Moderator ID
$mod_id = $_GET['student_id']; // Selected student's ID

// Fetch recent chats
$query = "SELECT * FROM chat WHERE mod_id = ? AND student_id = ? ORDER BY sent_date ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $mod_id, $student_id);
$stmt->execute();
$result = $stmt->get_result();

$chats = [];
while ($row = $result->fetch_assoc()) {
    $chats[] = $row;
}
echo json_encode($chats);
?>
