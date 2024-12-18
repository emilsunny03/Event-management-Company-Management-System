<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventia - Event Management Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons for the search icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="client.css">
</head>
<body>

<!-- Top Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Eventia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Search Bar (Merged with Search Icon) -->
            <form class="d-flex mx-auto" action="client.php" method="POST">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="Search by district" aria-label="Search" name="search" id="search">
                    <button class="btn btn-outline-success"  type="submit">
                        <i class="fas fa-search"></i> <!-- Font Awesome Search Icon -->
                    </button>
                </div>
            </form>

            <!-- Navbar Links -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
               
                    <!-- Show Profile link only when logged in -->
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">
                            <i class="fas fa-user"></i> Profile
                        </a>
                    </li>
                  
                    <!-- Show Login and Become a Partner links when not logged in -->
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
            </ul>
        </div>
    </div>
</nav>


<?php
require('connection.php');

// Query to fetch vendor data
$query = "SELECT v_name, s_offered FROM vendor";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Listings</title>
    <style>
        /* CSS styles for the cards */
        .card {
            margin: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            width: 100%;
            height: 200px; /* Fixed height for consistency */
            object-fit: cover; /* Ensure aspect ratio is maintained */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="images/product-card.jpg" class="card-img-top" alt="Vendor Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['v_name']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($row['s_offered']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No companies found.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>






<!-- Footer -->
<footer class="bg-dark text-white text-center p-4 mt-5">
    <p>&copy; 2024 Eventia - All Rights Reserved</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
