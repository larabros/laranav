# laranav

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

An easy-to-use, customisable menu and navigation package for Laravel.

Why is this different from every other menu package?

- Define your menus in a simple config file
- Use regular ol' Blade templates for rendering menus - never build HTML programatically again!
- Fully-tested

## Install

Via Composer

``` bash
$ composer require hassankhan/laranav
```

## Usage

First, open `config/laranav/config.php` and add any menus you would like to add.
If you want to change any options from the defaults, then you can do that for
individual menus.

After setting the options, open `config/laranav/menus.php` and add any items for the menus here.

Now, in your template, add `{!! Nav::menu('default')->toHtml() !!}` and you should have a menu!

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email contact@hassankhan.me instead of using the issue tracker.

## Credits

- [Hassan Khan][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/hassankhan/laranav.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/hassankhan/laranav/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/hassankhan/laranav.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/hassankhan/laranav.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/hassankhan/laranav.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/hassankhan/laranav
[link-travis]: https://travis-ci.org/hassankhan/laranav
[link-scrutinizer]: https://scrutinizer-ci.com/g/hassankhan/laranav/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/hassankhan/laranav
[link-downloads]: https://packagist.org/packages/hassankhan/laranav
[link-author]: https://github.com/hassankhan
[link-contributors]: ../../contributors
