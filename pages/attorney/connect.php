<?php
// connect.php

function myQuery($qry)
{
    $servername = "localhost";
    $username = "db_counselh_usr";
    $password = "CounselHub1100";
    $dbname = "db_counselhub";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    // Execute query
    $result = mysqli_query($conn, $qry);

    // Debug mode output
    if (isset($GLOBALS['DEBUG_MODE']) && $GLOBALS['DEBUG_MODE'])
    {
        echo $qry . "<br>";
        echo mysqli_error($conn) . "<hr>";
    }

    // Close connection
    mysqli_close($conn);

    return $result;
}
?>
