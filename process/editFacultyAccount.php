<?php
session_start();
// Include database connection file
require_once 'db_connection.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountType = isset($_POST['accountType']) ? $_POST['accountType'] : '';
    $facultyId = isset($_POST['facultyId']) ? $_POST['facultyId'] : '';
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $middleName = isset($_POST['middleName']) ? $_POST['middleName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $advisoryClass = isset($_POST['advisoryClass']) ? $_POST['advisoryClass'] : '';

    // Validate and sanitize input
    $facultyId = filter_var($facultyId, FILTER_SANITIZE_STRING);
    $firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
    $middleName = filter_var($middleName, FILTER_SANITIZE_STRING);
    $lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
    $advisoryClass = filter_var($advisoryClass, FILTER_SANITIZE_STRING);
    $fullName = $_SESSION['id'];

    // Database connection
    $conn = getDbConnection();

    // Check if the accountType is faculty
    if ($accountType === 'faculty') {
        // Update query (ignoring profile_picture for now)
        $sql = "UPDATE accounts SET first_name = ?, middle_name = ?, last_name = ?, advisory_class = ? WHERE id = ? AND account_type = 'faculty'";

        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param('ssssi', $firstName, $middleName, $lastName, $advisoryClass, $facultyId);

            // Execute the statement
            if ($stmt->execute()) {
                     // Log the action after successful update
            $logSql = "INSERT INTO logs (action_performed, performed_by, logged_date) VALUES (?, ?, ?)";
            if ($logStmt = $conn->prepare($logSql)) {
                $actionPerformed = "Updated an Faculty account with account id : ".$facultyId;
                $loggedDate = date('Y-m-d H:i:s'); // Capture current date and time
                $logStmt->bind_param('sss', $actionPerformed, $fullName, $loggedDate);
                $logStmt->execute();
                $logStmt->close();
            }
                // Success message
                echo json_encode(['status' => 'success', 'message' => 'Faculty account updated successfully.']);
            } else {
                // Error message
                echo json_encode(['status' => 'error', 'message' => 'Failed to update faculty account.']);
            }

            // Close the statement
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database query failed.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid account type.']);
    }

    // Close the database connection
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
