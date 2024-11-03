<?php
session_start();
require_once 'db_connection.php';

header('Content-Type: application/json');

// Connect to the database
$conn = getDbConnection();

$mod_id = $_SESSION['id'];

// Fetch unique students with the last message preview
$query = "
SELECT c.student_id, a.profile_picture, 
       CONCAT(a.first_name, ' ', a.last_name) AS student_name,
       c.content AS last_message, c.sent_date AS last_sent_date
FROM chat c
INNER JOIN accounts a ON c.student_id = a.id
INNER JOIN (
    SELECT student_id, MAX(sent_date) AS max_sent_date 
    FROM chat 
    WHERE mod_id = ? 
    GROUP BY student_id
) AS latest ON c.student_id = latest.student_id AND c.sent_date = latest.max_sent_date
WHERE c.mod_id = ?
ORDER BY last_sent_date DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $mod_id, $mod_id);
$stmt->execute();
$result = $stmt->get_result();

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}
echo json_encode($students);
?>
