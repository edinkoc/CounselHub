<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit();
}

$admin = $_SESSION['admin'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            padding: 20px;
            max-width: 800px;
            margin: 50px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
        .logout a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
        .logout a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome, Admin!</h1>
        <p>Hello, <?php echo htmlspecialchars($admin['username']); ?>. This is your dashboard.</p>
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
