<?php
session_start();
require_once 'db_connection.php';

header('Content-Type: application/json');

// Connect to the database
$conn = getDbConnection();

$student_id = $_SESSION['id'];

// Fetch unique students with the last message preview
$query = "
SELECT c.mod_id, a.profile_picture, 
       CONCAT(a.first_name, ' ', a.last_name) AS student_name,
       c.content AS last_message, c.sent_date AS last_sent_date
FROM chat c
INNER JOIN accounts a ON c.mod_id = a.id
INNER JOIN (
    SELECT mod_id, MAX(sent_date) AS max_sent_date 
    FROM chat 
    WHERE student_id = ? 
    GROUP BY mod_id
) AS latest ON c.mod_id = latest.mod_id AND c.sent_date = latest.max_sent_date
WHERE c.student_id = ?
ORDER BY last_sent_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $student_id, $student_id);
$stmt->execute();
$result = $stmt->get_result();

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}
echo json_encode($students);
?>
