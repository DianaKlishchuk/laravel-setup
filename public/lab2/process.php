<?php

// Шлях до папки для завантажених файлів
$uploadDir = "uploads/";

// Перевіряємо, чи файл був переданий
if (!isset($_FILES["file"])) {
    echo "<h3>Файл не вибрано.</h3>";
    echo '<a href="index.html">Повернутися назад</a>';
    exit;
}

// Отримуємо дані про файл
$file = $_FILES["file"];

// Перевіряємо, чи файл успішно завантажений
if (!is_uploaded_file($file["tmp_name"])) {
    echo "<h3>Помилка завантаження файлу.</h3>";
    echo '<a href="index.html">Повернутися назад</a>';
    exit;
}

// Отримуємо ім'я файлу
$fileName = basename($file["name"]);

// Отримуємо розширення файлу
$extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

// Дозволені розширення
$allowedExtensions = ["png", "jpg", "jpeg"];

// Перевіряємо розширення
if (!in_array($extension, $allowedExtensions)) {
    echo "<h3>Помилка: дозволені тільки файли PNG, JPG та JPEG.</h3>";
    echo '<a href="index.html">Повернутися назад</a>';
    exit;
}

// Максимальний розмір файлу — 2 МБ
$maxSize = 2 * 1024 * 1024;

// Перевіряємо розмір
if ($file["size"] > $maxSize) {
    echo "<h3>Помилка: розмір файлу не повинен перевищувати 2 МБ.</h3>";
    echo '<a href="index.html">Повернутися назад</a>';
    exit;
}

// Формуємо повний шлях до файлу
$filePath = $uploadDir . $fileName;

// Перевіряємо, чи файл з таким ім'ям вже існує
if (file_exists($filePath)) {

    // Отримуємо ім'я без розширення
    $nameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);

    // Додаємо унікальний суфікс
    $fileName = $nameWithoutExtension . "_" . time() . "." . $extension;

    // Оновлюємо шлях до файлу
    $filePath = $uploadDir . $fileName;
}

// Переміщуємо файл у папку uploads
if (move_uploaded_file($file["tmp_name"], $filePath)) {

    // Розмір файлу в кілобайтах
    $fileSizeKB = round($file["size"] / 1024, 2);

    echo "<h2>Файл успішно завантажено!</h2>";

    echo "<p><strong>Ім'я файлу:</strong> "
        . htmlspecialchars($fileName)
        . "</p>";

    echo "<p><strong>Тип файлу:</strong> "
        . htmlspecialchars($file["type"])
        . "</p>";

    echo "<p><strong>Розмір:</strong> "
        . $fileSizeKB
        . " КБ</p>";

    echo "<p><a href='" . htmlspecialchars($filePath)
        . "' download>Завантажити файл</a></p>";

} else {

    echo "<h3>Не вдалося зберегти файл.</h3>";
}

echo '<br><a href="index.html">Повернутися на головну</a>';

?>