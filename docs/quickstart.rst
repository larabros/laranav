==========
Quickstart
==========

This page provides a quick introduction to Laranav and introductory examples.
If you have not already installed, head over to the :ref:`installation`
page.

Creating a menu
===============

Configuration
-------------

First, open ``config/laranav/config.php``:

.. code-block:: php
    'default' => [
        ...
    ]

Any menus added here automatically inherit their configuration from ``default``,
and can be overridden by specifying them in explicitly for each menu.
You can read more about available options [here](#configphp).


Menu items
----------

Next, we will define items for the menu in ``config/laranav/menus.php``:

.. code-block:: php
    'default' => [
        ...
    ],

Items can link to a simple URL, or you can use Laravel's `UrlGenerator` object to generate URLs. You can read more about available options [here](#menusphp)


Rendering the menu
------------------

Finally, in your template, add `{!! Nav::menu('myMenu')->toHtml() !!}` and your menu should render!
