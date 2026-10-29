<?php
session_start();
require_once __DIR__ . '/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: welcome.php');
    exit;
}

$errors   = [];
$username = '';
$email    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!preg_match('/^[A-Za-z0-9_]{3,50}$/', $username)) {
        $errors[] = "Ім'я користувача: 3–50 символів (латиниця, цифри, підкреслення).";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
        $errors[] = 'Некоректна електронна пошта.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Пароль має містити щонайменше 6 символів.';
    }

    if (!$errors) {
        try {
            $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
            $hash = hash_user_password($password);
            $stmt->bind_param('sss', $username, $email, $hash);
            $stmt->execute();
            $stmt->close();

            header('Location: login.php?registered=1');
            exit;
        } catch (mysqli_sql_exception $ex) {
            if ($ex->getCode() === 1062) { 
                $errors[] = "Користувач із таким ім'ям або email вже існує.";
            } else {
                $errors[] = 'Помилка бази даних. Спробуйте пізніше.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Реєстрація</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="box">
    <h2>Реєстрація</h2>

    <?php if ($errors): ?>
        <div class="error">
            <?php foreach ($errors as $err): ?>
                <p><?= e($err) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <label for="username">Ім'я користувача</label>
        <input type="text" id="username" name="username" value="<?= e($username) ?>" required>

        <label for="email">Електронна пошта</label>
        <input type="email" id="email" name="email" value="<?= e($email) ?>" required>

        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Зареєструватися</button>
    </form>

    <div class="link">Вже є акаунт? <a href="login.php">Увійти</a></div>
</div>
</body>
</html>