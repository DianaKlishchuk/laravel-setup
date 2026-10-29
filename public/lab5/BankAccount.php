<?php

require_once __DIR__ . '/AccountInterface.php';

class BankAccount implements AccountInterface
{
    const MIN_BALANCE = 0;

    protected $balance;
    protected $currency;
    public function __construct($initialBalance = 0, $currency = 'USD')
    {
        if (!is_numeric($initialBalance)) {
            throw new Exception("Початковий баланс має бути числом.");
        }
        if ($initialBalance < static::MIN_BALANCE) {
            throw new Exception(
                "Початковий баланс не може бути меншим за мінімальний (" . static::MIN_BALANCE . ")."
            );
        }
        if (!is_string($currency) || trim($currency) === '') {
            throw new Exception("Валюта рахунку не може бути порожньою.");
        }

        $this->balance  = (float)$initialBalance;
        $this->currency = strtoupper(trim($currency));
    }

    public function deposit($amount)
    {
        $this->validateAmount($amount, 'поповнення');
        $this->balance += $amount;
    }

    public function withdraw($amount)
    {
        $this->validateAmount($amount, 'зняття');

        if ($this->balance - $amount < static::MIN_BALANCE) {
            throw new Exception("Недостатньо коштів");
        }
        $this->balance -= $amount;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

         protected function validateAmount($amount, $operation)
    {
        if (!is_numeric($amount)) {
            throw new Exception("Сума для операції «{$operation}» має бути числом.");
        }
        if ($amount < 0) {
            throw new Exception("Сума для операції «{$operation}» не може бути від'ємною.");
        }
        if ($amount == 0) {
            throw new Exception("Сума для операції «{$operation}» має бути більшою за нуль.");
        }
    }

    public function __toString()
    {
        return sprintf("%s [%s]: %.2f %s", static::class, spl_object_id($this), $this->balance, $this->currency);
    }
}