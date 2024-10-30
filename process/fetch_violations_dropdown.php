<?php
header('Content-Type: application/json');

require_once 'db_connection.php';
// Database connection
$conn = getDbConnection();



// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$result = $conn->query("SELECT violation_id, violation_name FROM violations"); // Adjust the query based on your table

$violations = [];
while ($row = $result->fetch_assoc()) {
    $violations[] = $row;
}

echo json_encode($violations);
$conn->close();
?>
