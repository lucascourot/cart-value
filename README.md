# Usage

## Dev env

> make start # Starts the api built-in server

> make test-ci # Runs all kind of tests

## Prod

# Rules

## Context

An online marketplace is looking for a new partner to handle the calculation of the cart value of its visitors.
Given the items in cart, and their price with the reseller currency, we must return the total price of the cart,
in the currency chosen by the visitor. The prices of the various items in the cart might be expressed 
in different currencies.

## Goal
Provide an endpoint that will consume the  Fixer.io API  to calculate the cart value at current exchange rates,
rounded to 2 decimal places. Must be written in PHP, spend no more than 4 hours on it.
Fixer.io API access key:  abe927438de20bbdb102c14b2d61f8aa

## Example of received payload (POST)
```json
{
  "items": {
    "42": {
      "currency": "EUR",
      "price": 49.99,
      "quantity": 1
    },
    "55": {
      "currency": "USD",
      "price": 12,
      "quantity": 3
    }
  },
  "checkoutCurrency": "EUR"
}
```

## Expected response
The response should be JSON encoded, and contain at least the following keys:
```json
{
  "checkoutPrice": 82.18,
  "checkoutCurrency": "EUR"
}
```
