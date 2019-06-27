<?php

declare(strict_types=1);

namespace App\CartValueCalculator;

interface CanCalculateCartValue
{
    /**
     * @param mixed[] $items
     * @param string $checkoutCurrency
     *
     * @return mixed[]
     */
    public function calculate(array $items, string $checkoutCurrency) : array;
}
