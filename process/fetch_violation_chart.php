<?php
require_once 'db_connection.php';

$conn = getDbConnection();

// Get the current year
$currentYear = date('Y');

// SQL query to count violations per month by violation_type for the current year
$sql = "SELECT 
            violation_type, 
            MONTH(date) as month, 
            COUNT(*) as count 
        FROM violations 
        WHERE YEAR(date) = ? 
        GROUP BY violation_type, MONTH(date) 
        ORDER BY MONTH(date), violation_type";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('i', $currentYear);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $violationsData = [];
        
        // Organize data by month and violation type
        while ($row = $result->fetch_assoc()) {
            $month = $row['month'];
            $violationType = $row['violation_type'];
            $count = $row['count'];

            if (!isset($violationsData[$violationType])) {
                $violationsData[$violationType] = array_fill(1, 12, 0); // Fill array with 0s for each month
            }

            $violationsData[$violationType][$month] = $count;
        }

        echo json_encode([
            'status' => 'success',
            'violations' => $violationsData
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to fetch violation data.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database query failed.']);
}

$conn->close();
?>
