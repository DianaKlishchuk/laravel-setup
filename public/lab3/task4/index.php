<?php

session_start();

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = array();
}

if (isset($_POST["product"])) {

    $product = $_POST["product"];

    $_SESSION["cart"][] = $product;

    $previous = isset($_COOKIE["previous_purchases"])
        ? $_COOKIE["previous_purchases"]
        : "";

    if ($previous != "") {
        $previous .= "," . $product;
    } else {
        $previous = $product;
    }

    setcookie(
        "previous_purchases",
        $previous,
        time() + 30 * 24 * 60 * 60,
        "/"
    );

    header("Location: index.php");
    exit;
}

if (isset($_POST["clear_cart"])) {
    $_SESSION["cart"] = array();

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
</head>
<body>

<h2>4. Корзина покупок</h2>

<h3>Товари:</h3>

<form method="post">

    <button type="submit" name="product" value="Ноутбук">
        Додати ноутбук
    </button>

    <button type="submit" name="product" value="Мишка">
        Додати мишку
    </button>

    <button type="submit" name="product" value="Клавіатура">
        Додати клавіатуру
    </button>

</form>

<hr>

<h3>Поточна корзина:</h3>

<?php

if (count($_SESSION["cart"]) > 0) {

    echo "<ul>";

    foreach ($_SESSION["cart"] as $product) {
        echo "<li>" . htmlspecialchars($product) . "</li>";
    }

    echo "</ul>";

} else {

    echo "<p>Корзина порожня.</p>";
}

?>

<form method="post">
    <button type="submit" name="clear_cart">
        Очистити корзину
    </button>
</form>

<hr>

<h3>Попередні покупки:</h3>

<?php

if (isset($_COOKIE["previous_purchases"])) {

    $previous = explode(",", $_COOKIE["previous_purchases"]);

    echo "<ul>";

    foreach ($previous as $product) {
        echo "<li>" . htmlspecialchars($product) . "</li>";
    }

    echo "</ul>";

} else {

    echo "<p>Попередніх покупок немає.</p>";
}

?>

</body>
</html>