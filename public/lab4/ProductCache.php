<?php

class ProductCache
{
    private static $cache = [];

    public static function getProducts()
    {
        // Якщо дані вже є в кеші, повертаємо їх.
        if (isset(self::$cache['products'])) {
            return [
                'data' => self::$cache['products'],
                'fromCache' => true
            ];
        }

        // Імітація повільного обчислення даних.
        sleep(2);

        $products = [
            ['name' => 'Ноутбук', 'price' => 25999],
            ['name' => 'Навушники', 'price' => 1899],
            ['name' => 'Клавіатура', 'price' => 1299],
            ['name' => 'Миша', 'price' => 799],
            ['name' => 'Монітор', 'price' => 8499]
        ];

        // Зберігаємо результат у статичній властивості.
        self::$cache['products'] = $products;

        return [
            'data' => $products,
            'fromCache' => false
        ];
    }
}

?>