<?php
function connectDB() {
    $servername = "localhost";
    $username = "db_counselh_usr";
    $password = "CounselHub1100";
    $dbname = "db_counselhub";

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
$pdo = connectDB();
?>
