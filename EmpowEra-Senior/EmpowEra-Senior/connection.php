<?php
// Database credentials
error_reporting(E_ALL);
ini_set('display_errors', 1);
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'seniorproject';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die('❌ Connection failed: ' . $conn->connect_error);
}

echo "✅ Connected successfully";
?>
