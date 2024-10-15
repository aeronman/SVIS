<?php
session_start(); // Start the session to access $_SESSION['id']
require_once 'db_connection.php';

header('Content-Type: application/json');

// Get the logged-in student's ID from the session
$student_id = $_SESSION['id'];

$conn = getDbConnection();

// Query to fetch the student's violations along with student details
$sql = "
    SELECT 
        violations.violation_no,
        violations.student_id,
        CONCAT(accounts.first_name, ' ', accounts.middle_name, ' ', accounts.last_name) AS full_name,
        accounts.section,
        accounts.profile_picture,
        violations.violation_type,
        violations.status
    FROM violations
    LEFT JOIN accounts ON violations.student_id = accounts.id
    WHERE violations.student_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $student_id);
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
