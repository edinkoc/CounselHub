<?php
session_start();

session_unset(); 
session_destroy(); 

$directory = dirname($_SERVER['PHP_SELF']);
header("Location: $directory/index.php");
exit();
?>
