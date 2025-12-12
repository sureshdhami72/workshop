<?php
// Simple User Registration (PHP + JSON)
$file_path = 'users.json';
$errors = [];
$success_message = "";

// Handle form submission
if (isset($_POST['register'])) {
    // Collect and sanitize input
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // --- VALIDATION ---
    if ($name === '')        $errors['name'] = "Name is required.";
    if ($email === '')       $errors['email'] = "Email is required.";
    if ($password === '')    $errors['password'] = "Password is required.";
    if ($confirm === '')     $errors['confirm_password'] = "Confirm Password is required.";

    if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if ($password) {
        if (strlen($password) < 8)
            $errors['password'] = "Password must be at least 8 characters long.";
        if (!preg_match('/[^a-zA-Z0-9]/', $password))
            $errors['password'] = "Password must contain at least one special character.";
    }

    if ($password !== $confirm) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    // --- READ EXISTING USERS ---
    $users = [];

    if (empty($errors) && file_exists($file_path)) {
        $data = file_get_contents($file_path);

        if ($data === false) {
            $errors['file_error'] = "Unable to read storage file.";
        } else {
            $users = json_decode($data, true) ?? [];
        }

        // Check email duplicate
        foreach ($users as $u) {
            if ($u['email'] === $email) {
                $errors['email'] = "This email is already registered.";
                break;
            }
        }
    }

    // --- SAVE USER ---
    if (empty($errors)) {
        $users[] = [
            'name'     => $name,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        if (file_put_contents($file_path, json_encode($users, JSON_PRETTY_PRINT)) === false) {
            $errors['file_error'] = "Failed to write to storage file.";
        } else {
            $success_message = "Registration successful!";
            $_POST = []; // Clear form inputs
        }
    }
}
?>
