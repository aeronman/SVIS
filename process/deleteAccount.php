<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $fullName = $_SESSION['id'];
    if (empty($id)) {
        echo json_encode(['status' => 'error', 'message' => 'No ID provided.']);
        exit;
    }

    $conn = getDbConnection();

    try {

        // Move record to archived_accounts
        $sql = "INSERT INTO archived_accounts SELECT * FROM accounts WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('s', $id);
            if (!$stmt->execute()) {
                throw new Exception('Failed to archive account.');
            }
            $stmt->close();
        } else {
            throw new Exception('Database query failed for archiving.');
        }

        // Delete record from accounts table
        $sql = "DELETE FROM accounts WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('s', $id);
            if (!$stmt->execute()) {
                throw new Exception('Failed to delete account.');
            }
            $stmt->close();
        } else {
            throw new Exception('Database query failed for deletion.');
        }
         // Log the action after successful update
         $logSql = "INSERT INTO logs (action_performed, performed_by, logged_date) VALUES (?, ?, ?)";
         if ($logStmt = $conn->prepare($logSql)) {
             $actionPerformed = "Archived an account";
             $loggedDate = date('Y-m-d H:i:s'); // Capture current date and time
             $logStmt->bind_param('sss', $actionPerformed, $fullName, $loggedDate);
             $logStmt->execute();
             $logStmt->close();
         }

        // Commit transaction
        $conn->commit();
        

        echo json_encode(['status' => 'success', 'message' => 'Account successfully deleted and archived.']);
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollBack();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
