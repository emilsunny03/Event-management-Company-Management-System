<?php
require('connection.php');
$sql = "SELECT email, rol FROM login";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventia - Users Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color:white;
            color: #ffffff;
            min-height: 100vh;
        }

        .nav-link {
            color: #e0e0e0 !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #00ff9d !important;
        }

        .container {
            background-color: #242424;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            margin-top: 40px;
        }

        h2 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.2rem;
            font-weight: bold;
        }

        table {
            width: 100%;
            margin-bottom: 30px;
            background: #242424;
            border-radius: 10px;
            overflow: hidden;
            color: #e0e0e0;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #333;
        }

        th {
            background: #1a1a1a;
            color:white;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        tr:hover {
            background-color: #333;
            transition: background-color 0.3s ease;
        }

        .delete-link {
            display: inline-block;
            padding: 12px 25px;
            background-color: #ff4d4d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-align: center;
            margin-top: 20px;
            font-weight: 500;
        }

        .delete-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 65, 108, 0.3);
            color: white;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background: linear-gradient(to right, #1a2980, #26d0ce);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 41, 128, 0.3);
            color: white;
        }

        .actions-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

 

    <div class="container">
        <h2><i class="fas fa-users me-2"></i>Users Management</h2>
        
        <table>
            <tr>
                <th><i class="fas fa-user me-2"></i>Name</th>
                <th><i class="fas fa-envelope me-2"></i>Email</th>
                <th><i class="fas fa-user-tag me-2"></i>Role</th>
            </tr>
            <?php
            $sql = "SELECT login.email, login.rol, client.name FROM login INNER JOIN client ON login.email = client.email";
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["name"]) . "</td>
                            <td>" . htmlspecialchars($row["email"]) . "</td>
                            <td>" . htmlspecialchars($row["rol"]) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='text-center'>No users found</td></tr>";
            }
            ?>
        </table>

        <div class="actions-container">
            <a href="admin.php" class="back-button">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
            <a href="a_delete.php" class="delete-link">
                <i class="fas fa-trash-alt me-2"></i>Delete User
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
