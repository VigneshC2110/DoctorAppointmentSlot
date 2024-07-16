<?php
session_start();
require './model/dbconnection.php';

$config = require "./config.php";
$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->dbConnection();

$searchTerm = isset($_POST['search']) ? $_POST['search'] : (isset($_GET['search']) ? $_GET['search'] : '');
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM appointments WHERE patient_name LIKE ? OR reason LIKE ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$likeTerm = "%$searchTerm%";
$stmt->bind_param("ssii", $likeTerm, $likeTerm, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

$totalRows = $conn->query("SELECT COUNT(*) FROM appointments WHERE patient_name LIKE '$likeTerm' OR reason LIKE '$likeTerm'")->fetch_row()[0];
$totalPages = ceil($totalRows / $limit);

$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Results</title>
    <link rel="stylesheet" href="view/style.css">
</head>
<body>
<?php include 'partials/navbar.php'; ?>
<div class="container">
    <h2>Search Results for: <?= htmlspecialchars($searchTerm); ?></h2>
    <div class="search-results">
        <ul>
            <?php foreach ($appointments as $appointment): ?>
                <li><?= htmlspecialchars($appointment['slot_time']); ?> - <?= htmlspecialchars($appointment['patient_name']); ?> (<?= htmlspecialchars($appointment['reason']); ?>)</li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php include 'partials/footer.php'; ?> 
</body>
</html>
