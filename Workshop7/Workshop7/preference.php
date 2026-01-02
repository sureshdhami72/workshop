<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['theme'])) {
    setcookie("theme", $_POST['theme'], time() + (86400 * 30));
    header("Location: dashboard.php");
    exit;
}
?>

<form method="post">
    <select name="theme">
        <option value="light">Light Mode</option>
        <option value="dark">Dark Mode</option>
    </select>
    <button>Save</button>
</form>
