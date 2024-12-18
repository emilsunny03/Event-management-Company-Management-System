<?php
// Database connection details
require('connection.php');
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$_SESSION['email'] = $email;
$phone = $_POST['phone'];
$address = $_POST['address'];
$pincode = $_POST['pincode'];






// Prepare SQL statement
$sql = "INSERT INTO client (name, email, phone, address, pincode) VALUES (?, ?, ?, ?, ?)";

// Create prepared statement
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("sssss", $name, $email, $phone, $address, $pincode);

// Execute statement
if ($stmt->execute()) {
    header("Location: login.php");

} else {
    echo "Error: " . $stmt->error;
}
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventia - Client Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
/* Customize the form box */
.shadow {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
}

/* Add some padding for better readability */
.form-control {
    padding: 0.75rem 1.25rem;
}

    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 shadow p-4 rounded"> <h2>Client Registration</h2>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="pincode" class="form-label">Pincode</label>
                        <input type="text" class="form-control" id="pincode" name="pincode" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark mx-auto">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>