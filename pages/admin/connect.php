<?php

function myQuery($qry)
{
    $servername = "localhost";
    $username = "db_counselh_usr";
    $password = "CounselHub1100";
    $dbname = "db_counselhub";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = mysqli_query($conn, $qry);

    if (isset($GLOBALS['DEBUG_MODE']) && $GLOBALS['DEBUG_MODE'])
    {
        echo $qry . "<br>";
        echo mysqli_error($conn) . "<hr>";
    }

    mysqli_close($conn);

    return $result;
}
?>
