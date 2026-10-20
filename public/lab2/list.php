<?php

$uploadDir = "uploads/";
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

if (count($files) > 2) {

    echo "<ul>";

    foreach ($files as $file) {

        if ($file == "." || $file == "..") {
            continue;
        }

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