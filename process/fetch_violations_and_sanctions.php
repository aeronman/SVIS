<?php
require_once 'db_connection.php';
// Database connection
$conn = getDbConnection();

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Fetch violations and sanctions
$sql = "SELECT v.violation_id, v.violation_name, v.description, 
               s.offense_count, s.sanction_details 
        FROM violations v 
        LEFT JOIN sanctions s ON v.violation_id = s.violation_id 
        ORDER BY v.violation_id";

$result = $conn->query($sql);

$data = []; // Array to hold the data

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'violation_id' => $row['violation_id'],
            'violation_name' => $row['violation_name'],
            'description' => $row['description'],
            'offense_count' => $row['offense_count'],
            'sanction_details' => $row['sanction_details']
        ];
    }
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
