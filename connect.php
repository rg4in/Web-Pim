<?php
$servername = getenv('MYSQL_HOST');
$username = getenv('MYSQL_USERNAME');
$dbname = getenv('MYSQL_DATABASE');

// Create connection
$conn = new mysqli($servername, $username, '', $dbname); // ลบ $password ออก

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
