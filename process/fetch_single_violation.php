<?php
require_once 'db_connection.php';

header('Content-Type: application/json');

$conn = getDbConnection();

if (isset($_GET['record_id'])) {
    $violationNo = $_GET['record_id'];

    // Prepare SQL query to fetch violation details by violation_no
    $query = " SELECT
                    sv.record_id,
                    sv.student_id,
                    CONCAT(a.first_name, ' ', COALESCE(a.middle_name, ''), ' ', a.last_name) AS full_name,
                    CONCAT(a.course, ' ', a.year, a.section) AS cys,
                    sv.violation_id,
                    v.violation_name,
                    sv.offense_count,
                    s.sanction_details,
                    sv.status,
                    sv.date_of_offense
                FROM student_violations sv
                JOIN accounts a ON sv.student_id = a.id
                LEFT JOIN sanctions s ON sv.sanction_id = s.sanction_id
                LEFT JOIN violations v ON sv.violation_id = v.violation_id
              WHERE record_id = ?";

    if ($stmt = $conn->prepare($query)) {
        // Bind parameters and execute
        $stmt->bind_param("s", $violationNo);
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        // Fetch the violation details
        if ($row = $result->fetch_assoc()) {
            // Return the data in JSON format
            echo json_encode([
                'status' => 'success',
                'data' => $row
            ]);
        } else {
            // No record found
            echo json_encode([
                'status' => 'error',
                'message' => 'No record found for the given violation number'
            ]);
        }

        // Close the statement
        $stmt->close();
    } else {
        // SQL preparation error
        echo json_encode([
            'status' => 'error',
            'message' => 'Error preparing the SQL query'
        ]);
    }
} else {
    // If violation_no is not provided
    echo json_encode([
        'status' => 'error',
        'message' => 'No violation number provided'
    ]);
}

// Close database connection
$conn->close();
?>
