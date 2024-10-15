<?php
require_once 'db_connection.php';

header('Content-Type: application/json');

// Connect to the database
$conn = getDbConnection();

// Updated query to fetch logs and join with accounts table to get full name
$sql = "
    SELECT 
        logs.action_performed, 
        CONCAT(accounts.first_name, ' ', accounts.middle_name, ' ', accounts.last_name) AS performed_by, 
        logs.logged_date 
    FROM logs 
    LEFT JOIN accounts ON logs.performed_by = accounts.id
";
$result = $conn->query($sql);

$logs = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
}

// Return data as JSON
echo json_encode([
    "data" => $logs
]);

$conn->close();
?>
