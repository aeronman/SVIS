<?php
// db_connection.php should contain the necessary code to connect to your database
require_once 'db_connection.php';

// Connect to the database
$conn = getDbConnection();

// SQL query to count students with account_type = 'student'
$sql = "SELECT COUNT(*) as total_students FROM accounts WHERE account_type = 'student'";

if ($result = $conn->query($sql)) {
    $row = $result->fetch_assoc();
    // Return the count as a JSON object
    echo json_encode([
        'status' => 'success',
        'total_students' => $row['total_students']
    ]);
} else {
    // In case of query failure
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch total students']);
}

// Close the database connection
$conn->close();
?>
