<?php
require_once 'db_connection.php';

// Database connection
$conn = getDbConnection();

// Check if the necessary POST data is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $record_id = $_POST['record_id'];
    $violationType = $_POST['violation_id'];
    $offenseCount = $_POST['offense_count'];
    $sanctionId = $_POST['sanction_id'];
    $status = $_POST['status'];
    $dateOfOffense = $_POST['date_of_offense'];

    // Prepare SQL query to update the violation record
    $query = "UPDATE student_violations SET
                violation_id = ?,
                offense_count = ?,
                sanction_id = ?,
                status = ?,
                date_of_offense = ?
              WHERE record_id = ?";

    if ($stmt = $conn->prepare($query)) {
        // Bind parameters and execute
        $stmt->bind_param("siisss", $violationType, $offenseCount, $sanctionId, $status, $dateOfOffense, $record_id);
        
        if ($stmt->execute()) {
            // Return success message
            echo json_encode(['status' => 'success', 'message' => 'Violation updated successfully']);
        } else {
            // Return error message for query execution
            echo json_encode(['status' => 'error', 'message' => 'Failed to update the violation']);
        }

        // Close the statement
        $stmt->close();
    } else {
        // Return error message for SQL preparation
        echo json_encode(['status' => 'error', 'message' => 'Error preparing the SQL query']);
    }
} else {
    // Return error message if the request method is not POST
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

// Close database connection
$conn->close();
?>
