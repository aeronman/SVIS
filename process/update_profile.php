<?php
session_start();
// Database connection
require_once 'db_connection.php';

// Database connection
$conn = getDbConnection();

$id = $_SESSION['id'];

// Initialize error variables
$errors = [];

// Check if the form was submitted via AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Handle profile picture upload
  if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
    $fileName = $_FILES['profile_picture']['name'];
    $fileSize = $_FILES['profile_picture']['size'];
    $fileType = $_FILES['profile_picture']['type'];
    
    // Validate file type (you can customize allowed types)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($fileType, $allowedTypes)) {
      $errors[] = "Invalid file type. Only JPG, PNG, and WEBP formats are allowed.";
    }

    // Read the file and convert to Base64
    if (empty($errors)) {
      $imageData = file_get_contents($fileTmpPath);
      $base64 = 'data:' . $fileType . ';base64,' . base64_encode($imageData);
      $_SESSION['profile_picture'] = $base64; // Store it in session
    }
  }

  // Handle password change
  if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password
    if ($new_password !== $confirm_password) {
      $errors[] = "Passwords do not match.";
    } elseif (strlen($new_password) < 8) { // Minimum length
      $errors[] = "Password must be at least 8 characters long.";
    }

    // Hash password if valid
    if (empty($errors)) {
      $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

      // Update password in the database
      $sql = "UPDATE accounts SET password = ? WHERE id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("si", $hashed_password, $id);
      $stmt->execute();
    }
  }

  // Update profile picture in the database if there are no errors
  if (empty($errors)) {
    $sql = "UPDATE accounts SET profile_picture = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $base64, $id);
    $stmt->execute();
    
    // Return success response
    echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully!']);
    exit();
  } else {
    // Return error response
    echo json_encode(['status' => 'error', 'errors' => $errors]);
    exit();
  }
}

// Return error if no AJAX request
echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
?>
