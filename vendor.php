<?php
require("connection.php");
session_start();
$email = $_SESSION['email'];

// Fetch company details based on the email
if ($email) {
    $sql = "SELECT v_name FROM vendor WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        $row = null;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard - Eventia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="client.css">
    <style>
        /* Dashboard specific styles */
        body {
            background-color: #f0f0f0;
            color: #212121;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .dashboard-container {
            flex: 1;
            padding: 2rem 0;
        }

        .dashboard-header {
            background: linear-gradient(to right, #212121, #2a2a2a);
            padding: 3rem 0;
            margin-bottom: 2rem;
            color: #ffffff;
            text-align: center;
        }

        .dashboard-header h1 {
            color: #ffffff;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .dashboard-stats {
            background: #ffffff;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .iframe-container {
            background: #ffffff;
            border-radius: 15px;
            padding: 1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        iframe {
            width: 100%;
            height: 600px;
            border: none;
            border-radius: 8px;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .action-card {
            background: #ffffff;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .action-card i {
            font-size: 2rem;
            color: #34c759;
            margin-bottom: 1rem;
        }

        /* Footer Styling */
        footer {
            background: #000000;
            color: #ffffff;
            padding: 3rem 0 1.5rem;
            margin-top: auto;
        }

        footer h5 {
            color: #34c759;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        footer a {
            color: #ffffff !important;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        footer a:hover {
            color: #34c759 !important;
            padding-left: 10px;
        }

        .social-icons a {
            font-size: 1.2rem;
            margin-right: 1rem;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            color: #34c759 !important;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg ">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fas fa-calendar-alt"></i> Eventia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="message.php">Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="v_profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Dashboard Header -->
<div class="dashboard-header">
    <div class="container">
        <h1>Welcome, <?php echo isset($row['v_name']) ? htmlspecialchars($row['v_name']) : 'Vendor'; ?></h1>
        <p class="lead">Manage your events and bookings efficiently</p>
    </div>
</div>

<!-- Main Content -->
<div class="container dashboard-container">
   

    <!-- Calendar Section -->
    <div class="iframe-container">
        <iframe src="calendar.php" title="Vendor Calendar"></iframe>
    </div>
</div>

<!-- Enhanced Footer -->
<footer class="text-white py-4">
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
                    <li><a href="#" class="text-white-50">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="mb-3">Connect With Us</h5>
                <div class="social-icons">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <div class="text-center">
            <p>&copy; 2024 Eventia - All Rights Reserved</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
