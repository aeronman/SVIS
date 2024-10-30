<?php
include 'db_connection.php';

// Database connection
$conn = getDbConnection();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the email from POST request
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (empty($email)) {
        echo json_encode(['exists' => false, 'error' => 'No email provided.']);
        exit();
    }

    try {
        // Prepare the query to check if the email exists
        $query = "SELECT COUNT(*) AS count FROM accounts WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email); // Using bind_param for MySQLi
        $stmt->execute();

        $stmt->bind_result($count);
        $stmt->fetch();

        if ($count > 0) {
            echo json_encode(['exists' => true]);
        } else {
            echo json_encode(['exists' => false]);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['exists' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['exists' => false, 'error' => 'Invalid request method.']);
}
