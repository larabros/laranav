# laranav

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

An easy-to-use, customisable menu and navigation package for Laravel 5.1+.

Why is this different from every other menu package?

- Define your menus in simple config files
- Use regular ol' Blade templates for rendering menus - never build HTML programatically again!
- Fully-tested

## Install

Via Composer

``` bash
$ composer require hassankhan/laranav
```

Then, open `config/app.php` and add the service provider. You can optionally add the `Nav` facade:

``` php
'providers' => [

    ...
    Laranav\LaranavServiceProvider::class,

],
'aliases' => [

    ...
    'Nav' => Laranav\Facades\Nav::class,

],
```

After registering the service provider, run `php artisan vendor:publish` to publish Laranav's config files and example template files to your project.

## Usage

First, open `config/laranav/config.php` and add a new menu `myMenu` like so:

``` php
'default' => [
    ...
],
'myMenu' => []
```

Any menus you create automatically inherit from `default`, and so you can easily override any options by specifying them in each menu's configuration. You can read more about available options [here](#configphp).

Next, open `config/laranav/menus.php` and add some items:
``` php
'default' => [
    ...
],
'myMenu' => [
    'Home'    => '/',
    'About'   => 'about',
]
```

Items can link to a simple URL, or you can use Laravel's `UrlGenerator` object to generate URLs. You can read more about available options [here](#menusphp)

Finally, in your template, add `{!! Nav::menu('myMenu')->toHtml() !!}` and your menu should render!

## Configuration

Laranav publishes **two** files to your `config/laranav`: `config.php` and `menus.php`. An example menu named `default` is provided which can be overwritten.

### config.php

Each key in this file is the name of a menu. Each menu can have the following options:

| Options | Description | Default |
|---|---|---|
| `active_class` | The CSS class to set on the active menu item | `active` |
| `children_class` | The CSS class to set on a menu item with children | `dropdown` |
| `views.menu` | The blade template to use when rendering a menu | `laranav::partials.menu` |
| `views.item` | The blade template to use when rendering an item | `laranav::partials.item` |

### menus.php

Just like before, each key in this file is the name of a menu.

Items are defined like this:
``` php
'myMenu' => [
    'Home'    => '/',
    'About'   => 'about',
    'Contact' => 'contact',
]
```

You can use Laravel's routing to generate URLs for the menu items - the following methods are allowed:

- `to()`
- `secure()`
- `asset()`
- `route()`
- `action()`

Items are then defined like this:
``` php
'myMenu' => [
    'Home'    => ['route' => 'home'],
    'About'   => ['action' => 'HomeController@about'],
    'Contact' => ['to' => 'contact'],
]
```

If the item has child items, then add them like this:
``` php
'myMenu' => [
    'Nested'  => [
        'default' => '/',
        '1' => '1',
        '2' => '2',
    ]
]
```

> Items with children **require** a `default` key.

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
