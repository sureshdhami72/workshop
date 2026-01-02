<?php
require 'db.php';

if (isset($_POST['register'])) {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO students (student_id, name, password)
            VALUES (:student_id, :name, :password)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'student_id' => $student_id,
        'name' => $name,
        'password' => $password
    ]);

    header("Location: login.php");
    exit;
}
?>

<form method="post">
    Student ID: <input type="text" name="student_id" required><br>
    Name: <input type="text" name="name" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit" name="register">Register</button>
</form>
