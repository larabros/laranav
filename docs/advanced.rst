==========
Advanced
==========

This page provides a quick introduction to Laranav and introductory examples.
If you have not already installed, head over to the :ref:`installation`
page.

Configuration
=============

Laranav publishes **two** files to your Laravel project in ``config/laranav``:
``config.php`` and ``menus.php``. An example menu named ``default`` is provided
which can be overwritten.

config.php
----------

Each menu can be configured as follows:

.. code-block:: php

    'myMenu' => [
        'active_class'   => 'active',
        'children_class' => 'dropdown',
        'view'           => 'laranav::partials.menu',
    ],

+----------------------+-----------------------------------------------------+------------------------------+
| Options              | Description                                         | Default                      |
+======================+=====================================================+==============================+
| ``active_class``     | The CSS class to set on the active menu item        | ``active``                   |
+----------------------+-----------------------------------------------------+------------------------------+
| ``children_class``   | The CSS class to set on a menu item with children   | ``dropdown``                 |
+----------------------+-----------------------------------------------------+------------------------------+
| ``view``             | The blade template to use when rendering a menu     | ``laranav::partials.menu``   |
+----------------------+-----------------------------------------------------+------------------------------+

menus.php
---------

Items in a menu are defined like this:

.. code-block:: php

    'myMenu' => [
        'Home'    => '/',
        'About'   => 'about',
        'Contact' => 'contact',
    ]

You can use Laravel’s routing to generate URLs from routes defined in
your application’s ``routes.php`` - the following methods are allowed:

-  ``to()``
-  ``secure()``
-  ``asset()``
-  ``route()``
-  ``action()``

Items are then defined like this:

.. code-block:: php

    'myMenu' => [
        'Home'    => ['route' => 'home'],
        'About'   => ['action' => 'HomeController@about'],
        'Contact' => ['to' => 'contact'],
    ]

If the item has child items, then add them like this:

.. code-block:: php

    'myMenu' => [
        'Nested'  => [
            'default' => '/',
            '1' => '1',
            '2' => '2',
        ]
    ]

.. note::

    Items with children **require** a ``default`` key.

