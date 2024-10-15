<?php
session_start();
// Include database connection file
require_once 'db_connection.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract data from POST request
    $accountType = isset($_POST['accountType']) ? $_POST['accountType'] : '';
    $studentId = isset($_POST['studentId']) ? $_POST['studentId'] : '';
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $middleName = isset($_POST['middleName']) ? $_POST['middleName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $section = isset($_POST['section']) ? $_POST['section'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $profilePicture = isset($_POST['profilePicture']) ? $_POST['profilePicture'] : '';
    $qrImage = isset($_POST['qrImage']) ? $_POST['qrImage'] : '';

    // Validate and sanitize inputs
    $studentId = filter_var($studentId, FILTER_SANITIZE_STRING);
    $firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
    $middleName = filter_var($middleName, FILTER_SANITIZE_STRING);
    $lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
    $section = filter_var($section, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

$fullName = $_SESSION['id'];

    if ($email === false) {
        echo json_encode(['error' => 'Invalid email address.']);
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Get current date and time
    $createdAt = date('Y-m-d H:i:s');

    // Database connection
    $conn = getDbConnection();

    // Prepare SQL statement
    $sql = "INSERT INTO accounts (id, first_name, middle_name, last_name, section, email, username, password, profile_picture, qr_image, account_type, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param('ssssssssssss', $studentId, $firstName, $middleName, $lastName, $section, $email, $username, $hashedPassword, $profilePicture, $qrImage, $accountType, $createdAt);

        // Execute the statement
        if ($stmt->execute()) {
             // Log the action after successful update
             $logSql = "INSERT INTO logs (action_performed, performed_by, logged_date) VALUES (?, ?, ?)";
             if ($logStmt = $conn->prepare($logSql)) {
                 $actionPerformed = "Created student account";
                 $loggedDate = date('Y-m-d H:i:s'); // Capture current date and time
                 $logStmt->bind_param('sss', $actionPerformed, $fullName, $loggedDate);
                 $logStmt->execute();
                 $logStmt->close();
             }
            echo json_encode(['success' => 'Student account created successfully.']);
        } else {
            echo json_encode(['error' => 'Failed to create student account.']);
        }

        // Close statement
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare SQL statement.']);
    }

    // Close connection
    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
