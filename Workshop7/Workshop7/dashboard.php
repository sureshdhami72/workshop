<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

$theme = $_COOKIE['theme'] ?? 'light';

$bg = ($theme === 'dark') ? '#000' : '#fff';
$color = ($theme === 'dark') ? '#fff' : '#000';
?>

<body style="background:<?= $bg ?>; color:<?= $color ?>;">
    <h2>Welcome to Dashboard</h2>

    <a href="preference.php">Change Theme</a><br><br>
    <a href="logout.php">Logout</a>
</body>
