<?php

declare(strict_types=1);

namespace App\Controller;

use App\CartValueCalculator\CanCalculateCartValue;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use function is_array;
use function json_decode;

class CalculateCartValueController
{
    public function calculate(Request $request, CanCalculateCartValue $calculateCartValue) : JsonResponse
    {
        $requestJson = json_decode((string) $request->getContent(), true);

        if (! is_array($requestJson)) {
            throw new InvalidArgumentException('Invalid json.');
        }

        $checkoutPrice = $calculateCartValue->calculate($requestJson['items'], $requestJson['checkoutCurrency']);

        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return new JsonResponse([
            'checkoutPrice' => (float) $moneyFormatter->format($checkoutPrice),
            'checkoutCurrency' => $checkoutPrice->getCurrency(),
        ]);
    }
}
