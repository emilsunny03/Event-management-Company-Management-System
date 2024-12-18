<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventia - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="client.css">
    <style>
        body {
            background-color: #f4f6f9;
            color: #333333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }

        .navbar-brand {
            color: #4a90e2;
            font-weight: bold;
        }

        .dashboard-header {
            background: #ffffff;
            padding: 2rem 0;
            margin-bottom: 2rem;
            color: #333333;
            text-align: left;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }

        .dashboard-header h1 {
            color: #333333;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            text-align: center;
            font-weight: bold;
        }

        

        .stats-container {
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            margin-bottom: 1.5rem;
            border: none;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .stat-card i {
            font-size: 2.5rem;
            color: #4a90e2;
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333333;
            margin-bottom: 0.5rem;
        }

        .stat-card div:last-child {
            color: #666666;
            font-size: 1.1rem;
        }

        .action-container {
            background: transparent;
            border: none;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: none;
        }

        .admin-action-btn {
            background-color: #ffffff !important;
            border: 1px solid #e0e0e0 !important;
            padding: 0.8rem;
            border-radius: 8px;
            color: #333333 !important;
            font-weight: 500;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            text-align: left;
        }

        .admin-action-btn:hover {
            background-color: #f8f9fa !important;
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }

        .admin-action-btn i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Footer styling from client.css */
        footer {
            background:black;
            color:white;
            padding: 2rem 0 1rem;
            margin-top: auto;
            box-shadow: 0 -2px 4px rgba(0,0,0,.1);
        }

        footer a {
            color: #4a90e2;
            text-decoration: none;
        }

        footer a:hover {
            color: #357abd;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg ">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-calendar-alt me-2"></i>Eventia
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="container">
            <h1>Admin Dashboard</h1>
      
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Statistics -->
        <div class="row stats-container">
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <div class="stat-number">150+</div>
                    <div>Total Clients</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="fas fa-store"></i>
                    <div class="stat-number">50+</div>
                    <div>Total Vendors</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="fas fa-calendar-check"></i>
                    <div class="stat-number">200+</div>
                    <div>Total Events</div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-container">
            <a href="a_c_display.php" class="btn admin-action-btn w-100">
                <i class="fas fa-users"></i>View Clients
            </a>
            <a href="a_v_display.php" class="btn admin-action-btn w-100">
                <i class="fas fa-store"></i>View Vendors
            </a>
            <a href="a_change.php" class="btn admin-action-btn w-100">
                <i class="fas fa-cog"></i>Update Settings
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>About Eventia</h5>
                    <p>Your trusted platform for event management and coordination.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="#">Settings</a></li>
                        <li><a href="#">Support</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i>admin@eventia.com</li>
                        <li><i class="fas fa-phone me-2"></i>+1 234 567 890</li>
                    </ul>
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