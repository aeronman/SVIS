<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountType = isset($_POST['accountType']) ? $_POST['accountType'] : '';
    $superAdminId = isset($_POST['superAdminID']) ? $_POST['superAdminID'] : '';
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $middleName = isset($_POST['middleName']) ? $_POST['middleName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    $fullName = $_SESSION['id'];


    $conn = getDbConnection();

    if ($accountType === 'superadmin') {
        $sql = "UPDATE accounts SET first_name = ?, middle_name = ?, last_name = ? ,email = ? WHERE id = ? AND account_type = 'superadmin'";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('ssssi', $firstName, $middleName, $lastName, $email,$superAdminId);

            if ($stmt->execute()) {
                     // Log the action after successful update
            $logSql = "INSERT INTO logs (action_performed, performed_by, logged_date) VALUES (?, ?, ?)";
            
            if ($logStmt = $conn->prepare($logSql)) {
                $actionPerformed = "Updated an Super Admin account with account id : ".$superAdminId;
                $loggedDate = date('Y-m-d H:i:s'); // Capture current date and time
                $logStmt->bind_param('sss', $actionPerformed, $fullName, $loggedDate);
                $logStmt->execute();
                $logStmt->close();
            }
                echo json_encode(['status' => 'success', 'message' => 'SuperAdmin account updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update superadmin account.']);
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
