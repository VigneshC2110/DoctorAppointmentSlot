<?php
session_start();
require './model/dbconnection.php';

$config = require "./config.php";
$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->dbConnection();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ];
        header('Location: home'); 
        exit;
    } else {
        $message = "Invalid username or password.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Appointment Booking</title>
    <link rel="stylesheet" href="view/style.css">
</head>
<body>
    <?php include 'partials/navbar.php'; ?>
    <div class="form1">
        <h2>Login</h2>
        <?php if (!empty($message)): ?>
            <p class="error-message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="input1">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input2">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
    <?php include 'partials/footer.php'; ?>
</body>
</html>
