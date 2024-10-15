<?php
// Start the session
session_start();

// Include database connection file
require_once 'db_connection.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract data from POST request
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate and sanitize inputs
    $username = filter_var($username, FILTER_SANITIZE_EMAIL);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    // Database connection
    $conn = getDbConnection();

    // Prepare SQL statement to fetch user details
    $sql = "SELECT id, first_name, middle_name, last_name, account_type, qr_image, profile_picture, password 
            FROM accounts 
            WHERE username = ?";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param('s', $username);

        // Execute the statement
        $stmt->execute();

        // Store result
        $stmt->store_result();

        // Bind result variables
        $stmt->bind_result($id, $firstName, $middleName, $lastName, $accountType, $qrImage, $profilePicture, $hashedPassword);

        // Fetch the result
        if ($stmt->num_rows === 1 && $stmt->fetch()) {
            // Verify password
            if (password_verify($password, $hashedPassword)) {
                // Concatenate full name
                $fullName = trim($firstName . ' ' . $middleName . ' ' . $lastName);

                // Set session variables
                $_SESSION['id'] = $id;
                $_SESSION['full_name'] = $fullName;
                $_SESSION['account_type'] = $accountType;
                $_SESSION['qr_image'] = $qrImage;
                $_SESSION['profile_picture'] = $profilePicture;
            $fullName = $_SESSION['id'];
                     // Log the action after successful update
                        $logSql = "INSERT INTO logs (action_performed, performed_by, logged_date) VALUES (?, ?, ?)";
                        if ($logStmt = $conn->prepare($logSql)) {
                            $actionPerformed = "Logged in";
                            $loggedDate = date('Y-m-d H:i:s'); // Capture current date and time
                            $logStmt->bind_param('sss', $actionPerformed, $fullName, $loggedDate);
                            $logStmt->execute();
                            $logStmt->close();
                        }

                // Redirect based on account type
                switch ($accountType) {
                    case 'student':
                        $redirectUrl = "student/index.php";
                        
                        echo json_encode(['status' => 'success', 'redirect' => $redirectUrl]);
                        break;
                    case 'admin':
                        $redirectUrl = 'admin/index.php';
                        echo json_encode(['status' => 'success', 'redirect' => $redirectUrl]);
                        break;
                    case 'superadmin':
                        $redirectUrl = 'superadmin/index.php';
                        echo json_encode(['status' => 'success', 'redirect' => $redirectUrl]);
                        break;
                    case 'clerk':
                        $redirectUrl = 'clerk/index.php';
                        echo json_encode(['status' => 'success', 'redirect' => $redirectUrl]);
                        break;
                    case 'faculty':
                        $redirectUrl = 'faculty/index.php';
                        echo json_encode(['status' => 'success', 'redirect' => $redirectUrl]);
                        break;
                    default:
                        echo json_encode(['status' => 'error', 'message' => 'Invalid account type.']);
                        break;
                }
               
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid password.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No account found with that username.']);
        }

        // Close statement
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare SQL statement.']);
    }

    // Close connection
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
