<?php
include('database_connection.php');

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="table_data.csv"');
header('Pragma: no-cache');
header('Expires: 0');

// Create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Column headers
fputcsv($output, array('name', 'email', 'phone', 'payment_id'));

// Fetch data from database
$sql = "SELECT username , email, phone, payment_id FROM users";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$conn->close();
exit;
?>
