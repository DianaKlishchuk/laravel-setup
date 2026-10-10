<?php

session_start();

unset(
    $_SESSION['products_cache'],
    $_SESSION['products_cache_time']
);

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Очищення кешу сесії</title>
</head>
<body>

<p>Кеш товарів у поточній PHP-сесії очищено.</p>

<p>
    <a href="session-cache.php">Заново сформувати дані</a>
</p>

<p>
    <a href="index.html">На головну</a>
</p>

</body>
</html>