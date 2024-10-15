<?php
session_start();

// Check if session 'account_type' is set
if (isset($_SESSION['account_type'])) {
    // Check if the account type is 'student'
    if ($_SESSION['account_type'] == 'student') {
        // If account type is 'student', redirect to 403.html
        header('Location: student/index.php');
        exit();
    }
    else if ($_SESSION['account_type'] == 'admin') {
        // If account type is  'admin', redirect to 403.html
        header('Location: admin/index.php');
        exit();
    }
    else if ($_SESSION['account_type'] == 'superadmin') {
        // If account type is 'superadmin', redirect to 403.html
        header('Location: superadmin/index.php');
        exit();
    }
    else if ($_SESSION['account_type'] == 'clerk') {
        // If account type is 'clerk', redirect to 403.html
        header('Location: clerk/index.php');
        exit();
    }
    else if ($_SESSION['account_type'] == 'faculty') {
        // If account type is not 'faculty', redirect to 403.html
        header('Location: faculty/index.php');
        exit();
    }
}
?>
