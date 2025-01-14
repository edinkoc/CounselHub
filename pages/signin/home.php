<?php
session_start();
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="user-details">
        <h1>Welcome, <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>!</h1>
        <p><strong>Your Details:</strong></p>
        <?php
        echo '<p><strong>Email:</strong> ' . htmlspecialchars($user['email']) . '</p>';
        echo '<p><strong>Username:</strong> ' . htmlspecialchars($user['username']) . '</p>';
        echo '<p><strong>Phone:</strong> ' . htmlspecialchars($user['phone']) . '</p>';
        ?>
        <a href="logout.php" class="btn">Logout</a>
    </div>
</body>

</html>
