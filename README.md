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

Then add the service provider to the `providers` array in `config/app.php`:

``` php
'providers' => [

        ...
        Laranav\LaranavServiceProvider::class,

],

```

Optionally, you can also add a `Nav` facade by adding it to the `aliases` array in `config/app.php`:

```php
'aliases' => [

    ...
    'Nav' => Laranav\Facades\Nav::class,

],
```

After registering the service provider, run `php artisan vendor:publish` to publish Laranav's config files and example template files to your project.

## Usage

First, open `config/laranav/config.php` and add any menus you would like to add. If you want to change any options from the defaults, then you can do that for individual menus.

After setting the options, open `config/laranav/menus.php` and add any items for the menus here.

Finally, in your template, add `{!! Nav::menu('default')->toHtml() !!}` and your menu should render!

## Configuration

Laranav publishes **two** files to your `config/laranav`: `config.php` and `menus.php`. An example menu named `default` is provided which can be overwritten.

### config.php

Each key in this file is the name of a menu. Each menu can have the following options:

| Options | Description |
|---|---|
| `active_class` | The CSS class to set on the active menu item |
| `children_class` | The CSS class to set on a menu item with children |
| `views.menu` | The blade template to use when rendering a menu |
| `views.item` | The blade template to use when rendering an item |

### menus.php

Just like before, each key in this file is the name of a menu.

Items are defined like this:
``` php
[
    'Home'    => '/',
    'About'   => 'about',
    'Contact' => 'contact',
]
```

If the item links to a route:
``` php
[
    'RoutedItem' => ['route' => 'home']
]
```

If the item has child items, then add them like this:
``` php
[
    'Nested'  => [
        'default' => '/',
        '1' => '1',
        '2' => '2',
    ]
]
```

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
