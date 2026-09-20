<?php

echo "<h2>Обробка форми</h2>";

// перевіряємо, чи дані були передані методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // отримуємо ім'я, прізвище з форми
    $name = $_POST["name"] ?? "";
    $surname = $_POST["surname"] ?? "";

    // перевіряємо, чи отртмані значення є рядками
    if (!is_string($name) || !is_string($surname)) {
        echo "Помилка: дані повинні бути текстовими.";
        exit;
    }

    // видаляємо зайві пробіли
    $name = trim($name);
    $surname = trim($surname);

    // перевіряємо, чи поля не порожні
    if ($name == "" || $surname == "") {
        echo "Помилка: заповніть ім'я та прізвище.";
    } else {
        echo "Привіт, " . htmlspecialchars($name) . " "
            . htmlspecialchars($surname) . "!";
    }

} else {
    echo "Дані форми не отримані.";
}

?>