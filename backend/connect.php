<?php
function myQuery($qry) {
$servername = "localhost";
$username = "db_counselh_usr";
$password = "CounselHub1100";
$dbname = "db_counselhub";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
//echo "connection established...<hr>";
$result = mysqli_query($conn, $qry);
mysqli_close($conn);
return $result;
}
?>
