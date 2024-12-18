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
            $success = "Profile updated successfully!";
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
    <link rel="stylesheet" href="client.css">
    <style>
        /* Additional specific styles for profile page */
        body {
            background-color: #f0f0f0;
            color: #212121;
            min-height: 100vh;
        }

        .profile-card {
            background: #ffffff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 2rem auto;
        }

        .profile-header {
            background: linear-gradient(to right, #212121, #2a2a2a);
            padding: 2rem;
            text-align: center;
        }

        .profile-header h2 {
            color: #ffffff;
            margin: 0;
            font-size: 2.5rem;
            font-weight: 600;
        }

        .form-container {
            padding: 2rem;
        }

        .form-label {
            color: #212121;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-control {
            background-color: #ffffff;
            border: 1px solid #ddd;
            color: #212121;
            padding: 0.8rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #34c759;
            box-shadow: 0 0 0 0.2rem rgba(52, 199, 89, 0.25);
        }

        .btn-primary {
            background-color: #34c759 !important;
            border: none;
            padding: 0.8rem 2rem;
            font-weight: 500;
            border-radius: 30px;
            color: #ffffff;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background-color: #2ecc71 !important;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(52, 199, 89, 0.3);
        }

        .alert {
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .alert-success {
            background-color: rgba(52, 199, 89, 0.1);
            border-color: #34c759;
            color: #34c759;
        }

        .alert-danger {
            background-color: rgba(255, 59, 48, 0.1);
            border-color: #ff3b30;
            color: #ff3b30;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Update the navbar section -->
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" style="color: #ffffff;">Eventia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="client.html" style="color: #ffffff;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php" style="color: #ffffff;">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Update the main content section -->
    <div class="container mt-5">
        <div class="profile-card">
            <div class="profile-header">
                <h2>Profile Details</h2>
            </div>
            <div class="form-container">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php elseif ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <?php if ($row): ?>
                    <form action="c_profile.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?php echo htmlspecialchars($row['name']); ?>" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       value="<?php echo htmlspecialchars($row['phone']); ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($row['email']); ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" 
                                       value="<?php echo htmlspecialchars($row['address']); ?>" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="pincode" class="form-label">Pincode</label>
                                <input type="text" class="form-control" id="pincode" name="pincode" 
                                       value="<?php echo htmlspecialchars($row['pincode']); ?>" required>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                            <a href="client.html" class="btn btn-primary w-100 mt-3">Back to Home</a>
                        </div>
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