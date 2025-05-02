<?php
session_start();
include 'config.php';

$page = $_GET['page'] ?? 'home';  

$page = strtolower(basename($page));

include 'templates/header.php';

$path = "controllers/{$page}.php";
if (file_exists($path)) {
    include $path;
} else {
    echo "<p>404 - Page not found!</p>";
}

include 'templates/footer.php';
?>