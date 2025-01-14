<?php

$DEBUG_MODE = false;
include("connect.php");

// Fetch user list and create a dropdown menu
$list = myQuery("SELECT user_id, username FROM user ORDER BY username");
echo "<form action='' method='post'>";
echo "<select name='user_id'>";
foreach ($list as $record) {
    echo "<option value='" . $record['user_id'] . "'>" . $record['username'] . "</option>";
}
echo "</select><br>";
echo "<input type='submit' name='submit' value='Select User to Edit'/>";
echo "</form>";

// Check if a user has been selected for editing
if (isset($_POST['user_id'])) {
    $userID = $_POST['user_id'];

    // Fetch selected user's details
    $result = myQuery("SELECT first_name, last_name, password, username, phone, email FROM user WHERE user_id = $userID");

    // Populate the form with the user's current details
    foreach ($result as $record) {
        $firstName = $record['first_name'];
        $lastName = $record['last_name'];
        $password = $record['password'];
        $username = $record['username'];
        $phone = $record['phone'];
        $email = $record['email'];
    }

    // Form for editing user details
    echo "<form action='update.php' method='post'>";
    echo "<input type='hidden' name='user_id' value='" . $userID . "'>";
    echo "<p>First Name: <input type='text' name='first_name' value='" . $firstName . "'></p>";
    echo "<p>Last Name: <input type='text' name='last_name' value='" . $lastName . "'></p>";
    echo "<p>Password: <input type='password' name='password' value='" . $password . "'></p>";
    echo "<p>Username: <input type='text' name='username' value='" . $username . "'></p>";
    echo "<p>Phone: <input type='text' name='phone' maxlength='12' value='" . $phone . "'></p>";
    echo "<p>Email: <input type='email' name='email' value='" . $email . "'></p>";
    echo "<p><input type='submit' name='submit' value='Update User'></p>";
    echo "</form>";
}
?>
