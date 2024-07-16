<?php
session_start();
require './model/dbconnection.php';

$config = require "./config.php";
$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->dbConnection();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $patient_name = $_POST['patient_name'];
    $reason = $_POST['reason'];
    $slot_time = $_POST['slot_time'];

    $sql_check = "SELECT * FROM appointments WHERE slot_time='$slot_time' AND status='booked'";
    $result_check = $conn->query($sql_check);
    if ($result_check->num_rows > 0) {
        $message = "Slot already booked.";
    } else {
        $sql = "INSERT INTO appointments (patient_name, reason, slot_time, status) VALUES ('$patient_name', '$reason', '$slot_time', 'booked')";
        if ($conn->query($sql) === TRUE) {
            $message = "Appointment booked successfully.";
        } else {
            $message = "Error booking appointment: " . $conn->error;
        }
    }
}
$appointments = [];
$sql = "SELECT * FROM appointments";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking</title>
    <link rel="stylesheet" href="view/style.css">
</head>
<body>
    <?php include 'partials/navbar.php'; ?>
    <?php include 'partials/appointment_booking.php'; ?>
    <?php include 'partials/footer.php'; ?>
</body>
</html>
