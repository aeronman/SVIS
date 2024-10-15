<?php
require_once 'db_connection.php';

header('Content-Type: application/json');

$conn = getDbConnection();

// Define the query to fetch data from violations and join with accounts
$sql = "
    SELECT
        v.violation_no,
        v.student_id,
        CONCAT(a.first_name, ' ', COALESCE(a.middle_name, ''), ' ', a.last_name) AS full_name,
        a.profile_picture,
        a.section,
        v.violation_type,
        v.status
    FROM violations v
    JOIN accounts a ON v.student_id = a.id
";

if ($stmt = $conn->prepare($sql)) {
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to execute query.']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database query failed.']);
}

$conn->close();
?>
