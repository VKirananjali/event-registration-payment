<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: admin.html");
        exit();
    }
    include('database_connection.php');
    $sql = "SELECT COUNT(*) AS total FROM users";
    $count = mysqli_query($conn,$sql);
    $count = mysqli_fetch_assoc($count);
    $count = $count['total'];

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/admin_dashboard.css">
</head>
<body>
    <div class="header">
    <form action="http://localhost:8080/event_registration/logout.php" method="post">
        <button type="submit" class="logout-btn">Logout</button>
    </form>
  </div>
    <h3>Total Registrations: <?php echo $count; ?></h3>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Payment ID</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['payment_id']); ?></td>
            </tr>
        <?php endwhile; ?>
        <a href="download.php">
          <button class="download-btn">Download CSV</button>
        </a>
      </table>
    <?php else: ?>
        <p>No registrations found.</p>
    <?php endif; ?>
  </div>


</body>
</html>

<?php
$conn->close();
?>
