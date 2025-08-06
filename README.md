# Dat PHP Client

PHP client library for the Dat debugging application.

## Installation

```bash
composer require dat/php-client
```

## Usage

```php
use Dat\Client\Dat;

$dat = new Dat();
$dat->log('Debug message');
```

## Development

- Clone the repository
- Run `composer install`
- Run tests with `composer test`