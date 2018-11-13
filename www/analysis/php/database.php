<?php
$servername = "localhost";
$username = "root";
$password = "root";
$port = 3307;
$db = "test";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db, $port);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$db_sql = "CREATE DATABASE IF NOT EXISTS test";
mysqli_query($conn, $db_sql);

$sql = "CREATE TABLE IF NOT EXISTS CLICKCOUNT (
    clickdate VARCHAR(100) NOT NULL,
    clicktimes INT)";
if (mysqli_query($conn, $sql)) {
    // echo "Table clickcount created successfully!";
} else {
    // echo "Error creating table: " . mysqli_error($conn);
}
?>