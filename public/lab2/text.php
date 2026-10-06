<?php

// Назва файлу для запису тексту
$fileName = "log.txt";

// Перевіряємо, чи був переданий текст
if (isset($_POST["text"])) {

    // Отримуємо текст
    $text = trim($_POST["text"]);

    // Перевіряємо, чи текст не порожній
    if ($text != "") {

        // Записуємо текст у файл
        file_put_contents($fileName, $text . PHP_EOL, FILE_APPEND);

        echo "<h3>Текст успішно записано у файл.</h3>";

    } else {

        echo "<h3>Ви не ввели текст.</h3>";
    }
}

// Перевіряємо, чи існує файл
if (file_exists($fileName)) {

    // Читаємо дані з файлу
    $content = file_get_contents($fileName);

    echo "<h2>Вміст файлу log.txt:</h2>";

    echo "<pre>"
        . htmlspecialchars($content)
        . "</pre>";

} else {

    echo "<p>Файл log.txt ще не створений.</p>";
}

?>

<br>

<a href="index.html">Повернутися на головну</a>