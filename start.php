<?php
include 'database_connection.php';

// Create table if not exists
$createTableSQL = "
    CREATE TABLE IF NOT EXISTS page_views (
        id INT PRIMARY KEY,
        count INT DEFAULT 0
    );
";
$stmt->$conn->query($createTableSQL);
$stmt->execute();
// Insert initial row if not exists
$checkExists = $conn->query("SELECT COUNT(*) as count FROM page_views WHERE id = 1");
$row = $checkExists->fetch_assoc();
if ($row['count'] == 0) {
    $conn->query("INSERT INTO page_views (id, count) VALUES (1, 0)");
}

// Get registration count
$regQuery = "SELECT COUNT(*) as reg_count FROM users";
$regResult = $conn->query($regQuery);
$regCount = $regResult->fetch_assoc()['reg_count'];

// Update and get page view count
$conn->query("UPDATE page_views SET count = count + 1 WHERE id = 1");
$viewQuery = $conn->query("SELECT count FROM page_views WHERE id = 1");
$pageViews = $viewQuery->fetch_assoc()['count'];

// Return as JSON
echo json_encode([
  'registrations' => $regCount,
  'page_views' => $pageViews
]);

$conn->close();
?>
