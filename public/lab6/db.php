<?php

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'users_db';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    die('Не вдалося підключитися до бази даних. Перевірте налаштування у db.php.');
}

function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function hash_user_password($password)
{
    return password_hash(md5($password), PASSWORD_DEFAULT);
}

function check_user_password($password, $storedHash)
{
    return password_verify(md5($password), $storedHash);
}