<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = isset($_POST['studentId']) ? $_POST['studentId'] : '';
    $violationType = isset($_POST['violationType']) ? $_POST['violationType'] : '';

    $conn = getDbConnection();
    $fullName = $_SESSION['id'];
    $status = "pending";

     
            // Add violation record to a violations table (assuming such a table exists)
            $sql = "INSERT INTO violations (student_id, violation_type,status,date )
                    VALUES (?, ?,?, NOW())";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('sss', $studentId, $violationType,$status);

                if ($stmt->execute()) {
                    $logSql = "INSERT INTO logs (action_performed, performed_by, logged_date) VALUES (?, ?, ?)";
            
                    if ($logStmt = $conn->prepare($logSql)) {
                        $actionPerformed = "Added a violation for account id : ".$studentId;
                        $loggedDate = date('Y-m-d H:i:s'); // Capture current date and time
                        $logStmt->bind_param('sss', $actionPerformed, $fullName, $loggedDate);
                        $logStmt->execute();
                        $logStmt->close();
                    }
                    echo json_encode(['status' => 'success', 'message' => 'Violation recorded']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to record violation.']);
                }
                $stmt->close();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Database query failed.']);
            }
        

        

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
