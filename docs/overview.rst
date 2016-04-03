========
Overview
========

Requirements
============

#. PHP 5.5.9+
#. Laravel 5.1+

.. _installation:

Installation
============

The recommended way to install Laranav is with
`Composer <http://getcomposer.org>`_. Composer is a dependency management tool
for PHP that allows you to declare the dependencies your project needs and
installs them into your project.

.. code-block:: bash

    # Install Composer
    curl -sS https://getcomposer.org/installer | php

You can add Laranav as a dependency using the ``composer.phar`` CLI:

.. code-block:: bash

    php composer.phar require larabros/laranav:~1.0

Alternatively, you can specify it as a dependency in your project's
existing ``composer.json`` file:

.. code-block:: js

    {
      "require": {
         "larabros/laranav": "~1.0"
      }
   }

Then, open ``config/app.php`` in your Laravel project and add the service
provider. You can optionally add the ``Nav`` facade:

.. code-block:: php
    'providers' => [

        ...
        Laranav\LaranavServiceProvider::class,

    ],
    'aliases' => [

        ...
        'Nav' => Laranav\Facades\Nav::class,

    ],

After registering the service provider, run ``php artisan vendor:publish`` to
publish Laranav's config files and example template files to your project.

License
=======

Licensed using the `MIT license <http://opensource.org/licenses/MIT>`_.

    Copyright (c) 2016 Hassan Khan <contact@hassankhan.me>

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.
