<?php
require_once 'db_connection.php';

$conn = getDbConnection();

// Get the first day of the current month and the current date
$firstDayOfMonth = date('Y-m-01');
$today = date('Y-m-d');

// SQL query to count violations for the entire current month
$sqlMonth = "SELECT COUNT(*) as total_violations_month FROM violations WHERE date BETWEEN ? AND ?";

if ($stmtMonth = $conn->prepare($sqlMonth)) {
    $stmtMonth->bind_param('ss', $firstDayOfMonth, $today);
    if ($stmtMonth->execute()) {
        $resultMonth = $stmtMonth->get_result();
        $rowMonth = $resultMonth->fetch_assoc();
        $totalViolationsMonth = $rowMonth['total_violations_month'];
    }
    $stmtMonth->close();
}

echo json_encode([
    'status' => 'success',
    'total_violations_month' => $totalViolationsMonth
]);

$conn->close();
?>
