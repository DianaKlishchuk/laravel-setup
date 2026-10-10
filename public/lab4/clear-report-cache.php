<?php

$cacheFile = __DIR__ . '/cache/report.html';

if (file_exists($cacheFile)) {
    unlink($cacheFile);
    $message = 'Файловий кеш звіту очищено.';
} else {
    $message = 'Файл кешу вже відсутній.';
}

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Очищення кешу</title>
</head>
<body>

<p>
    <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    Наступний запит згенерує новий звіт.
</p>

<p>
    <a href="generate-report.php">Запустити генерацію звіту</a>
</p>

<p>
    <a href="index.html">На головну</a>
</p>

</body>
</html>