<?php
$host = 'localhost';
$user = 'root';
$password = '';
$db_name = 'company_profile';

$conn = new mysqli($host, $user, $password, $db_name);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
