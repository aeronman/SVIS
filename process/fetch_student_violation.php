<?php
session_start();
 // Start the session to access $_SESSION['id']
require_once 'db_connection.php';

header('Content-Type: application/json');

// Get the logged-in student's ID from the session
$student_id = $_SESSION['id'];

$conn = getDbConnection();

// Query to fetch the student's violations along with student details
$sql = " SELECT
sv.record_id,
sv.student_id,
CONCAT(a.first_name, ' ', COALESCE(a.middle_name, ''), ' ', a.last_name) AS full_name,
CONCAT(a.course, ' ', a.year, a.section) AS cys,
sv.violation_id,
v.violation_name,
sv.offense_count,
s.sanction_details,
sv.status,
sv.date_of_offense
FROM student_violations sv
JOIN accounts a ON sv.student_id = a.id
LEFT JOIN sanctions s ON sv.sanction_id = s.sanction_id
LEFT JOIN violations v ON sv.violation_id = v.violation_id
WHERE sv.student_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $student_id);
$stmt->execute();
$result = $stmt->get_result();

$violations = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $violations[] = $row;
    }
}

// Return data as JSON to populate the DataTable
echo json_encode([
    "data" => $violations
]);

$conn->close();
?>


