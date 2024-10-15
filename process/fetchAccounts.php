<?php
// Include database connection file
require_once 'db_connection.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountType = isset($_POST['accountType']) ? $_POST['accountType'] : '';

    // Validate and sanitize input
    $accountType = filter_var($accountType, FILTER_SANITIZE_STRING);

    // Database connection
    $conn = getDbConnection();

    // Prepare SQL statement
    $sql = "SELECT id, profile_picture, first_name, middle_name, last_name, section, advisory_class, qr_image, account_type FROM accounts WHERE account_type = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('s', $accountType);
        $stmt->execute();
        $result = $stmt->get_result();

        // Initialize response data
        $response = [
            'headers' => '',
            'rows' => ''
        ];

        // Determine table headers and rows based on account type
        switch ($accountType) {
            case 'student':
                $response['headers'] = '<th>ID</th><th>Profile Picture</th><th>Full Name</th><th>Section</th><th>QR Image</th><th>Action</th>';
                while ($row = $result->fetch_assoc()) {
                    $fullName = htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
                    $response['rows'] .= '<tr>';
                    $response['rows'] .= '<td>' . htmlspecialchars($row['id']) . '</td>';
                    $response['rows'] .= '<td><img src="'.$row['profile_picture'].'" alt="Profile Picture" style="width:50px; height:50px;"></td>';
                    $response['rows'] .= '<td>' . $fullName . '</td>';
                    $response['rows'] .= '<td>' . htmlspecialchars($row['section']) . '</td>';
                    $response['rows'] .= '<td><img src="data:image/jpeg;base64,' .$row['qr_image']. '" alt="QR Image" style="width:50px; height:50px; border-radius:0 !important;"></td>';
                    $response['rows'] .= '<td><a href="editaccount.php?id='.$row['id'].'"><button class="btn btn-primary">Edit</button></a> <button class="btn btn-danger" onclick="confirmDelete('.$row['id'].')">Delete</button></td>';
                    $response['rows'] .= '</tr>';
                }
                break;

            case 'admin':
            case 'superadmin':
            case 'clerk':
                $response['headers'] = '<th>ID</th><th>Profile Picture</th><th>Full Name</th><th>Action</th>';
                while ($row = $result->fetch_assoc()) {
                    $fullName = htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
                    $response['rows'] .= '<tr>';
                    $response['rows'] .= '<td>' . htmlspecialchars($row['id']) . '</td>';
                    $response['rows'] .= '<td><img src="'.$row['profile_picture'].'" alt="Profile Picture" style="width:50px; height:50px;"></td>';
                    $response['rows'] .= '<td>' . $fullName . '</td>';
                    $response['rows'] .= '<td><a href="editaccount.php?id='.$row['id'].'"><button class="btn btn-primary">Edit</button></a> <button class="btn btn-danger" onclick="confirmDelete('.$row['id'].')">Delete</button></td>';
                    $response['rows'] .= '</tr>';
                }
                break;

            case 'faculty':
                $response['headers'] = '<th>ID</th><th>Profile Picture</th><th>Full Name</th><th>Advisory</th><th>Action</th>';
                while ($row = $result->fetch_assoc()) {
                    $fullName = htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
                    $response['rows'] .= '<tr>';
                    $response['rows'] .= '<td>' . htmlspecialchars($row['id']) . '</td>';
                    $response['rows'] .= '<td><img src="'.$row['profile_picture'].'" alt="Profile Picture" style="width:50px; height:50px;"></td>';
                    $response['rows'] .= '<td>' . $fullName . '</td>';
                    $response['rows'] .= '<td>' . htmlspecialchars($row['advisory_class']) . '</td>';
                    $response['rows'] .= '<td><a href="editaccount.php?id='.$row['id'].'"><button class="btn btn-primary" onclick="confirmDelete('.$row['id'].')">Edit</button></a> <button class="btn btn-danger">Delete</button></td>';
                    $response['rows'] .= '</tr>';
                }
                break;

            default:
                $response['rows'] = '<tr><td colspan="5">Invalid account type selected.</td></tr>';
        }

        // Output JSON response
        header('Content-Type: application/json');
        echo json_encode($response);

        // Free result set
        $result->free();
        $stmt->close();
    } else {
        echo json_encode([
            'headers' => '',
            'rows' => '<tr><td colspan="5">Database query failed.</td></tr>'
        ]);
    }

    // Close connection
    $conn->close();
} else {
    echo json_encode([
        'headers' => '',
        'rows' => '<tr><td colspan="5">Invalid request method.</td></tr>'
    ]);
}
?>
