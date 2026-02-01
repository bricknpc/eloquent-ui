---
sidebar_position: 2
---

# Installation

## Requirements

- PHP `^8.4|^8.5`
- Laravel `^12.0`
- Bootstrap `^5.3`

## Installation

Install the package via composer: 

```bash
composer require bricknpc/eloquent-ui
```

After installation, publish the assets:

```bash
php artisan vendor:publish --tag=eloquent-ui-assets
```

## Usage

Include the CSS and JavaScript files in your layout:

```bladehtml
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Other head elements -->
        @asset('vendor/eloquent-ui/css/eloquent-ui.css')
    </head>
    <body>
        <!-- body contents -->
        
        @asset('vendor/eloquent-ui/js/eloquent-ui.js')
    </body>
</html>
```

You can now use the components in your views.

```php
<x-eloquent-ui::input.currency name="amount" />
```