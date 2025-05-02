<?php
$host = 'localhost'; 
$dbname = 'databaselesson'; 
$username = 'root'; 
$password = ''; 

try {
    
    $dbh = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>