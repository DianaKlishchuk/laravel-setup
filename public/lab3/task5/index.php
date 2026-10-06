<?php

session_start();

$timeout = 5 * 60;

if (isset($_SESSION["last_activity"])) {

    $inactive_time = time() - $_SESSION["last_activity"];

    if ($inactive_time > $timeout) {

        $_SESSION = array();

        session_destroy();

        session_start();

        $_SESSION["message"] =
            "Сесію завершено через 5 хвилин бездіяльності.";
    }
}

$_SESSION["last_activity"] = time();

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Активність сесії</title>
</head>
<body>

<h2>5. Контроль часу активності сесії</h2>

<?php

if (isset($_SESSION["message"])) {

    echo "<p>" . htmlspecialchars($_SESSION["message"]) . "</p>";

    unset($_SESSION["message"]);
}

echo "<p>Сесія активна.</p>";

echo "<p>Час останньої активності: "
    . date("H:i:s", $_SESSION["last_activity"])
    . "</p>";

echo "<p>Сесія автоматично завершиться після "
    . "5 хвилин бездіяльності.</p>";

?>

</body>
</html>