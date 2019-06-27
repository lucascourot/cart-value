<?php

declare(strict_types=1);

namespace App\CartValueCalculator;

use Money\Currency;
use Money\Money;

interface CurrencyConverter
{
    public function convert(Money $money, Currency $currency) : Money;
}
