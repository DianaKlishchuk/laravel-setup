<?php
session_start();

if (isset($_POST["logout"])) {

    $_SESSION = array();

    session_destroy();

    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = $_POST["login"] ?? "";
    $password = $_POST["password"] ?? "";

    if ($login == "admin" && $password == "12345") {

        $_SESSION["user"] = $login;

    } else {
        $error = "Неправильний логін або пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Session</title>
</head>
<body>

<h2>2. Робота з $_SESSION</h2>

<?php

if (isset($_SESSION["user"])) {

    echo "<h3>Вітаємо, " .
         htmlspecialchars($_SESSION["user"]) .
         "!</h3>";

    echo "<p>Ви успішно увійшли в систему.</p>";
    echo '<form method="post">';
    echo '<button type="submit" name="logout">Вихід</button>';
    echo '</form>';

} else {

    if (isset($error)) {
        echo "<p>$error</p>";
    }
?>

    <form method="post">

        <label for="login">Логін:</label>
        <input type="text" id="login" name="login">

        <br><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password">

        <br><br>

        <button type="submit">Увійти</button>

    </form>

<?php
}
?>

</body>
</html>