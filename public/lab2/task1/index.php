<?php

if (isset($_POST["delete_cookie"])) {
    setcookie("username", "", time() - 3600, "/");

    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"])) {

    $username = trim($_POST["username"]);

    if ($username != "") {

        setcookie("username", $username, time() + 7 * 24 * 60 * 60, "/");

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Cookie</title>
</head>
<body>

<h2>1. Робота з $_COOKIE</h2>

<?php
if (isset($_COOKIE["username"])) {
    echo "<h3>Вітаємо, " . htmlspecialchars($_COOKIE["username"]) . "!</h3>";

    echo "<p>Ваше ім'я збережене в cookie на 7 днів.</p>";
    echo '<form method="post">';
    echo '<button type="submit" name="delete_cookie">Видалити cookie</button>';
    echo '</form>';

} else {
?>

    <form method="post">

        <label for="username">Введіть ваше ім'я:</label>
        <input type="text" id="username" name="username">

        <button type="submit">Зберегти ім'я</button>

    </form>

<?php
}
?>

</body>
</html>