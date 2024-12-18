<?php
require('connection.php');
session_start();

$email = $_SESSION['email']; // Retrieve the email from the session

// Assuming you have a 'book' table with the specified columns
$sql = "SELECT * FROM book WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Requests</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f4f4f4;
    }
    .container {
      margin-top: 30px;
    }
    .table {
      background-color: #ffffff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .table th {
      background-color:black;
      color: white;
    }
    .table-hover tbody tr:hover {
      background-color: #f1f1f1;
    }
    h2 {
      margin-bottom: 30px;
      color: #343a40;
      font-weight: 600;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>My Booking Requests</h2>
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Name</th>
          <th>Phone</th>
          <th>Event Date</th>
          <th>Services</th>
          <th>Budget</th>
          <th>Event Type</th>
          
        </tr>
      </thead>
      <tbody>
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['name']); ?></td>
              <td><?php echo htmlspecialchars($row['phone']); ?></td>
              <td><?php echo htmlspecialchars($row['e_date']); ?></td>
              <td><?php echo htmlspecialchars($row['services']); ?></td>
              <td><?php echo htmlspecialchars($row['budget']); ?></td>
              <td><?php echo htmlspecialchars($row['event_type']); ?></td>
             <td> <a href="response.php"></a></td>
            </tr>

          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center">No requests found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
