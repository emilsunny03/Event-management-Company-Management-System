<?php
require('connection.php');
session_start();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $email = $_POST['email'];
    $_SESSION['email'] = $email;
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $role = $_POST['role'];

    // Validate password match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match! Please try again.');</script>";
    } else {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the login table using a prepared statement
        $stmt = $conn->prepare("INSERT INTO login (email, pwd, rol) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $hashedPassword, $role);

        if ($stmt->execute()) {
            if($role == 'vendor'){
            echo "<script>window.location.href = 'v_form.html';</script>"; // Redirect to login page
            }else{
                echo "<script>window.location.href = 'c_form.php';</script>"; // Redirect to admin page
            }
        } else {
            echo "<script>alert('Error: Unable to register. Please try again later.');</script>";
        }

        $stmt->close();
    }
}

// Close connection
$conn->close();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventia - Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="client.css">
    <style>
        body {
            background-color: #f0f0f0;
            color: #212121;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .signup-container {
            background: #ffffff;
            border-radius: 15px;
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin: 2rem;
        }

        .signup-header {
            background: #000000;
            padding: 2rem;
            text-align: center;
        }

        .signup-header h2 {
            color: #ffffff;
            margin: 0;
            font-size: 2rem;
            font-weight: 600;
        }

        .signup-form {
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
            border-radius: 8px;
            padding: 0.8rem;
            color: #212121;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #34c759;
            box-shadow: 0 0 0 0.2rem rgba(52, 199, 89, 0.25);
        }

        .input-group-text {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-left: none;
            cursor: pointer;
            color: #212121;
        }

        .input-group-text:hover {
            color: #34c759;
        }

        .btn-primary {
            background-color: #34c759 !important;
            border: none;
            padding: 0.8rem 2rem;
            font-weight: 500;
            border-radius: 30px;
            transition: all 0.3s ease;
            width: 100%;
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: #2ecc71 !important;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(52, 199, 89, 0.3);
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .login-link a {
            color: #34c759;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #2ecc71;
            text-decoration: underline;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23212121' viewBox='0 0 16 16'%3E%3Cpath d='M8 11.5l-5-5h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="signup-header">
            <h2>Create Account</h2>
        </div>
        <div class="signup-form">
            <form id="eventiaForm" action="signup.php" method="POST">
                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           placeholder="Enter your email" required>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Enter your password" required>
                        <span class="input-group-text" onclick="togglePasswordVisibility('password', this)">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" 
                               placeholder="Confirm your password" required>
                        <span class="input-group-text" onclick="togglePasswordVisibility('confirmPassword', this)">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="role" class="form-label">Select Role</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="">Choose your role</option>
                        <option value="client">Client</option>
                        <option value="vendor">Vendor</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Sign Up</button>
                
                <div class="login-link">
                    <a href="login.php">Already have an account? Sign In</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(passwordFieldId, toggleButton) {
            const passwordField = document.getElementById(passwordFieldId);
            const icon = toggleButton.querySelector('i');

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



