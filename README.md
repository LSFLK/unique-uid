# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lsflk/unique-uid.svg?style=flat-square)](https://packagist.org/packages/lsflk/unique-uid)
[![Build Status](https://img.shields.io/travis/lsflk/unique-uid/master.svg?style=flat-square)](https://travis-ci.org/lsflk/unique-uid)
[![Quality Score](https://img.shields.io/scrutinizer/g/lsflk/unique-uid.svg?style=flat-square)](https://scrutinizer-ci.com/g/lsflk/unique-uid)
[![Total Downloads](https://img.shields.io/packagist/dt/lsflk/unique-uid.svg?style=flat-square)](https://packagist.org/packages/lsflk/unique-uid)

To generate a Unique UID with given charactor set.You can increase the size of the digits. Even thougt I adivce you to test you self before implement this packge.We have tested over continues 

## Installation

You can install the package via composer:

```bash
composer require lsflk/unique-uid
```

## Usage

``` php
// Unique Id with 9 digits lenght and splited in to three segments
UniqueUid::getUniqueAlphanumeric(9,3)

// To check a valid ID
UniqueUid::isValidUniqeId('YMG-RYC-XF7');
//this will return a boolen value
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email nizarucsc@gmail.com instead of using the issue tracker.

## Credits

- [Mohamed Nizar](https://github.com/lsflk)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com).