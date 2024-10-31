<?php
require_once 'db_connection.php';

$conn = getDbConnection();

// Query to count violations by type, ordered by count in descending order
$sql = "
    SELECT v.violation_id, v.violation_name, COUNT(*) as violation_count
    FROM student_violations sv
    JOIN violations v ON sv.violation_id = v.violation_id
    GROUP BY v.violation_id, v.violation_name
    ORDER BY violation_count DESC";

$stmt = $conn->prepare($sql);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $violations = [];
    while ($row = $result->fetch_assoc()) {
        $violations[] = [
            'violation_type' => $row['violation_name'],
            'violation_count' => $row['violation_count']
        ];
    }
    echo json_encode([
        'status' => 'success',
        'violations' => $violations
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Query failed.']);
}

$stmt->close();
$conn->close();
?>
