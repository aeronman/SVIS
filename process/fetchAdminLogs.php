<?php
session_start(); // Start the session to access $_SESSION['id']
require_once 'db_connection.php';

header('Content-Type: application/json');

// Get the logged-in user's ID from the session
$user_id = $_SESSION['id'];

$conn = getDbConnection();

// Query to get IDs of users who are not superadmin
$excluded_ids_query = "
    SELECT id 
    FROM accounts 
    WHERE account_type != 'superadmin'
";

$excluded_ids_result = $conn->query($excluded_ids_query);

$excluded_ids = array();

if ($excluded_ids_result->num_rows > 0) {
    while ($row = $excluded_ids_result->fetch_assoc()) {
        $excluded_ids[] = $row['id'];
    }
}

if (empty($excluded_ids)) {
    // If no IDs are found, return empty data
    echo json_encode(["data" => []]);
    $conn->close();
    exit;
}

// Prepare placeholders for the query
$placeholders = implode(',', array_fill(0, count($excluded_ids), '?'));

// Query to fetch logs performed by non-superadmin users
$sql = "
    SELECT 
        logs.action_performed, 
        CONCAT(accounts.first_name, ' ', accounts.middle_name, ' ', accounts.last_name) AS performed_by, 
        logs.logged_date 
    FROM logs 
    LEFT JOIN accounts ON logs.performed_by = accounts.id
    WHERE logs.performed_by IN ($placeholders)
";

$stmt = $conn->prepare($sql);

// Bind parameters dynamically
$types = str_repeat('i', count($excluded_ids));
$stmt->bind_param($types, ...$excluded_ids);

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
