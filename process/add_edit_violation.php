<?php
// Database connection (adjust to your configuration)
include 'db_connection.php';

 // Database connection
 $conn = getDbConnection();
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if it's an add or update request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $violationId = isset($_POST['violation_id']) ? $_POST['violation_id'] : null;
    $violationName = $_POST['violationName'];
    $description = $_POST['description'];
    $offenseCount = $_POST['offenseCount'];
    $sanctionDetails = $_POST['sanctionDetails'];

    if ($violationId) {
        // Update existing violation
        $sql = "UPDATE violations SET violation_name=?, description=? WHERE violation_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $violationName, $description, $violationId);
        $stmt->execute();

        // Update corresponding sanction
        $sql = "UPDATE sanctions SET offense_count=?, sanction_details=? WHERE violation_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $offenseCount, $sanctionDetails, $violationId);
        $stmt->execute();

        echo json_encode(['status' => 'success', 'message' => 'Violation updated successfully.']);
    } else {
        // Add new violation
        $conn->begin_transaction();
        try {
            // Insert violation
            $sql = "INSERT INTO violations (violation_name, description) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $violationName, $description);
            $stmt->execute();

            // Get last inserted violation ID
            $violationId = $conn->insert_id;

            // Insert sanction
            $sql = "INSERT INTO sanctions (violation_id, offense_count, sanction_details) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iis", $violationId, $offenseCount, $sanctionDetails);
            $stmt->execute();

            $conn->commit();
            echo json_encode(['status' => 'success', 'message' => 'Violation added successfully.']);
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(['status' => 'error', 'message' => 'Failed to add violation.']);
        }
    }
}

$conn->close();
?>
