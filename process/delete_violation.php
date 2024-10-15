<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $violation_id = isset($_POST['violation_id']) ? $_POST['violation_id'] : '';
$fullName = $_SESSION['id'];
    if ($violation_id) {
        $conn = getDbConnection();

        // Move the record to archived_accounts before deletion
        $sqlArchive = "INSERT INTO archived_violation 
                       SELECT * FROM violations WHERE violation_no = ?";
        $stmtArchive = $conn->prepare($sqlArchive);
        $stmtArchive->execute([$violation_id]);

        // Delete the record from violations table
        $sqlDelete = "DELETE FROM violations WHERE violation_no = ?";
        $stmtDelete = $conn->prepare($sqlDelete);

        if ($stmtDelete->execute([$violation_id])) {
             // Log the action after successful update
             $logSql = "INSERT INTO logs (action_performed, performed_by, logged_date) VALUES (?, ?, ?)";
             if ($logStmt = $conn->prepare($logSql)) {
                 $actionPerformed = "Archived a violation";
                 $loggedDate = date('Y-m-d H:i:s'); // Capture current date and time
                 $logStmt->bind_param('sss', $actionPerformed, $fullName, $loggedDate);
                 $logStmt->execute();
                 $logStmt->close();
             }
            echo json_encode(['status' => 'success', 'message' => 'Violation deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete violation.']);
        }

        $conn = null;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid student ID.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
