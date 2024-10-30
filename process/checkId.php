<?php
include 'db_connection.php';

 // Database connection
$conn = getDbConnection();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountType = $_POST['accountType'];
    $id = $_POST['id'];

    $query = "SELECT COUNT(*) as count FROM accounts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    echo json_encode(['exists' => $data['count'] > 0]);
}
?>
