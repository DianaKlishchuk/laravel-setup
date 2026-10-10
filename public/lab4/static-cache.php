<?php

require_once __DIR__ . '/ProductCache.php';

$startTime = microtime(true);

$firstResult = ProductCache::getProducts();

$secondResult = ProductCache::getProducts();

$elapsed = microtime(true) - $startTime;

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Статичний кеш PHP</title>

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

<h1>Кешування статичною властивістю класу</h1>

<div class="status">

    Перший виклик:
    <?= $firstResult['fromCache']
        ? 'дані взято з кешу'
        : 'дані сформовано заново' ?>

    <br>

    Другий виклик:
    <?= $secondResult['fromCache']
        ? 'дані взято з кешу'
        : 'дані сформовано заново' ?>

    <br>

    Загальний час двох викликів:
    <?= number_format($elapsed, 4) ?> с

</div>

<p>
    Перший виклик займає приблизно 2 секунди,
    а другий повертає дані зі статичної властивості.
</p>

<table>
    <thead>
        <tr>
            <th>Товар</th>
            <th>Ціна, грн</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($secondResult['data'] as $product): ?>
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
    <a href="static-cache.php">Повторити запит</a>
</p>

<p>
    <a href="index.html">На головну</a>
</p>

</body>
</html>