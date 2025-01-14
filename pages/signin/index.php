<?php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    
    // Sanitize user inputs
    $identifier = filter_input(INPUT_POST, 'identifier', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = $_POST['password'];

    $errors = [];

    // Validate inputs
    if (empty($identifier)) {
        $errors[] = 'Username or Email is required.';
    }

    if (empty($password)) {
        $errors[] = 'Password is required.';
    }

    // If validation fails, redirect back with errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: index.php");
        exit();
    }

    try {
        // Fetch user by username or email
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = :identifier OR email = :identifier");
        $stmt->execute(['identifier' => $identifier]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Fetch all roles associated with the user
            $stmt = $pdo->prepare("
                SELECT r.role
                FROM user_roles ur
                JOIN user_role r ON ur.roles_id = r.id
                WHERE ur.user_user_id = :user_id
            ");
            $stmt->execute(['user_id' => $user['user_id']]);
            $roles = $stmt->fetchAll(PDO::FETCH_COLUMN);


            // Check and assign roles
            if (in_array('ROLE_ADMIN', $roles)) {
                $_SESSION['role'] = 'ROLE_ADMIN';
                $_SESSION['user_id'] = $user['user_id'];
                session_regenerate_id(true);
                $directory = dirname($_SERVER['PHP_SELF']);
        header("Location: $directory/../admin/dashboard.php");
                exit();
            } elseif (in_array('ROLE_CUSTOMER', $roles)) {
                $_SESSION['customer'] = $user;
                $_SESSION['user_id'] = $user['user_id'];
                session_regenerate_id(true);
                $directory = dirname($_SERVER['PHP_SELF']);
        header("Location: $directory/../customer/HomePage.php");
                exit();
            } elseif (in_array('ROLE_ATTORNEY', $roles)) {
                // Execute original query to fetch attorney profile
                $stmt = $pdo->prepare("
                    SELECT * FROM user AS u
                    JOIN user_roles AS ur ON u.user_id = ur.user_user_id
                    JOIN user_role AS r ON ur.roles_id = r.id
                    WHERE r.role = 'ROLE_ATTORNEY' AND u.user_id = :user_id
                ");
                $stmt->execute(['user_id' => $user['user_id']]);
                $attorney = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($attorney) {
                    $_SESSION['attorney'] = $attorney;
                    $_SESSION['user_id'] = $user['user_id'];
                    session_regenerate_id(true);
                    $directory = dirname($_SERVER['PHP_SELF']);
        header("Location: $directory/../attorney/dashboard.php");
                    exit();
                } else {
                    $errors[] = 'Attorney profile not found.';
                }
            } else {
                $errors[] = 'Role not assigned.';
            }
        } else {
            $errors[] = 'Invalid username/email or password.';
        }
    } catch (PDOException $e) {
        // Log the error message to a file
        error_log("Database error: " . $e->getMessage());
        $errors[] = 'An unexpected error occurred. Please try again later.';
    }

    // Redirect back with errors if any
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $directory = dirname($_SERVER['PHP_SELF']);
    header("Location: $directory/index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: white;
        }

        .container {
            background: #fff;
            width: 450px;
            padding: 1.5rem;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 1px 2px 8px rgba(0, 0, 0, 0.6);
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            padding: 1.3rem;
            margin-bottom: 0.4rem;
        }

        input {
            flex: 10;
            color: inherit;
            width: 100%;
            background-color: transparent;
            border: none;
            font-size: 15px;
            padding: 0 0.4em;
            border-left: solid 1px hsla(0, 0%, 0%, 0.4);
        }

        input:focus {
            border-left: solid 1px hsla(240, 73%, 71%, 1);
            outline: none;
        }

        .input-group {
            padding: 1% 0;
            position: relative;
            background-color: hsla(227, 63%, 18%, 0.07);
            margin: 1em auto;
            border-radius: 12px;
            display: flex;
            padding: 0.7em 0.1em;
        }

        .input-group:focus-within {
            border: 1.5px solid rgb(125, 125, 235);
        }

        .input-group i {
            flex: 1;
            color: black;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .input-group:focus-within i {
            color: rgb(125, 125, 235);
        }

        .input-group.password i:first-child {
            flex: 1.1;
        }

        .recover {
            text-align: right;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .recover a {
            text-decoration: none;
            color: rgb(125, 125, 235);
        }

        .recover a:hover {
            color: blue;
            text-decoration: underline;
        }

        .btn {
            font-size: 1.1rem;
            padding: 0.6em 0;
            border-radius: 10px;
            outline: none;
            border: none;
            width: 100%;
            background: rgb(125, 125, 235);
            color: black;
            cursor: pointer;
            transition: 0.9s;
            margin-top: 0.4em;
            font-weight: 600;
        }

        .btn:hover {
            background: #07001f;
            color: white;
        }

        .links {
            display: flex;
            justify-content: space-around;
            padding: 0 4rem;
            margin-top: 0.9rem;
            font-weight: bold;
        }

        .links a {
            text-decoration: none;
            color: rgb(125, 125, 235);
        }

        .links a:hover {
            text-decoration: underline;
            color: blue;
        }

        .error-messages {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
            text-align: center;
        }

        .error-messages p {
            margin: 0;
            line-height: 1.5;
        }

        @media screen and (max-width: 767px) {
            .container {
                box-shadow: unset;
                width: 90%;
            }
        }
    </style>
<body>
    <div class="container">
        <h1 class="form-title">Sign In</h1>

        <?php
        session_start();
        if (isset($_SESSION['errors'])) {
            echo '<div class="error-messages">';
            foreach ($_SESSION['errors'] as $error) {
                echo '<p class="error">' . htmlspecialchars($error) . '</p>';
            }
            echo '</div>';
            unset($_SESSION['errors']);
        }
        ?>

        <form method="POST" action="index.php">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="identifier" id="identifier" placeholder="Username or Email" required>
            </div>
            <div class="input-group password">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i id="eye" class="fa fa-eye"></i>
            </div>
            <input type="submit" class="btn" value="Sign In" name="login">
        </form>
        <div class="links">
            <p>Don't have an account yet?</p>
            <a href="register.php">Sign Up</a>
        </div>
        <script src="script.js"></script>
    </div>
</body>
</html>
