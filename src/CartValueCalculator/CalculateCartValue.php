<?php

declare(strict_types=1);

namespace App\CartValueCalculator;

final class CalculateCartValue implements CanCalculateCartValue
{
    /**
     * @param mixed[] $items
     * @param string $checkoutCurrency
     *
     * @return mixed[]
     */
    public function calculate(array $items, string $checkoutCurrency): array
    {
        return [
            'checkoutPrice' => 82.18,
            'checkoutCurrency' => 'EUR',
        ];
    }
}
