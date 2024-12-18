<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Delete</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Delete User</h2>
        <form action="" method="post">
            <label for="Email">Email:</label>
            <input type="text" id="Email" name="Email" required>
            <input type="submit" value="Delete User">
        </form>
        <?php
        require('connection.php');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['Email'];
            // Using multiple DELETE statements
            $sql1 = "DELETE FROM login WHERE email = ?";
            $sql2 = "DELETE FROM client WHERE email = ?";
            $sql3 = "DELETE FROM vendor WHERE email = ?";
            
            // Prepare and execute statements
            $stmt1 = mysqli_prepare($conn, $sql1);
            $stmt2 = mysqli_prepare($conn, $sql2);
            $stmt3 = mysqli_prepare($conn, $sql3);
            
            mysqli_stmt_bind_param($stmt1, "s", $email);
            mysqli_stmt_bind_param($stmt2, "s", $email);
            mysqli_stmt_bind_param($stmt3, "s", $email);
            
            // Start transaction
            mysqli_begin_transaction($conn);
            
            try {
                mysqli_stmt_execute($stmt1);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_execute($stmt3);
                mysqli_commit($conn);
                echo 'User deleted successfully ';
            } catch (Exception $e) {
                mysqli_rollback($conn);
                echo 'Error deleting user: ' . $e->getMessage();
            }
            
            mysqli_stmt_close($stmt1);
            mysqli_stmt_close($stmt2);
            mysqli_stmt_close($stmt3);
        }
        ?>
        <a href="a_c_display.php">Back</a>
    </div>
</body>
</html>
