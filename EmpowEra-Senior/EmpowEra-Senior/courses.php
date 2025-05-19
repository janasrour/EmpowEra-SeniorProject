<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "seniorproject");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle course addition
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_course"])) {
    $title = $conn->real_escape_string($_POST["title"]);
    $desc = $conn->real_escape_string($_POST["description"]);
    $conn->query("INSERT INTO course (title, description) VALUES ('$title', '$desc')");
}
?>



    