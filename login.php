<?php
require('connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT email, pwd, rol FROM login WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['pwd'])) {
            $_SESSION['email'] = $email;
            $_SESSION['rol'] = $row['rol'];
          

            if ($row['rol'] === 'client')
            {
                header("Location: client.html");
                exit();
            } elseif($row['rol'] == 'vendor') 
            {
                header("Location: vendor.php");
                exit();
            }else
            {
                header("Location: admin.php");
                exit();
            }
        } else {
            echo "Invalid password";
        }
    } else {
        echo "Invalid username or password";
    }

    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventia - Login</title>
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

        .login-container {
            background: #ffffff;
            border-radius: 15px;
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin: 2rem;
        }

        .login-header {
            background: #000000;
            padding: 2rem;
            text-align: center;
        }

        .login-header h2 {
            color: #ffffff;
            margin: 0;
            font-size: 2rem;
            font-weight: 600;
        }

        .login-form {
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

        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .signup-link a {
            color: #34c759;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .signup-link a:hover {
            color: #2ecc71;
            text-decoration: underline;
        }

        /* Error message styling */
        .error-message {
            background-color: rgba(255, 59, 48, 0.1);
            border: 1px solid #ff3b30;
            color: #ff3b30;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Welcome to Eventia</h2>
        </div>
        <div class="login-form">
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form id="eventiaForm" action="login.php" method="POST">
                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           placeholder="Enter your email" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Enter your password" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" id="signInBtn">Sign In</button>
                </div>
                <br>
                <a href="signup.php" style="text-decoration: none;">Don't have an account? Sign up</a>
            </form>
        </div>
    </div>
</body>
</html>

