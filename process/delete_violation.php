<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $record_id = isset($_POST['record_id']) ? $_POST['record_id'] : '';
    $fullName = $_SESSION['id'];
    if ($record_id) {
        $conn = getDbConnection();

        // Move the record to archived_accounts before deletion
        $sqlArchive = "INSERT INTO archived_student_violations 
                       SELECT * FROM student_violations WHERE record_id = ?";
        $stmtArchive = $conn->prepare($sqlArchive);
        $stmtArchive->execute([$record_id]);

        // Delete the record from violations table
        $sqlDelete = "DELETE FROM student_violations WHERE record_id = ?";
        $stmtDelete = $conn->prepare($sqlDelete);

        if ($stmtDelete->execute([$record_id])) {
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
