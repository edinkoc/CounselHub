<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
</head>
<body>
    <div class="container" id="admin-login">
        <h1 class="form-title">Admin Login</h1>

        <?php
        if (isset($_SESSION['errors'])) {
            echo '<div class="error-messages">';
            foreach ($_SESSION['errors'] as $error) {
                echo '<p class="error">' . htmlspecialchars($error) . '</p>';
            }
            echo '</div>';
            unset($_SESSION['errors']);
        }
        ?>

        <form method="POST" action="admin-authenticate.php">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" id="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <input type="submit" class="btn" value="Login" name="login">
        </form>
    </div>
</body>
</html>
