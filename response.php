<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking for an Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            border: none;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Replay to Client</h2>

        <!-- Success or Error Message Display -->
        <?php
        session_start();
        $email = $_SESSION['$email'];
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Database connection details
            require('connection.php');
            session_start();
            // Retrieve form data and sanitize inputs
            

            $response = htmlspecialchars($_POST['response']);
            
            // Prepare SQL statement
            $c_email = "SELECT c_email FROM book WHERE email = ?";
            $sql = "INSERT INTO response (c_email, response,  email) VALUES (?, ?, ?)";


            // Create prepared statement
            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bind_param("ss", $email, $response);

            // Execute statement
            if ($stmt->execute()) {
                echo "<div class='alert alert-success text-center'>Message Sent!</div>";
            } else {
                echo "<div class='alert alert-danger text-center'>Error: " . $stmt->error . "</div>";
            }

            // Close statement and connection
            $stmt->close();
            $conn->close();
        }
        ?>

        <div class="card shadow-sm p-4">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        
                
                <div class="mb-3">
                    <label for="response" class="form-label"></label>
                    <textarea class="form-control" id="response" name="response" rows="4" placeholder="Write a replay to the client..."></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Replay</button>
                <br>
                <br>
                <button type="button" class="btn btn-primary w-100">
                    <a href="client.html" style="text-decoration: none; color: white;">Back</a></button>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
