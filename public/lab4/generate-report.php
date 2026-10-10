<?php

$cacheDirectory = __DIR__ . '/cache';
$cacheFile = $cacheDirectory . '/report.html';
$cacheLifetime = 600;

$startTime = microtime(true);

if (!is_dir($cacheDirectory)) {
    mkdir($cacheDirectory, 0777, true);
}

$fromCache = file_exists($cacheFile) &&
    (time() - filemtime($cacheFile) < $cacheLifetime);

if ($fromCache) {
    $html = file_get_contents($cacheFile);
    $message = 'Звіт завантажено з файлового кешу.';
} else {
    // Імітація тривалої генерації звіту.
    sleep(3);

    $names = [
        'Анна', 'Олег', 'Марія', 'Іван',
        'Софія', 'Андрій', 'Олена', 'Максим'
    ];

    $rows = '';

    for ($i = 1; $i <= 1000; $i++) {
        $name = $names[array_rand($names)];

        $amount = number_format(
            mt_rand(1000, 150000) / 100,
            2,
            '.',
            ''
        );

        $date = date(
            'Y-m-d',
            mt_rand(strtotime('2024-01-01'), time())
        );

        $rows .= '<tr><td>' . $i . '</td><td>' .
            htmlspecialchars($name, ENT_QUOTES, 'UTF-8') .
            '</td><td>' . $amount .
            '</td><td>' . $date . '</td></tr>' . "\n";
    }

    $html = '<!DOCTYPE html>
<html lang="uk">
<head>
<meta charset="UTF-8">
<title>Звіт із файловим кешуванням</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 24px;
    background: #f5f7fa;
}
table {
    border-collapse: collapse;
    width: 100%;
    background: white;
}
th, td {
    border: 1px solid #ccc;
    padding: 7px;
    text-align: left;
}
th {
    background: #e5edf5;
}
</style>
</head>
<body>
<h1>Звіт: 1000 записів</h1>
<table>
<thead>
<tr>
    <th>№</th>
    <th>Ім’я</th>
    <th>Сума</th>
    <th>Дата</th>
</tr>
</thead>
<tbody>' . $rows . '</tbody>
</table>
</body>
</html>';

    file_put_contents($cacheFile, $html, LOCK_EX);

    $message = 'Звіт згенеровано заново та збережено у cache/report.html.';
}

$elapsed = microtime(true) - $startTime;

header('Content-Type: text/html; charset=UTF-8');

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Результат кешування звіту</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 24px;
            color: #222;
        }

        .status {
            padding: 12px;
            background: #e8f4e5;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>

<div class="status">
    <strong>
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </strong>
    <br>

    Час обробки:
    <?= number_format($elapsed, 4) ?> с
    <br>

    Час життя кешу: 10 хвилин.
</div>

<p>
    <a href="generate-report.php">Оновити звіт</a> |
    <a href="clear-report-cache.php">Очистити кеш звіту</a> |
    <a href="index.html">На головну</a>
</p>

<?php echo $html; ?>

</body>
</html>