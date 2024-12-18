<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventia - Vendor Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: white;
            color: #ffffff;
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(to right, #000000, #1a1a1a) !important;
            border-bottom: 1px solid #333;
        }

        .container {
            background-color:black;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
            border: 1px solid #333;
        }

        h2 {
            text-align: center;
            color: white;
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
            background-color: #1a1a1a;
            color: white;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        tr:hover {
            background-color: #333;
            transition: background-color 0.3s ease;
        }

        #l1 {
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

        #l1:hover {
            background-color: #cc3d3d;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 77, 77, 0.3);
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
        <h2>Vendor Table</h2>
        <table>
            <tr>
                <th>Company Name</th>
                <th>Email</th>
            </tr>
            <?php
            require('connection.php');
             
             
            $sql = "SELECT login.email, login.rol, vendor.v_name FROM login INNER JOIN vendor ON login.email = vendor.email";
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["v_name"]. "</td>
                            <td>" . $row["email"]. "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No results found</td></tr>";
            }
            ?>
        </table><p style="color: red; font-size: 20px;">
        <div class="actions-container">
            <a href="admin.php" class="back-button">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
            <a href="a_delete.php" class="delete-link">
                <i class="fas fa-trash-alt me-2"></i>Delete User
            </a>
        </div>
    </div>

    </div>
</body>
</html>
