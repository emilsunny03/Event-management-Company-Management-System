<?php
// Connection parameters
$host = 'localhost'; // MySQL host
$username = 'root'; // MySQL username
$password = 'root'; // MySQL password
$dbname = 'emcms'; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
   
}
?>
