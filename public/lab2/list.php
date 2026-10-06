<?php

// Директорія із завантаженими файлами
$uploadDir = "uploads/";

// Отримуємо список файлів
$files = scandir($uploadDir);

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Список файлів</title>
</head>
<body>

<h2>Список завантажених файлів</h2>

<?php

// Перевіряємо список файлів
if (count($files) > 2) {

    echo "<ul>";

    foreach ($files as $file) {

        // Пропускаємо службові елементи
        if ($file == "." || $file == "..") {
            continue;
        }

        // Виводимо файл як посилання
        echo "<li>";
        echo '<a href="' . $uploadDir
            . rawurlencode($file)
            . '" download>'
            . htmlspecialchars($file)
            . '</a>';
        echo "</li>";
    }

    echo "</ul>";

} else {

    echo "<p>У папці uploads немає файлів.</p>";
}

?>

<br>

<a href="index.html">Повернутися на головну</a>

</body>
</html>