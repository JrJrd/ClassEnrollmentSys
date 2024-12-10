<?php
$servername = "localhost"; // Database host
$username = "root"; // Database username (default for XAMPP)
$password = ""; // Database password (default is empty for XAMPP)
$dbname = "db"; // The name of your database (changed from 'user_system' to 'db')

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
