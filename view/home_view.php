<?php
session_start();
require './model/dbconnection.php';

$config = require "./config.php";
$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->dbConnection();

$message = '';

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
    <title>Doctor Website</title>
    <link rel="stylesheet" href="view/style.css">
</head>
<body>
    <?php include 'partials/navbar.php'; ?>
    <img style="width:100%;position: absolute;" src="../view/src/medical.jpg" alt="" srcset="">
    <div style="position: relative;top:130px;right:95px;" class="container">
        <h1 style="font-size: 45px;">Welcome to Apollo Hospital</h1>
        <p style="font-size: 25px;">Book your appointment now!</p>
       <button style="width:30%"><a style="font-size: 18px;color:white;text-decoration:unset;" href="appointment" class="btn">Go to Appointment Booking</a></button>
    </div>
    <?php include 'partials/footer.php'; ?>
</body>
</html>
