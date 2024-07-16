<?php
session_start();
require './model/dbconnection.php';

$config = require "./config.php";
$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->dbConnection();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'free') {
    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'doctor') {
        $id = $_POST['id'];
        $sql = "UPDATE appointments SET status='free' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $message = "Slot freed successfully.";
        } else {
            $message = "Error freeing slot: " . $conn->error;
        }
    } else {
        $message = "Unauthorized action.";
    }
}
if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'doctor') {
    $appointments = [];
    $sql = "SELECT * FROM appointments";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
    }
} else {
    $message = "Access denied. Only doctors can view appointments.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Members</title>
    <link rel="stylesheet" href="view/style.css">
</head>
<body>
<?php include 'partials/navbar.php'; ?>
<div class="container">
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'doctor'): ?>
        <h2>Appointment Slots</h2>
        <ul>
            <?php foreach ($appointments as $appointment): ?>
                <li>
                    <?= htmlspecialchars($appointment['slot_time']); ?> - <?= htmlspecialchars($appointment['patient_name']); ?> (<?= htmlspecialchars($appointment['reason']); ?>)
                    <?php if ($appointment['status'] === 'booked'): ?>
                        <form method="POST" action="" style="display:inline;margin-bottom:0;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($appointment['id']); ?>">
                            <button type="submit" name="action" value="free">Free Slot</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if ($message): ?>
            <p style="color: green;"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>
    <?php else: ?>
        <p style="text-align: center;"><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>
</div>

<?php include 'partials/footer.php'; ?> 

</body>
</html>
