<div class="navbar_container">
    <div class="logo" style="width: 160px;">
        <a href="home"><img style="width: 100%; height: 100px;" src="../../view/src/pro.webp" alt="Doctor"></a>
    </div>
    <h2>Apollo Hospital<br>
        <span style="font-size: 12px;">(Get your appointment soon)</span>
    </h2>
<form class="search" method="POST" action="search">
    <input style="width: 50%;margin-bottom:0;" type="text" name="search" placeholder="Search by name or reason" required>
    <button style="width: 80px;font-size:14px;" type="submit">Search</button>
</form>
    <div class="profile">
        <?php if (isset($_SESSION['user'])): ?>
            <p>Welcome, <?= htmlspecialchars($_SESSION['user']['username']); ?>!</p>
            <a href="../../view/partials/logout.php">Logout</a>
            <?php if ($_SESSION['user']['role'] === 'doctor'): ?>
                <a style="position: absolute;bottom:-6px;" href="appointmentmembers">Appointment Members</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="login">Login</a>
        <?php endif; ?>
        <?php if ($message) { echo "<p>$message</p>"; } ?>
    </div>
</div>
