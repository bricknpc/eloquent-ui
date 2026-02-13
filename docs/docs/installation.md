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

### Layout adjustments

Include the CSS and JavaScript files in your layout. Also, add the custom meta-tag to your layout.

```html
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>My App</title>
        <!-- Other head elements, your app CSS, etc -->
        {{ BrickNPC\EloquentUI\meta() }}
        @asset('vendor/eloquent-ui/eloquent-ui.css')
    </head>
    <body>
        <!-- body contents -->
        
        <!-- Your app scripts -->
        @asset('vendor/eloquent-ui/eloquent-ui.js')
    </body>
</html>
```

:::warning[Meta Tag]
Do not forget to include the meta-tag in your layout: `{{ BrickNPC\EloquentUI\meta() }}`. This custom meta-tag 
contains the configuration values that are used by the JavaScript components, like the namespace for the custom 
`data-` attributes.
:::

## Usage

You can now use the components in your views.

```html
<x-eloquent-ui::input.currency name="amount" />
```

:::warning[Custom JavaScript]
Bootstrap does not automatically initialise every component that requires JavaScript for performance reasons. For those 
same reasons, Eloquent UI also does not initialise these components automatically. Some components that depend on 
JavaScript must be initialised manually. If a component requires this manual initialisation, it will be documented in 
the component's documentation.
:::

### Optional files

Eloquent UI gives you the option to publish the optional files that are used by the components. These files are the 
config file, the translation files, and the view files.

```bash
php artisan vendor:publish --tag=eloquent-ui-config
php artisan vendor:publish --tag=eloquent-ui-translations
php artisan vendor:publish --tag=eloquent-ui-views
```