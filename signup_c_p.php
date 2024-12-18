<?php
// Database connection details
require('connection.php');
session_start();

// Initialize variables
$email = $_SESSION['email'];
$error = '';
$success = '';

// Check if the form is submitted to update the profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize inputs
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $pincode = htmlspecialchars($_POST['pincode']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    }

    // Validate phone number format (adjust validation logic as needed)
    if (!preg_match("/^[0-9]+$/", $phone)) {
        $error = "Invalid phone number format.";
    }

    // Validate pincode format (adjust validation logic as needed)
    if (!preg_match("/^[0-9]{6}$/", $pincode)) {
        $error = "Invalid pincode format.";
    }

    // Update the vendor profile in the database if there are no errors
    if (empty($error)) {
        $updateSQL = "UPDATE client SET name=?, email=?, phone=?, address=?, pincode=? WHERE email=?";
        $stmt = $conn->prepare($updateSQL);
        $stmt->bind_param("ssssss", $name, $email, $phone, $address, $pincode, $email);

        if ($stmt->execute()) {
           header("Location : client.html");
           exit();
        } else {
            $error = "Error updating profile: " . $stmt->error;
        }
    }
}

// Fetch the current profile details using email
$sql = "SELECT * FROM client WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    $row = null;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventia - View Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }

        .navbar {
            background: linear-gradient(to right, #000000, #1a1a1a) !important;
            border-bottom: 1px solid #333;
        }

        .nav-link {
            color: #e0e0e0 !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #00ff9d !important;
        }

        .nav-link.active {
            color: #00ff9d !important;
        }

        .container {
            margin-top: 2rem !important;
        }

        .shadow {
            background-color: #242424 !important;
            border: 1px solid #333;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5) !important;
        }

        .form-label {
            color: #e0e0e0;
        }

        .form-control {
            background-color: #333;
            border: 1px solid #444;
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: #404040;
            border-color: #00ff9d;
            box-shadow: 0 0 0 0.2rem rgba(0, 255, 157, 0.25);
            color: #ffffff;
        }

        .form-control::placeholder {
            color: #888;
        }

        .btn-primary {
            background-color: #00ff9d;
            border-color: #00ff9d;
            color: #121212;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #00cc7d;
            border-color: #00cc7d;
            transform: translateY(-2px);
        }

        .alert-danger {
            background-color: rgba(255, 77, 77, 0.2);
            border-color: #ff4d4d;
            color: #ff4d4d;
        }

        .alert-success {
            background-color: rgba(0, 255, 157, 0.2);
            border-color: #00ff9d;
            color: #00ff9d;
        }

        h2 {
            color: #ffffff;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #444;
        }

        /* Card hover effect */
        .shadow {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3) !important;
        }

        /* Space between buttons */
        .btn-primary + .btn-primary {
            margin-top: 1rem;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Eventia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 d-flex flex-column min-vh-100 justify-content-center">
        <div class="row w-100">
            <div class="col-md-6 mx-auto shadow p-4 rounded">
                <h2 class="text-center mb-4"><?php echo htmlspecialchars($row['name']); ?></h2>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php elseif ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <?php if ($row): ?>
                    <form action="c_profile.php" method="POST" class="form-floating">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($row['address']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pincode" class="form-label">Pincode</label>
                                <input type="text" class="form-control" id="pincode" name="pincode" value="<?php echo htmlspecialchars($row['pincode']); ?>" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                        <a href="client.html" class="btn btn-primary w-100">Back</a>
                    </form>
                <?php else: ?>
                    <p class="text-center">No client profile found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>