<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site_title ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <h1><?= $site_title ?></h1>
        </div>

        <nav class="navbar">
            <ul>
                <?php foreach ($menu as $key => $name): ?>
                    <?php
                        if ($key == 'login' && isset($_SESSION['user'])) continue;
                        if ($key == 'logout' && !isset($_SESSION['user'])) continue;
                    ?>
                    <li><a href="index.php?page=<?= $key ?>"><?= $name ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <?php if (isset($_SESSION['user'])): ?>
            <div class="user-info">
                <p>Logged-in: <?= htmlspecialchars($_SESSION['user']['full_name']) ?> (<?= $_SESSION['user']['username'] ?>)</p>
            </div>
        <?php endif; ?>
    </header>
    
    <main>