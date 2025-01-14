<?php

include("connect.php");

if (isset($_POST['submit'])) {
    $userID = $_POST['user_id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $q = "UPDATE user SET 
        first_name = '$firstName',
        last_name = '$lastName',
        password = '$password',
        username = '$username',
        phone = '$phone',
        email = '$email'
        WHERE user_id = $userID";

    $result = myQuery($q);

    if ($result) {
        echo "<p style='color: green;'>User with ID $userID successfully updated!</p>";
    } else {
        echo "<p style='color: red;'>Error updating user: " . $conn->error . "</p>";
    }
}

?>
