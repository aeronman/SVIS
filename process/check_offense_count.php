<?php
// Database connection (adjust to your configuration)
include 'db_connection.php';

 // Database connection
 $conn = getDbConnection();
$studentId = $_GET['studentId'];
$violationId = $_GET['violationId'];

// Query to get the highest offense count for the selected student and violation
$query = "SELECT MAX(offense_count) as highest_offense_count 
          FROM student_violations 
          WHERE student_id = ? AND violation_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $studentId, $violationId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Set default highest offense count to 0 if no record is found
$highestOffenseCount = $row['highest_offense_count'] ?? 0;

echo json_encode(['highest_offense_count' => (int)$highestOffenseCount]);
?>
