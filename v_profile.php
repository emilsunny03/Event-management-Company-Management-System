<?php
require('connection.php');
session_start();
// Initialize variables
$email = $_SESSION['email'];
$error = '';
$success = '';

// Check if the form is submitted to update the profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $website = $_POST['website'];
    $s_offered = $_POST['s_offered'];
    $no_of_emp = $_POST['no_of_emp'];
    $yr_of_exp = $_POST['yr_of_exp'];
    $about = $_POST['about'];

    // Update the vendor profile in the database
    $updateSQL = "UPDATE vendor SET phone=?, address=?, pincode=?, website=?, s_offered=?, no_of_emp=?, yr_of_exp=?, about=? WHERE email=?";
    $stmt = $conn->prepare($updateSQL);
    $stmt->bind_param("sssssssss", $phone, $address, $pincode, $website, $s_offered, $no_of_emp, $yr_of_exp, $about, $email);

    if ($stmt->execute()) {
        $success = "Profile updated successfully!";
    } else {
        $error = "Error updating profile: " . $conn->error;
    }
}

// Fetch the current profile details using email
$sql = "SELECT * FROM vendor WHERE email = ?";
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
    <title>Eventia - Company Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color:white;
            color: #ffffff;
        }

        .navbar {
            background: linear-gradient(to right, #000000, #1a1a1a) !important;
            border-bottom: 1px solid #333;
        }

        .container {
            margin-top: 2rem;
        }

        h2 {
            color:black;
            font-weight: 600;
        }

        .form-container {
            background-color: #242424;
            border: 1px solid #333;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            padding: 2rem;
        }

        .form-label {
            color: #e0e0e0;
            font-weight: 500;
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

        textarea.form-control {
            resize: vertical;
        }

        .btn-primary {
            background-color: #00ff9d;
            border-color: #00ff9d;
            color: #121212;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .btn-primary:hover {
            background-color: #00cc7d;
            border-color: #00cc7d;
            transform: translateY(-2px);
        }

        .btn-primary a {
            color: #121212;
            text-decoration: none;
        }

        .alert-success {
            background-color: rgba(0, 255, 157, 0.2);
            border-color: #00ff9d;
            color: #00ff9d;
        }

        .alert-danger {
            background-color: rgba(255, 77, 77, 0.2);
            border-color: #ff4d4d;
            color: #ff4d4d;
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
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">
        <?php echo isset($row['v_name']) ? htmlspecialchars($row['v_name']) : 'Company Profile'; ?>
    </h2>

    <!-- Display Error or Success Message -->
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if ($row): ?>
        <form action="v_profile.php" method="POST" class="form-container">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($row['address']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="pincode" class="form-label">Pincode</label>
                    <input type="text" class="form-control" id="pincode" name="pincode" value="<?php echo htmlspecialchars($row['pincode']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input type="text" class="form-control" id="website" name="website" value="<?php echo htmlspecialchars($row['website']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="s_offered" class="form-label">Services Offered</label>
                    <input type="text" class="form-control" id="s_offered" name="s_offered" value="<?php echo htmlspecialchars($row['s_offered']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="no_of_emp" class="form-label">Number of Employees</label>
                    <input type="text" class="form-control" id="no_of_emp" name="no_of_emp" value="<?php echo htmlspecialchars($row['no_of_emp']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="yr_of_exp" class="form-label">Years of Experience</label>
                    <input type="text" class="form-control" id="yr_of_exp" name="yr_of_exp" value="<?php echo htmlspecialchars($row['yr_of_exp']); ?>" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="about" class="form-label">About</label>
                    <textarea class="form-control" id="about" name="about" rows="4" required><?php echo htmlspecialchars($row['about']); ?></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update Profile</button>
            <button type="button" class="btn btn-primary w-100">
                <a href="vendor.php">Back</a>
            </button>
        </form>
    <?php else: ?>
        <p class="text-center">No company profile found.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
