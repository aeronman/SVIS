<?php
function getDbConnection() {
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'SVIS_DB';

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    return $conn;
}
?>
