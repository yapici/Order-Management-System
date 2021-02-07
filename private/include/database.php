<?php
$dbServer = Constants::DB_SERVER;
$dbName = Constants::DB_NAME;
$dbUser = Constants::DB_USER;
$dbPass = Constants::DB_PASS;

try {
    $Database = new PDO("mysql:host=$dbServer;dbname=$dbName", $dbUser, $dbPass);
    $Database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>