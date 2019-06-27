<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @group ui
 */
class CalculateCartValueTest extends KernelTestCase
{
    /** @var HttpClientInterface */
    private $client;

    protected function setUp() : void
    {
        $kernel = self::bootKernel();
        /** @var ContainerInterface $container */
        $container = $kernel->getContainer();
        $this->client = HttpClient::create([
            'base_uri' => $container->getParameter('api_base_uri'),
            'headers' => ['Accept' => 'application/ld+json'],
        ]);
    }

    public function testShouldCalculateCartValueForFixedUSDRate() : void
    {
        // Given
        // USD / EUR rate is at 1.1183 @see FixedCurrencyConverter

        // When
        $response = $this->client->request('POST', '/calculations', [
            'json' => [
                'items' => [
                    '42' => [
                        'currency' => 'EUR',
                        'price' => 49.99,
                        'quantity' => 1,
                    ],
                    '55' => [
                        'currency' => 'USD',
                        'price' => 12,
                        'quantity' => 3,
                    ],
                ],
                'checkoutCurrency' => 'EUR',
            ],
        ]);

        // Then
        self::assertSame(82.18, $response->toArray()['checkoutPrice']);
        self::assertSame('EUR', $response->toArray()['checkoutCurrency']);
    }
}
