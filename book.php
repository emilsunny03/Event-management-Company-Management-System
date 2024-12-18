<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking for an Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color:white;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
        }

        h2 {
            color: #00ff9d;
            font-weight: 600;
            margin-bottom: 2rem;
        }

        .card {
            background-color: #242424;
            border: 1px solid #333;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .form-label {
            color: #e0e0e0;
            font-weight: 500;
            margin-bottom: 0.5rem;
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
            padding: 0.5rem 2rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #00cc7d;
            border-color: #00cc7d;
            transform: translateY(-2px);
        }

        .btn-primary + .btn-primary {
            margin-top: 1rem;
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

        /* Date input styling */
        input[type="date"] {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Booking For An Event</h2>

        <!-- Success or Error Message Display -->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Database connection details
            require('connection.php');
            session_start();

            // Retrieve form data and sanitize inputs
            $name = htmlspecialchars($_POST['name']);
            $email =$_SESSION['email'];
            $c_email = htmlspecialchars($_POST['email']);
            $_SESSION['c_email'] = $email;
            $phone = htmlspecialchars($_POST['phone']);
            $e_date = htmlspecialchars($_POST['e_date']);
            $services = htmlspecialchars($_POST['services']);
            $budget = htmlspecialchars($_POST['budget']);
            $event_type = htmlspecialchars($_POST['event_type']);
            $message = htmlspecialchars($_POST['message']);

            // Prepare SQL statement
            $sql = "INSERT INTO book (name, email, c_email, phone, e_date, services, budget, event_type, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Create prepared statement
            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bind_param("sssssssss", $name, $email, $c_email, $phone, $e_date, $services, $budget, $event_type, $message);

            // Execute statement
            if ($stmt->execute()) {
                echo "<div class='alert alert-success text-center'>Your request has been placed successfully. Wait for a call from the company.</div>";
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
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">email:</label>
                    <input type="text" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number:</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="e_date" class="form-label">Date of Event:</label>
                    <input type="date" class="form-control" id="e_date" name="e_date" required>
                </div>
                <div class="mb-3">
                    <label for="services" class="form-label">Services:</label>
                    <input type="text" class="form-control" id="services" name="services" required>
                </div>
                <div class="mb-3">
                    <label for="budget" class="form-label">Budget:</label>
                    <input type="number" class="form-control" id="budget" name="budget" required>
                </div>
                <div class="mb-3">
                    <label for="event_type" class="form-label">Type of Event:</label>
                    <input type="text" class="form-control" id="event_type" name="event_type" required>
                </div>
                
                <!-- New Message Section -->
                <div class="mb-3">
                    <label for="message" class="form-label">Message to Company (Optional):</label>
                    <textarea class="form-control" id="message" name="message" rows="4" placeholder="Write a message to the company..."></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Request</button>
                <br>
                <br>
                <button type="button" class="btn btn-primary w-100">
                    <a href="client.html" style="text-decoration: none; color: black;">Back</a></button>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
