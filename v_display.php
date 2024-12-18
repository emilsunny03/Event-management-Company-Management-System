<?php
// Database connection details (assuming you have a separate connection file)
require('connection.php');

// Assuming we are retrieving a specific vendor based on an ID passed in the URL
$v_id = isset($_GET['v_id']) ? $_GET['v_id'] : null; // Get vendor ID from URL

// If $v_id is set, fetch company details, otherwise leave $row as null
if ($v_id) {
    $sql = "SELECT v_name, v_id, email, phone, address, city, state, country, pincode, website, s_offered, no_of_emp, yr_of_exp, about, social_media 
            FROM vendor WHERE v_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $v_id); // Bind the vendor ID to the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the result as an associative array
        $row = $result->fetch_assoc();

        // Check if email exists and is valid before storing in session
        if (isset($row['email']) && filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
            session_start();  // Start session if not already started
            $_SESSION['email'] = $row['email'];  // Store email in session
        } else {
            echo "Error: Invalid email address found in database.";
        }
    } else {
        $row = null; // Set $row to null if no data is found
    }

    // Close statement and connection
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="client.css">
    <style>
        /* Additional specific styles for v_display.php */
        .vendor-card {
            background: #ffffff;
            border-radius: 15px;
            overflow: hidden;
            margin-top: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .vendor-header {
            background: linear-gradient(to right, #212121, #2a2a2a);
            padding: 2rem;
            color: #ffffff;
            text-align: center;
        }

        .vendor-header h1 {
            color: #ffffff;
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }

        .card {
            background: #ffffff !important;
            border: none !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .card-text {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            color: #212121;
            border: 1px solid #e9ecef;
        }

        .card-text strong {
            color: #34c759;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #34c759 !important;
            border: none;
            padding: 0.8rem 2.5rem;
            font-weight: 500;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2ecc71 !important;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(52, 199, 89, 0.3);
        }

        /* Update navbar styles to match client.html */
        .navbar {
            background: linear-gradient(to right, #212121, #2a2a2a) !important;
        }

        .navbar-brand {
            color: #34c759 !important;
            font-weight: bold;
        }

        .nav-link {
            color: #e0e0e0 !important;
        }

        .nav-link:hover {
            color: #34c759 !important;
        }

        /* Search bar styling */
        .form-control {
            background-color: #ffffff !important;
            border: 1px solid #ddd !important;
            color: #212121 !important;
        }

        .form-control:focus {
            border-color: #34c759 !important;
            box-shadow: 0 0 0 0.2rem rgba(52, 199, 89, 0.25) !important;
        }

        .btn-outline-success {
            color: #34c759 !important;
            border-color: #34c759 !important;
        }

        .btn-outline-success:hover {
            background-color: #34c759 !important;
            color: #ffffff !important;
        }

        /* Body background */
        body {
            background-color: #f0f0f0 !important;
            color: #212121 !important;
        }

        /* Links */
        a {
            color: #34c759;
            text-decoration: none;
        }

        a:hover {
            color: #2ecc71;
        }

        /* Footer update */
        footer {
            background: linear-gradient(to right, #212121, #2a2a2a) !important;
            color: #ffffff !important;
        }

        footer h5 {
            color: #34c759 !important;
        }

        footer a {
            color: #e0e0e0 !important;
            transition: all 0.3s ease;
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

<!-- Top Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Eventia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Search Bar -->
            <form class="d-flex mx-auto" action="client.php" method="POST">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="Search by location" aria-label="Search" name="search" id="search">
                    <button class="btn btn-outline-success" type="submit">
                        <i class="fas fa-search"></i> <!-- Font Awesome Search Icon -->
                    </button>
                </div>
            </form>

            <!-- Navbar Links -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="client.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Vendor Details Section -->
<div class="container mt-5">
    <div class="vendor-card">
        <div class="vendor-header">
            <h1><?php echo htmlspecialchars($row['v_name'] ?? "Company Details"); ?></h1>
        </div>
        <div class="card-body">
            <?php if ($row): ?>
                <p class="card-text"><strong>Company ID:</strong> <?php echo htmlspecialchars($row['v_id']); ?></p>
                <p class="card-text"><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></p>
                <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                <p class="card-text"><strong>Phone Number:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
                <p class="card-text"><strong>City:</strong> <?php echo htmlspecialchars($row['city']); ?></p>
                <p class="card-text"><strong>State:</strong> <?php echo htmlspecialchars($row['state']); ?></p>
                <p class="card-text"><strong>Country:</strong> <?php echo htmlspecialchars($row['country']); ?></p>
                <p class="card-text"><strong>Pincode:</strong> <?php echo htmlspecialchars($row['pincode']); ?></p>
                <p class="card-text"><strong>Website:</strong> <a href="<?php echo htmlspecialchars($row['website']); ?>" target="_blank"><?php echo htmlspecialchars($row['website']); ?></a></p>
                <p class="card-text"><strong>Services Offered:</strong> <?php echo htmlspecialchars($row['s_offered']); ?></p>
                <p class="card-text"><strong>Number of Employees:</strong> <?php echo htmlspecialchars($row['no_of_emp']); ?></p>
                <p class="card-text"><strong>Years of Experience:</strong> <?php echo htmlspecialchars($row['yr_of_exp']); ?></p>
                <p class="card-text"><strong>About:</strong> <?php echo htmlspecialchars($row['about']); ?></p>
                <p class="card-text"><strong>Social Media:</strong> <?php echo htmlspecialchars($row['social_media']); ?></p>
                <div class="text-center">
                    <a href="book.php" class="btn btn-primary">Book Now</a>
                </div>
            <?php else: ?>
                <p class="text-center">No company details found for the given ID.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Enhanced Footer -->
<footer class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="mb-3">About Eventia</h5>
                <p>Your trusted partner in creating memorable events and celebrations.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white-50">About Us</a></li>
                    <li><a href="#" class="text-white-50">Services</a></li>
                    <li><a href="#" class="text-white-50">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="mb-3">Follow Us</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white-50">Facebook</a></li>
                    <li><a href="#" class="text-white-50">Twitter</a></li>
                    <li><a href="#" class="text-white-50">Instagram</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script src="v_display.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
