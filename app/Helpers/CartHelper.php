<?php

namespace App\Helpers;

class CartHelper
{
    public static function cart()
    {
        return session('cart', []);
    }

    public static function count()
    {
        return collect(self::cart())->sum('quantity');
    }

    public static function total()
    {
        return collect(self::cart())->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public static function hasItems()
    {
        return count(self::cart()) > 0;
    }
}
