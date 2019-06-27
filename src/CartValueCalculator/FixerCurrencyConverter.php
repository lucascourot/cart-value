<?php

declare(strict_types=1);

namespace App\CartValueCalculator;

use Money\Converter;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Exchange\ReversedCurrenciesExchange;
use Money\Exchange\SwapExchange;
use Money\Money;
use Swap\Builder;

final class FixerCurrencyConverter implements CurrencyConverter
{
    /** @var string */
    private $fixerApiKey;

    public function __construct(string $fixerApiKey)
    {
        $this->fixerApiKey = $fixerApiKey;
    }

    public function convert(Money $money, Currency $currency) : Money
    {
        $swap = (new Builder())
            ->add('fixer', ['access_key' => $this->fixerApiKey])
            ->build();
        $swapExchange = new SwapExchange($swap);

        $exchange = new ReversedCurrenciesExchange($swapExchange);

        $converter = new Converter(new ISOCurrencies(), $exchange);

        return $converter->convert($money, $currency);
    }
}
