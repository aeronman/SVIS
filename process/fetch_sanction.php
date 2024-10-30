<?php
header('Content-Type: application/json');
require_once 'db_connection.php';

// Database connection
$conn = getDbConnection();

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$violationId = $conn->real_escape_string($_GET['violationId']);
$offenseCount = $conn->real_escape_string($_GET['offenseCount']);

$result = $conn->query("SELECT sanction_id, sanction_details FROM sanctions WHERE violation_id = '$violationId' AND offense_count = '$offenseCount'"); // Adjust the query based on your table

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'sanction_id' => $row['sanction_id'], // Return sanction_id
        'sanction_details' => $row['sanction_details'] // Return sanction_details
    ]);
} else {
    echo json_encode(['sanction' => 'No sanction found']);
}

$conn->close();
?>
