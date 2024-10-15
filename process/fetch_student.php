<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    $conn = getDbConnection();
    $sql = "SELECT first_name, middle_name, last_name, section, profile_picture 
            FROM accounts WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('s', $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $fullName = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
                echo json_encode([
                    'status' => 'success',
                    'fullName' => $fullName,
                    'section' => $row['section'],
                    'profilePicture' => $row['profile_picture']
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No student found with this ID.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to execute query.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database query failed.']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
