# concrete5 Client

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

concrete5 Client is a client library that makes it possible and simple to connect to concrete5 sites v6 or newer.

## Basic Usage

**Version 6 legacy sites**
```php
<?php
$adapter = new Version6Adapter();
$client = new Concrete5($adapter);
$connection = $client->connect('/path/to/concrete5');

\Loader::library('...');
```

**Modern concrete5**

```php
<?php
$adapter = new Version8Adapter();
$client = new Concrete5($adapter);
$connection = $client->connect('/path/to/concrete5');

$app = $connection->getApplication();
$app->make('...');
```

## Install

Via Composer

``` bash
$ composer require buttress/c5client
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email korvinszanto@gmail.com instead of using the issue tracker.

## Credits

- [Korvin Szanto][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/buttress/c5client.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/buttress/c5client/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/buttress/c5client.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/buttress/c5client.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/buttress/c5client.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/buttress/c5client
[link-travis]: https://travis-ci.org/buttress/c5client
[link-scrutinizer]: https://scrutinizer-ci.com/g/buttress/c5client/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/buttress/c5client
[link-downloads]: https://packagist.org/packages/buttress/c5client
[link-author]: https://github.com/korvinszanto
[link-contributors]: ../../contributors
