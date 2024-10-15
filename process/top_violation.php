<?php
require_once 'db_connection.php';

// Connect to the database
$conn = getDbConnection();

// Get the current date and the date from 30 days ago
$currentDate = date('Y-m-d H:i:s');
$date30DaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));

// Query to count violations by type within the last 30 days
$sql = "
    SELECT violation_type, COUNT(*) as violation_count
    FROM violations
   
    GROUP BY violation_type
    ORDER BY violation_count DESC
    LIMIT 1";  // Fetch the top violation

$stmt = $conn->prepare($sql);


if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Return the violation type and count
        echo json_encode([
            'status' => 'success',
            'violation_type' => $row['violation_type'],
            'violation_count' => $row['violation_count']
        ]);
    } else {
        // No violations found
        echo json_encode(['status' => 'error', 'message' => 'No violations found in the last 30 days.']);
    }
} else {
    // Query execution failed
    echo json_encode(['status' => 'error', 'message' => 'Query failed.']);
}

$stmt->close();
$conn->close();
?>
