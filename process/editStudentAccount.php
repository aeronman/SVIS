<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountType = isset($_POST['accountType']) ? $_POST['accountType'] : '';
    $studentId = isset($_POST['studentId']) ? $_POST['studentId'] : '';
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $middleName = isset($_POST['middleName']) ? $_POST['middleName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $section = isset($_POST['section']) ? $_POST['section'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    $fullName= $_SESSION['id'];

    $conn = getDbConnection();

    if ($accountType === 'student') {
        $sql = "UPDATE accounts SET first_name = ?, middle_name = ?, last_name = ?, section = ?, email = ? WHERE id = ? AND account_type = 'student'";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('sssssi', $firstName, $middleName, $lastName, $section, $email, $studentId);

            if ($stmt->execute()) {
                        // Log the action after successful update
                $logSql = "INSERT INTO logs (action_performed, performed_by, logged_date) VALUES (?, ?, ?)";
                if ($logStmt = $conn->prepare($logSql)) {
                    $actionPerformed = "Updated an Student account with account id : ".$studentId;
                    $loggedDate = date('Y-m-d H:i:s'); // Capture current date and time
                    $logStmt->bind_param('sss', $actionPerformed, $fullName, $loggedDate);
                    $logStmt->execute();
                    $logStmt->close();
                }
                echo json_encode(['status' => 'success', 'message' => 'Student account updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update student account.']);
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
