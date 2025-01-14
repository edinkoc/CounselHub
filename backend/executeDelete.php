<?php

include("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userID = $_POST['user_id'];
    $confirmDelete = $_POST['confirmDelete'];

    if ($confirmDelete === 'yes' && !empty($userID)) {
        // Use prepared statements for security
        $stmt = $conn->prepare("DELETE FROM user WHERE user_id = ?");
        $stmt->bind_param("i", $userID);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>User successfully deleted.</p>";
        } else {
            echo "<p style='color: red;'>Error deleting user: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='color: red;'>Deletion not confirmed or invalid user ID. No changes were made.</p>";
    }
} else {
    echo "<p style='color: red;'>Invalid request method.</p>";
}
?>
<a href='delete.php'>Back to User Deletion</a>
