<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "confession_wall";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS confession_wall";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

$conn->select_db($dbname);

// Create registration table
$sql = "CREATE TABLE IF NOT EXISTS registeration (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    pname VARCHAR(100) NOT NULL,
    userpassword VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Registration table created successfully<br>";
} else {
    echo "Error creating registration table: " . $conn->error . "<br>";
}

// Create confession table
$sql = "CREATE TABLE IF NOT EXISTS confession (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    confession_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Confession table created successfully<br>";
} else {
    echo "Error creating confession table: " . $conn->error . "<br>";
}

$conn->close();
?>