<?php
session_start();

// Check if session 'qr_image' is set
if (isset($_SESSION['qr_image'])) {
    $qrImage = $_SESSION['qr_image'];

    // Set headers to force download
    header('Content-Type: image/png');
    header('Content-Disposition: attachment; filename="qr_code.png"');

    // Output the QR image
    echo base64_decode($qrImage);
    exit();
} else {
    // If no QR code is set, redirect back to the profile page
    header('Location: student/index.php');
    exit();
}
?>
