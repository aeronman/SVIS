<?php
require_once 'db_connection.php';

header('Content-Type: application/json');

$conn = getDbConnection();

// Define the query to fetch data from violations and join with accounts and sanctions tables
$sql = "
    SELECT
        sv.record_id,
        sv.student_id,
        CONCAT(a.first_name, ' ', COALESCE(a.middle_name, ''), ' ', a.last_name) AS full_name,
        CONCAT(a.course, ' ', a.year, a.section) AS cys,
        v.violation_name,
        sv.offense_count,
        s.sanction_details,
        sv.status,
        sv.date_of_offense
    FROM archived_student_violations sv
    JOIN accounts a ON sv.student_id = a.id
    LEFT JOIN sanctions s ON sv.sanction_id = s.sanction_id
    LEFT JOIN violations v ON sv.violation_id = v.violation_id
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
