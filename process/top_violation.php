<?php
require_once 'db_connection.php';

// Connect to the database
$conn = getDbConnection();



// Query to count violations by type within the last 30 days and get the violation name
$sql = "
    SELECT v.violation_id, v.violation_name, COUNT(*) as violation_count
    FROM student_violations sv
    JOIN violations v ON sv.violation_id = v.violation_id
    GROUP BY v.violation_id, v.violation_name
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
            'violation_type' => $row['violation_name'], // Updated to get violation name
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
