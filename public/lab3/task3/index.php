<?php

if ($_SERVER["REQUEST_METHOD"] != "POST") {

    if (!isset($_GET["redirect"])) {
        header("Location: index.php?redirect=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Server</title>
</head>
<body>

<h2>3. Робота з $_SERVER</h2>

<?php

echo "<p><strong>IP-адреса клієнта:</strong> "
    . htmlspecialchars($_SERVER["REMOTE_ADDR"])
    . "</p>";

echo "<p><strong>Браузер:</strong> "
    . htmlspecialchars($_SERVER["HTTP_USER_AGENT"])
    . "</p>";

echo "<p><strong>Назва скрипта:</strong> "
    . htmlspecialchars($_SERVER["PHP_SELF"])
    . "</p>";

echo "<p><strong>Метод запиту:</strong> "
    . htmlspecialchars($_SERVER["REQUEST_METHOD"])
    . "</p>";

echo "<p><strong>Шлях до файлу:</strong> "
    . htmlspecialchars($_SERVER["SCRIPT_FILENAME"])
    . "</p>";

?>

<br>

<form method="post">
    <button type="submit">Надіслати POST-запит</button>
</form>

</body>
</html>