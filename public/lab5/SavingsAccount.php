<?php

require_once __DIR__ . '/BankAccount.php';

class SavingsAccount extends BankAccount
{
    public static $interestRate = 5;
    public function applyInterest()
    {
        if (!is_numeric(self::$interestRate) || self::$interestRate < 0) {
            throw new Exception("Відсоткова ставка некоректна.");
        }

        $interest = $this->balance * self::$interestRate / 100;
        $this->balance += $interest;

        return $interest;
    }
}