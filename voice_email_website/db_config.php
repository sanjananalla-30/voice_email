<?php
$host = "localhost";
$user = "root";
$password = ""; // Set your own password if you have one
$database = "voice_email_db";

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
