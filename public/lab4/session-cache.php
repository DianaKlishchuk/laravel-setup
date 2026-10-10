<?php

session_start();

$startTime = microtime(true);

$cacheKey = 'products_cache';
$cacheLifetime = 600;

if (
    isset($_SESSION[$cacheKey], $_SESSION[$cacheKey . '_time']) &&
    time() - $_SESSION[$cacheKey . '_time'] < $cacheLifetime
) {
    $products = $_SESSION[$cacheKey];

    $message = 'Дані отримано з кешу PHP-сесії.';
} else {
    sleep(2);

    $products = [
        ['name' => 'Ноутбук', 'price' => 25999],
        ['name' => 'Навушники', 'price' => 1899],
        ['name' => 'Клавіатура', 'price' => 1299],
        ['name' => 'Миша', 'price' => 799],
        ['name' => 'Монітор', 'price' => 8499]
    ];

    $_SESSION[$cacheKey] = $products;
    $_SESSION[$cacheKey . '_time'] = time();

    $message = 'Дані сформовано із затримкою та збережено в сесії.';
}

$elapsed = microtime(true) - $startTime;

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Кешування у сесії</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 24px;
        }

        .status {
            padding: 12px;
            background: #e8f4e5;
            margin-bottom: 16px;
        }

        table {
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px 12px;
        }
    </style>
</head>
<body>

<h1>Кешування даних у PHP-сесії</h1>

<div class="status">
    <strong>
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </strong>
    <br>

    Час обробки:
    <?= number_format($elapsed, 4) ?> с
</div>

<table>
    <thead>
        <tr>
            <th>Товар</th>
            <th>Ціна, грн</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td>
                    <?= htmlspecialchars(
                        $product['name'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= number_format($product['price'], 2, '.', ' ') ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p>
    <a href="session-cache.php">Повторити запит</a>
</p>

<p>
    <a href="clear-session-cache.php">Очистити кеш сесії</a>
</p>

<p>
    <a href="index.html">На головну</a>
</p>

</body>
</html>