<?php

header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . '/AccountInterface.php';
require_once __DIR__ . '/BankAccount.php';
require_once __DIR__ . '/SavingsAccount.php';

function out($text)
{
    echo $text . "<br>\n";
}

function run($title, callable $operation)
{
    try {
        $operation();
        out("✔ {$title}");
    } catch (Exception $e) {
        out("✘ {$title} — Помилка: " . $e->getMessage());
    }
}

out("<h3>Звичайний рахунок (BankAccount)</h3>");

try {
    $account = new BankAccount(1000, 'USD');
    out("Створено рахунок: " . $account->getBalance() . " " . $account->getCurrency());
} catch (Exception $e) {
    die("Не вдалося створити рахунок: " . $e->getMessage());
}

run("Поповнення на 500", function () use ($account) {
    $account->deposit(500);
});
out("Баланс: " . $account->getBalance() . " " . $account->getCurrency());

run("Зняття 300", function () use ($account) {
    $account->withdraw(300);
});
out("Баланс: " . $account->getBalance() . " " . $account->getCurrency());

run("Зняття 5000 (більше за баланс)", function () use ($account) {
    $account->withdraw(5000);
});

run("Поповнення на -100 (від'ємна сума)", function () use ($account) {
    $account->deposit(-100);
});

run("Зняття -50 (від'ємна сума)", function () use ($account) {
    $account->withdraw(-50);
});

run("Поповнення на 'abc' (не число)", function () use ($account) {
    $account->deposit('abc');
});

out("Баланс: " . $account->getBalance() . " " . $account->getCurrency());
out("Мінімальний баланс (константа): " . BankAccount::MIN_BALANCE);

out("<hr><h3>Накопичувальний рахунок (SavingsAccount)</h3>");

$savings = new SavingsAccount(2000, 'EUR');
out("Створено рахунок: " . $savings->getBalance() . " " . $savings->getCurrency());
out("Відсоткова ставка: " . SavingsAccount::$interestRate . "%");

run("Нарахування відсотків", function () use ($savings) {
    $savings->applyInterest();
});
out("Баланс після нарахування: " . $savings->getBalance() . " " . $savings->getCurrency());

SavingsAccount::$interestRate = 10;
out("Ставку змінено на " . SavingsAccount::$interestRate . "%");

run("Нарахування відсотків", function () use ($savings) {
    $savings->applyInterest();
});
out("Баланс після нарахування: " . $savings->getBalance() . " " . $savings->getCurrency());

run("Зняття 10000 (недостатньо коштів)", function () use ($savings) {
    $savings->withdraw(10000);
});

out("<hr><h3>Поліморфізм (через AccountInterface)</h3>");

$accounts = [
    new BankAccount(100, 'USD'),
    new SavingsAccount(200, 'UAH'),
];

foreach ($accounts as $acc) {
    run(get_class($acc) . ": поповнення на 50", function () use ($acc) {
        $acc->deposit(50);
    });
    out(get_class($acc) . " — баланс: " . $acc->getBalance() . " " . $acc->getCurrency());
}

out("<hr><h3>Некоректне створення рахунку</h3>");

run("Створення рахунку з від'ємним балансом", function () {
    new BankAccount(-100, 'USD');
});
run("Створення рахунку з порожньою валютою", function () {
    new BankAccount(100, '');
});