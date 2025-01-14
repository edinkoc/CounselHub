<?php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    $errors = [];

    if (empty($username)) {
        $errors[] = 'Username is required';
    }

    if (empty($password)) {
        $errors[] = 'Password is required';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $directory = dirname($_SERVER['PHP_SELF']);
        header("Location: $directory/attorney-login.php");
        exit();
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $stmt = $pdo->prepare("
                SELECT r.role
                FROM user_roles ur
                JOIN user_role r ON ur.roles_id = r.id
                WHERE ur.user_user_id = :user_id
            ");
            $stmt->execute(['user_id' => $admin['user_id']]);
            $role = $stmt->fetchColumn();

            if ($role === 'ROLE_ATTORNEY') {
                $_SESSION['attorney'] = [
                    'id' => $admin['user_id'],
                    'username' => $admin['username']
                ];
                $directory = dirname($_SERVER['PHP_SELF']);
                header("Location: $directory/../attorney/dashboard.php");
                exit();
            } else {
                $errors[] = 'You do not have admin privileges';
            }
        } else {
            $errors[] = 'Invalid username or password';
        }
    } catch (PDOException $e) {
        $errors[] = 'Database error: ' . $e->getMessage();
    }

    $_SESSION['errors'] = $errors;
    $directory = dirname($_SERVER['PHP_SELF']);
    header("Location: $directory/attorney-login.php");
    exit();
}
?>
