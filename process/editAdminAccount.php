<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountType = isset($_POST['accountType']) ? $_POST['accountType'] : '';
    $adminId = isset($_POST['adminID']) ? $_POST['adminID'] : '';
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $middleName = isset($_POST['middleName']) ? $_POST['middleName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $fullName = $_SESSION['id'];

    $conn = getDbConnection();

    if ($accountType === 'admin') {

        $sql = "UPDATE accounts SET first_name = ?, middle_name = ?, last_name = ? , email = ? WHERE id = ? AND account_type = 'admin'";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('sssss', $firstName, $middleName, $lastName, $email, $adminId);

            // Execute and debug if it fails
            if ($stmt->execute()) {
                 // Log the action after successful update
            $logSql = "INSERT INTO logs (action_performed, performed_by, logged_date) VALUES (?, ?, ?)";
            if ($logStmt = $conn->prepare($logSql)) {
                $actionPerformed = "Updated an Admin account with account id : ".$adminId;
                $loggedDate = date('Y-m-d H:i:s'); // Capture current date and time
                $logStmt->bind_param('sss', $actionPerformed, $fullName, $loggedDate);
                $logStmt->execute();
                $logStmt->close();
            }
                echo json_encode(['status' => 'success', 'message' => 'Admin account updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update admin account: ' . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database query failed.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid account type.']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
