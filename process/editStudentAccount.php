<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountType = isset($_POST['accountType']) ? $_POST['accountType'] : '';
    $studentId = isset($_POST['studentId']) ? $_POST['studentId'] : '';
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $middleName = isset($_POST['middleName']) ? $_POST['middleName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $year = isset($_POST['year']) ? $_POST['year'] : '';
    $course = isset($_POST['course']) ? $_POST['course']: '';
    $section = isset($_POST['section']) ? $_POST['section'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $guardianname = isset($_POST['guardianName']) ? $_POST['guardianName'] : '';
    $guardiannum = isset($_POST['guardianContact']) ? $_POST['guardianContact'] : '';

    $fullName= $_SESSION['id'];

    $conn = getDbConnection();

    if ($accountType === 'student') {
        $sql = "UPDATE accounts SET first_name = ?, middle_name = ?, last_name = ?, course = ? , year = ?, section = ?, email = ? , guardian_name = ? , guardian_contact = ? WHERE id = ? AND account_type = 'student'";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('sssssssssi', $firstName, $middleName, $lastName, $course, $year , $section, $email, $guardianname,$guardiannum, $studentId);

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
                echo "error 1";
                echo json_encode(['status' => 'error', 'message' => 'Failed to update student account.']);
            }

            $stmt->close();
        } else {
            echo "error 2";
            echo json_encode(['status' => 'error', 'message' => 'Database query failed.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid account type.']);
    }

    $conn->close();
} else {
    echo "error 3";
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
