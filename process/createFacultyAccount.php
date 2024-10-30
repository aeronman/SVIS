<?php
session_start();
// Include database connection file
require_once 'db_connection.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract data from POST request
    $accountType = isset($_POST['accountType']) ? $_POST['accountType'] : '';
    $facultyId = isset($_POST['facultyId']) ? $_POST['facultyId'] : '';
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $middleName = isset($_POST['middleName']) ? $_POST['middleName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $advisoryClass = isset($_POST['advisoryClass']) ? $_POST['advisoryClass'] : '';
    $profilePicture = isset($_POST['profilePicture']) ? $_POST['profilePicture'] : '';

    // Validate and sanitize inputs
    $facultyId = filter_var($facultyId, FILTER_SANITIZE_STRING);
    $firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
    $middleName = filter_var($middleName, FILTER_SANITIZE_STRING);
    $lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    $advisoryClass = filter_var($advisoryClass, FILTER_SANITIZE_STRING);
    $email = filter_var($email,FILTER_SANITIZE_STRING);

    $fullName = $_SESSION['id'];
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Get current date and time
    $createdAt = date('Y-m-d H:i:s');

    // Database connection
    $conn = getDbConnection();

    // Prepare SQL statement
    $sql = "INSERT INTO accounts (id, first_name, middle_name, last_name, email, username, password, advisory_class, profile_picture, account_type, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param('sssssssssss', $facultyId, $firstName, $middleName, $lastName, $username, $email, $hashedPassword, $advisoryClass, $profilePicture, $accountType, $createdAt);

        // Execute the statement
        if ($stmt->execute()) {
             // Log the action after successful update
             $logSql = "INSERT INTO logs (action_performed, performed_by, logged_date) VALUES (?, ?, ?)";
             if ($logStmt = $conn->prepare($logSql)) {
                 $actionPerformed = "Created faculty account";
                 $loggedDate = date('Y-m-d H:i:s'); // Capture current date and time
                 $logStmt->bind_param('sss', $actionPerformed, $fullName, $loggedDate);
                 $logStmt->execute();
                 $logStmt->close();
             }
            echo json_encode(['success' => 'Faculty account created successfully.']);
        } else {
            echo json_encode(['error' => 'Failed to create faculty account.']);
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
