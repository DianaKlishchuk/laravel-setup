<?php
session_start();
require_once __DIR__ . '/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: welcome.php');
    exit;
}

$error    = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Введіть ім'я користувача та пароль.";
    } else {
        $stmt = $conn->prepare('SELECT id, username, password FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($user && check_user_password($password, $user['password'])) {
            session_regenerate_id(true); // захист від фіксації сесії
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];

            header('Location: welcome.php');
            exit;
        }
        $error = "Невірне ім'я користувача або пароль.";
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Авторизація</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="box">
    <h2>Авторизація</h2>

    <?php if (isset($_GET['registered'])): ?>
        <div class="success">Реєстрація успішна! Тепер увійдіть.</div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label for="username">Ім'я користувача</label>
        <input type="text" id="username" name="username" value="<?= e($username) ?>" required>

        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Увійти</button>
    </form>

    <div class="link">Немає акаунта? <a href="register.php">Зареєструватися</a></div>
</div>
</body>
</html>