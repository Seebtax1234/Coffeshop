<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "store"; // Replace 'your_database_name' with your actual database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
