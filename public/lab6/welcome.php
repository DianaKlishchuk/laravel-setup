<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="box">
    <h2>Вітаємо, <?= e($_SESSION['username']) ?>!</h2>
    <p>Ви успішно авторизувалися. Ця сторінка доступна лише після входу.</p>
    <a class="logout" href="logout.php">Вийти</a>
</div>
</body>
</html>