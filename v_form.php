<?php
// Database connection details
require('connection.php');
session_start();



// Retrieve form data
$cin = $_POST['cin'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$pincode = $_POST['pincode'];
$website = $_POST['website'];
$v_name = $_POST['company_name'];
$s_offered = $_POST['services'];
$no_of_emp = $_POST['employees'];
$yr_of_exp = $_POST['years_experience'];
$social_media = $_POST['social_media'];
$about = $_POST['about'];





// Prepare SQL statement
$sql = "INSERT INTO vendor (v_id, email, phone, address, city, state,
 country, pincode, website, v_name, s_offered, no_of_emp, 
 yr_of_exp, social_media, about ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?,?, ?, ?, ?, ?)";

// Create prepared statement
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("sssssssssssssss", $cin, $email, $phone, $address, $city, $state, $country, $pincode, $website,  $v_name, $s_offered, $no_of_emp, 
$yr_of_exp, $social_media, $about);

// Execute statement
if ($stmt->execute()) {
    header("Location: vendor.php");

} else {
    echo "Error: " . $stmt->error;
}

// Close statement
$stmt->close();

// Close connection
$conn->close();
?>