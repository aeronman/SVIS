<?php
session_start();
// Include database connection file
require_once 'db_connection.php';
// Database connection
$conn = getDbConnection();

$fullName = $_SESSION['id'];
// Log the action after successful update
   $logSql = "INSERT INTO logs (action_performed, performed_by, logged_date) VALUES (?, ?, ?)";
   if ($logStmt = $conn->prepare($logSql)) {
       $actionPerformed = "Logged out";
       $loggedDate = date('Y-m-d H:i:s'); // Capture current date and time
       $logStmt->bind_param('sss', $actionPerformed, $fullName, $loggedDate);
       $logStmt->execute();
       $logStmt->close();
}
session_destroy();
header('Location: ../index.php');
exit();
?>