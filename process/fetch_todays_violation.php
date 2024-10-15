<?php
require_once 'db_connection.php';

$conn = getDbConnection();

// Get today's date and the first day of the current month
$today = date('Y-m-d');
$firstDayOfMonth = date('Y-m-01');

// SQL query to count violations where the violation date is today
$sqlToday = "SELECT COUNT(*) as total_violations_today FROM violations WHERE DATE(date) = ?";

// SQL query to count violations for the entire current month
$sqlMonth = "SELECT COUNT(*) as total_violations_month FROM violations WHERE date BETWEEN ? AND ?";

// Prepare the first statement to get today's violations count
if ($stmtToday = $conn->prepare($sqlToday)) {
    $stmtToday->bind_param('s', $today);
    if ($stmtToday->execute()) {
        $resultToday = $stmtToday->get_result();
        $rowToday = $resultToday->fetch_assoc();
        $totalViolationsToday = $rowToday['total_violations_today'];
    }
    $stmtToday->close();
}

// Prepare the second statement to get the month's total violations count
if ($stmtMonth = $conn->prepare($sqlMonth)) {
    $stmtMonth->bind_param('ss', $firstDayOfMonth, $today); // from the first day of the month to today
    if ($stmtMonth->execute()) {
        $resultMonth = $stmtMonth->get_result();
        $rowMonth = $resultMonth->fetch_assoc();
        $totalViolationsMonth = $rowMonth['total_violations_month'];
    }
    $stmtMonth->close();
}

// Calculate the percentage of today's violations over the whole month
$percentage = ($totalViolationsMonth > 0) ? ($totalViolationsToday / $totalViolationsMonth) * 100 : 0;

echo json_encode([
    'status' => 'success',
    'total_violations_today' => $totalViolationsToday,
    'total_violations_month' => $totalViolationsMonth,
    'percentage' => round($percentage, 2) // Round to 2 decimal places
]);

$conn->close();
?>
