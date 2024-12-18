<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventia - Change User Role</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: white;
            color: white;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: #242424;
            padding: 40px;
            border-radius: 15px;
            border: 1px solid #333;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            max-width: 500px;
            width: 100%;
            margin: 2rem;
        }

        h2 {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            font-weight: 600;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            color: #e0e0e0;
            font-weight: 500;
        }

        input[type="text"] {
            padding: 12px;
            margin-bottom: 20px;
            background-color: #333;
            border: 1px solid #444;
            border-radius: 8px;
            color: #ffffff;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus {
            outline: none;
            border-color:black;
            box-shadow: 0 0 0 2px rgba(0, 255, 157, 0.25);
        }

        input[type="submit"] {
            padding: 12px;
            background-color:black;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        input[type="submit"]:hover {
            background-color: #00cc7d;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 255, 157, 0.3);
        }

        .back-link {
            display: inline-block;
            width: 100%;
            padding: 12px;
            background-color:black;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            background-color: #00cc7d;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 255, 157, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Change User Role</h2>
        <form action="" method="post">
            <label for="Email">Email:</label>
            <input type="text" id="Email" name="Email" required>
            <label for="role">New Role:</label>
            <input type="text" id="role" name="role" required>
            <label for="pwd">New Password</label>
            <input type="text" id="pwd" name="pwd" required>
            <input type="submit" value="Change Role">
        </form>
        <?php
        include 'connection.php'; // Include your database connection file

        if ($_SERVER['REQUEST_METHOD'] == 'POST') { // if Form is submitted
            $email = $_POST['Email'];
            $nrole = $_POST['role'];
            $password = $_POST['pwd'];
            $sql = "INSERT INTO login (email, rol, pwd) VALUES ('$email', '$nrole', '$password')";        
                $result = mysqli_query($conn, $sql);

            if($result){echo 'Adding New Admin Succesfully';}
        }
        ?>
        <a href="admin.php" class="back-link">Previous page</a>
    </div>
</body>
</html>