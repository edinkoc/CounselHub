<?php
require_once 'connect.php';

session_start();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // First Name ve Last Name doğrulama
    if (empty($firstName) || !preg_match('/^[a-zA-Z]+$/', $firstName)) {
        $errors['first_name'] = 'First name must contain only letters.';
    }

    if (empty($lastName) || !preg_match('/^[a-zA-Z]+$/', $lastName)) {
        $errors['last_name'] = 'Last name must contain only letters.';
    }

    // Username doğrulama
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    }

    // Phone doğrulama
    if (empty($phone) || !preg_match('/^\d{10,12}$/', $phone)) {
        $errors['phone'] = 'Phone number must be 10-12 digits.';
    }

    // Email doğrulama
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    } elseif (!preg_match('/@(?:hotmail|gmail|yahoo)\.com$/', $email)) {
        $errors['email'] = 'Email must end with @hotmail.com, @gmail.com, or @yahoo.com.';
    }

    // Password doğrulama
    if (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long.';
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $errors['password'] = 'Password must contain at least one uppercase letter.';
    } elseif (!preg_match('/[a-z]/', $password)) {
        $errors['password'] = 'Password must contain at least one lowercase letter.';
    } elseif (!preg_match('/\d/', $password)) {
        $errors['password'] = 'Password must contain at least one digit.';
    } elseif (!preg_match('/[@$!%*?&#]/', $password)) {
        $errors['password'] = 'Password must contain at least one special character.';
    }

    // Confirm Password doğrulama
    if ($password !== $confirmPassword) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    // Kullanıcı var mı kontrolü
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email OR username = :username");
        $stmt->execute(['email' => $email, 'username' => $username]);
        if ($stmt->fetch()) {
            $errors['user_exist'] = 'Email or username is already registered';
        }
    }

    // Hatalar varsa yönlendirme
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $directory = dirname($_SERVER['PHP_SELF']);
        header("Location: $directory/register.php");
        exit();
    }

    // Kullanıcıyı ekle
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("
            INSERT INTO user (first_name, last_name, password, username, phone, email)
            VALUES (:first_name, :last_name, :password, :username, :phone, :email)
        ");
        $stmt->execute([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'password' => $hashedPassword,
            'username' => $username,
            'phone' => $phone,
            'email' => $email,
        ]);

        $userId = $pdo->lastInsertId();

        $stmt = $pdo->prepare("
            INSERT INTO user_roles (user_user_id, roles_id)
            VALUES (:user_id, :role_id)
        ");
        $stmt->execute([
            'user_id' => $userId,
            'role_id' => 2
        ]);

        $directory = dirname($_SERVER['PHP_SELF']);
        header("Location: $directory/index.php");
        exit();
    } catch (PDOException $e) {
        $errors['database'] = 'Failed to register user. Please try again later.';
        $_SESSION['errors'] = $errors;
        $directory = dirname($_SERVER['PHP_SELF']);
        header("Location: $directory/register.php");
        exit();
    }
}

