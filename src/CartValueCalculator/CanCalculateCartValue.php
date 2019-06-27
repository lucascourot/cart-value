<?php

declare(strict_types=1);

namespace App\CartValueCalculator;

use Money\Money;

interface CanCalculateCartValue
{
    /**
     * @param mixed[] $items
     */
    public function calculate(array $items, string $checkoutCurrency) : Money;
}
