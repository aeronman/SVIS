<?php
session_start(); // Start the session to access $_SESSION['id']
require_once 'db_connection.php';

header('Content-Type: application/json');

// Get the logged-in user's ID from the session
$user_id = $_SESSION['id'];

$conn = getDbConnection();

// Updated query to fetch logs performed by the logged-in user
$sql = "
    SELECT 
        logs.action_performed, 
        CONCAT(accounts.first_name, ' ', accounts.middle_name, ' ', accounts.last_name) AS performed_by, 
        logs.logged_date 
    FROM logs 
    LEFT JOIN accounts ON logs.performed_by = accounts.id
    WHERE logs.performed_by = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

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
