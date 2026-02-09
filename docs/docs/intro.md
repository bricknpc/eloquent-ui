---
sidebar_position: 1
---

# Intro

**Build complete, accessible Laravel user interfaces with less code and fewer compromises.**

Eloquent UI is a full-stack, PHP-first UI framework for Laravel. It goes beyond frontend components by integrating 
deeply with the backend, so common concerns are handled once and handled correctly.

Instead of assembling forms, validation, accessibility, and error handling yourself, Eloquent UI provides 
production-ready components that manage the entire flow for you.

## What Eloquent UI gives you

- ✅ **Full-stack components**<br />UI components backed by Laravel-native integrations such as validation rules, model casts, database schema macros, request helpers, and supporting services.
- ✅ **Less boilerplate, more intent**<br />Components handle validation, error messages, old input, and accessibility automatically, so your code stays focused on application logic.
- ✅ **Accessibility by default**<br />Proper ARIA attributes, correct label relationships, and visually hidden content for screen readers are built in, not optional.
- ✅ **Designed for Laravel developers**<br />Built with Blade and PHP, styled with Bootstrap 5, and aligned with Laravel conventions. No custom syntax or heavy frontend abstractions.
- ✅ **Configurable by design**<br />Customise behaviour per component via attributes, or define global defaults through configuration files.
- ✅ **Production-ready quality**<br />Fully tested and thoroughly documented, with real-world examples you can rely on.

Eloquent UI is for teams who want UI components that feel native to Laravel, reduce repetitive work, and treat 
accessibility and backend integration as first-class concerns.

## Prerequisites

Eloquent UI is built on top of **Bootstrap 5**. Before installation, ensure Bootstrap 5 is installed in your Laravel 
project.

**Required:**
- Laravel `^12.0`
- Bootstrap `^5.3`
- PHP `^8.4|^8.5`

## Quick Start

Install the package via Composer:

```bash
composer require bricknpc/eloquent-ui
```

After that, publish the assets and set up your layout.

```html
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>My App</title>
        <!-- Other head elements, your app CSS, etc -->
        {{ BrickNPC\EloquentUI\meta() }}
        @asset('vendor/eloquent-ui/css/eloquent-ui.css')
    </head>
    <body>
        <!-- body contents -->
        
        <!-- Your app scripts -->
        @asset('vendor/eloquent-ui/js/eloquent-ui.js')
    </body>
</html>
```

Now start using the components

```html
{{-- Use powerful components immediately --}}
<x-eloquent-ui::input.currency
    name="price"
    label="Product Price"
    currency="USD"
    :required="true"
    :min="1"
    hint="Enter the retail price"
/>
```

That's it! You get a fully accessible, validated currency input with proper error handling, old input support, and 
professional styling.

### Validation That Works

Deep integration with Laravel's validation system:

```php
<?php

use BrickNPC\EloquentUI\Http\Rules\Currency;

public function rules(): array
{
    return [
        'price' => [
            new Currency(
                required: true,
                min: 1.00,
                max: 9999.99,
                currencies: ['USD', 'EUR']
            )
        ],
    ];
}
```

Validation messages automatically appear in the right place with proper accessibility attributes.

## License

Eloquent UI is licensed under the MIT licence.