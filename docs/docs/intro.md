---
sidebar_position: 1
---

# Intro

**Build production-ready Laravel applications faster with accessible, feature-rich UI components.**

Eloquent UI is a comprehensive PHP-first component library designed specifically for Laravel developers who want to ship 
faster without sacrificing quality. Unlike other UI libraries, Eloquent UI delivers functional, accessible, and beautiful
components with both stunning visuals and robust functionality built-in.

## Why Eloquent UI?

- **🚀 Ship Faster** - Stop writing repetitive boilerplate code. Drop in complete, production-ready components.
- **♿ Accessibility First** - Every component is WCAG 2.1 compliant with proper ARIA attributes and screen reader support.
- **🎨 Bootstrap 5 Powered** - Built on the world's most popular CSS framework for consistent, professional design.
- **🔧 Laravel Native** - Seamless integration with Laravel's validation, forms, and request handling.
- **📦 Feature Complete** - Get validation, error handling, old input support, and more out of the box.
- **🎯 PHP-First Design** - Define your UI in PHP/Blade with full IDE autocomplete and type safety.

## Built for Modern Laravel Development

Eloquent UI isn't just another component library - it's a complete solution for building professional Laravel 
applications. Each component includes:

- ✅ **Server-side validation integration** with Laravel's validation rules
- ✅ **Accessibility compliance** meeting international standards (WCAG 2.1)
- ✅ **Responsive design** that works on any device
- ✅ **Error handling** with automatic display of validation messages
- ✅ **Old input preservation** for a better user experience
- ✅ **Customisable styling** through configuration
- ✅ **Extensive documentation** with real-world examples

## Prerequisites

Eloquent UI is built on top of **Bootstrap 5**. Before installation, ensure Bootstrap 5 is included in your Laravel 
project.

**Required:**
- Laravel `^12.0`
- Bootstrap 5.x
- PHP `^8.4`

## Quick Start

```bash
composer require bricknpc/eloquent-ui
```

```bladehtml
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

Eloquent UI is open-source software licensed under the MIT licence.