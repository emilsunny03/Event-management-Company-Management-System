<?php
// Database connection details
require('connection.php');

$searchTerm = htmlspecialchars($_GET['search']);

// Search for locations in your database (adjust the query as needed)
$sql = "SELECT city FROM vendor WHERE city LIKE '%$searchTerm%' LIMIT 10"; // Limit results to 10 for example
$result = mysqli_query($conn, $sql);

$locations = [];
while ($row = mysqli_fetch_assoc($result)) {
    $locations[] = $row['city'];
}

// Send the locations as a JSON response
header('Content-Type: application/json');
echo json_encode($locations);