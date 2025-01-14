<?php

$DEBUG_MODE = false;

require("connect.php");

if (isset($_POST['submit'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // SQL query
    $q = "INSERT INTO user (first_name, last_name, password, username, phone, email) VALUES (
        '$firstName',
        '$lastName',
        '$password',
        '$username',
        '$phone',
        '$email'
    )";

    if ($DEBUG_MODE) {
        echo $q;
    }

    // Execute query and handle success or error
    if (myQuery($q)) {
        echo "<p style='color: green;'>User successfully added to the database!</p>";
    } else {
        echo "<p style='color: red;'>Error: Could not insert data into the database.</p>";
    }
} else {
    // Display the form
    echo "<form action='insert.php' method='post'>";
    echo "<p>First Name: <input type='text' name='first_name'></p>";
    echo "<p>Last Name: <input type='text' name='last_name'></p>";
    echo "<p>Password: <input type='password' name='password'></p>";
    echo "<p>Username: <input type='text' name='username'></p>";
    echo "<p>Phone: <input type='text' name='phone' maxlength='12'></p>";
    echo "<p>Email: <input type='email' name='email'></p>";
    echo "<p><input type='submit' name='submit' value='Insert New User'></p>";
    echo "</form>";
}

?>
