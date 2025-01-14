<?php
include("connect.php");

// Fetch users to display in the dropdown
$list = myQuery("SELECT user_id, username FROM user ORDER BY username");

echo "<form action='' method='post'>";
echo "<p>Select a User to Delete:</p>";
echo "<select name='user_id'>";
foreach ($list as $record) {
    echo "<option value='" . $record['user_id'] . "'>" . $record['username'] . "</option>";
}
echo "</select><br>";
echo "<input type='submit' name='selectToDelete' value='Select User to Delete' />";
echo "</form>";

// If a user is selected for deletion
if (isset($_POST['user_id']) && isset($_POST['selectToDelete'])) {
    $user_id = $_POST['user_id'];

    // Fetch user details
    $result = myQuery("SELECT first_name, last_name, username, email, phone FROM user WHERE user_id = $user_id");

    foreach ($result as $record) {
        echo "<h3>User Details</h3>";
        echo "<p>First Name: " . $record['first_name'] . "</p>";
        echo "<p>Last Name: " . $record['last_name'] . "</p>";
        echo "<p>Username: " . $record['username'] . "</p>";
        echo "<p>Email: " . $record['email'] . "</p>";
        echo "<p>Phone: " . $record['phone'] . "</p>";
    }

    // Confirmation form
    echo "<form action='executeDelete.php' method='post'>";
    echo "<input type='hidden' name='user_id' value='$user_id'/>";
    echo "<input type='checkbox' name='confirmDelete' value='yes'> Confirm Deletion<br>";
    echo "<input type='submit' name='submit' value='Delete User'>";
    echo "</form>";
}
?>
