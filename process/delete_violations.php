<?php
require_once 'db_connection.php';

$conn = getDbConnection();
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $violationId = $_POST['violation_id'];

    // Delete sanction first, then violation
    $conn->begin_transaction();
    try {
        $sql = "DELETE FROM sanctions WHERE violation_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $violationId);
        $stmt->execute();

        $sql = "DELETE FROM violations WHERE violation_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $violationId);
        $stmt->execute();

        $conn->commit();
        echo json_encode(['status' => 'success', 'message' => 'Violation deleted successfully.']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete violation.']);
    }
}

$conn->close();
?>
