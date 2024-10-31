<?php
require_once 'db_connection.php';

$conn = getDbConnection();

// Get filter parameters from the request
$month = isset($_GET['month']) ? $_GET['month'] : null;
$year = isset($_GET['year']) ? $_GET['year'] : null;
$studentYear = isset($_GET['student_year']) ? $_GET['student_year'] : null;

// Create the SQL query with filters
$sql = "
    SELECT v.violation_name, COUNT(*) as violation_count
    FROM student_violations sv
    JOIN accounts s ON sv.student_id = s.id
    JOIN violations v ON sv.violation_id = v.violation_id
    WHERE 1=1";

// Apply filters
if ($month) {
    $sql .= " AND MONTH(sv.date_of_offense) = ?";
}
if ($year) {
    $sql .= " AND YEAR(sv.date_of_offense) = ?";
}
if ($studentYear) {
    $sql .= " AND s.year = ?";
}

$sql .= " GROUP BY v.violation_name";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters based on filters
$params = [];
if ($month) $params[] = $month;
if ($year) $params[] = $year;
if ($studentYear) $params[] = $studentYear;

if ($params) {
    $stmt->bind_param(str_repeat('i', count($params)), ...$params);
}

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $violationsData = [];
    
    while ($row = $result->fetch_assoc()) {
        $violationsData[] = $row;
    }

    // Return the data as JSON
    echo json_encode(['status' => 'success', 'data' => $violationsData]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Query failed.']);
}

$stmt->close();
$conn->close();
?>
