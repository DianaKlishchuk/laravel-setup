<?php

$uploadDir = "uploads/";

if (!isset($_FILES["file"])) {
    echo "<h3>Файл не вибрано.</h3>";
    echo '<a href="index.html">Повернутися назад</a>';
    exit;
}

$file = $_FILES["file"];

if (!is_uploaded_file($file["tmp_name"])) {
    echo "<h3>Помилка завантаження файлу.</h3>";
    echo '<a href="index.html">Повернутися назад</a>';
    exit;
}

$fileName = basename($file["name"]);

$extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

$allowedExtensions = ["png", "jpg", "jpeg"];

if (!in_array($extension, $allowedExtensions)) {
    echo "<h3>Помилка: дозволені тільки файли PNG, JPG та JPEG.</h3>";
    echo '<a href="index.html">Повернутися назад</a>';
    exit;
}

$maxSize = 2 * 1024 * 1024;

if ($file["size"] > $maxSize) {
    echo "<h3>Помилка: розмір файлу не повинен перевищувати 2 МБ.</h3>";
    echo '<a href="index.html">Повернутися назад</a>';
    exit;
}

$filePath = $uploadDir . $fileName;

if (file_exists($filePath)) {

    $nameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);

    $fileName = $nameWithoutExtension . "_" . time() . "." . $extension;

    $filePath = $uploadDir . $fileName;
}

if (move_uploaded_file($file["tmp_name"], $filePath)) {

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