<?php
session_start();

// Check if session 'account_type' is set
if (isset($_SESSION['account_type'])) {
    // Check if the account type is 'clerk'
    if ($_SESSION['account_type'] !== 'clerk') {
        // If account type is not 'clerk', redirect to 403.html
        header('Location: ../403.html');
        exit();
    }
} else {
    // If 'account_type' session is not set, redirect to login.php
    header('Location: ../index.php');
    exit();
}
?>
