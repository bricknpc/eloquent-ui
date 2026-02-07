# Eloquent UI

![Logo](eloquent-ui-png-nobg-horizontal.png)

Eloquent UI is a comprehensive, PHP-first UI framework for Laravel applications that bridges the gap between backend 
and frontend. Unlike traditional component libraries that only provide Blade templates, Eloquent UI delivers a complete 
solution with high-level UI components, custom casts, validation rules, database schema helpers, and request handling. 
Everything you need to build rich, interactive frontends without writing repetitive boilerplate.

## Full-Stack Components

Eloquent UI provides complete implementations for complex UI patterns like currency inputs, confirmation modals, and 
form components. Each component includes:

- **Frontend**: Beautiful, accessible Blade components with JavaScript interactions based on Bootstrap 5
- **Backend**: Custom casts (e.g., `CurrencyCast`), validation rules, and request helpers
- **Database**: Schema macros for creating the proper database structure (e.g., `$table->currency('amount')`)
- **Integration**: Seamless model binding and form handling

## Stop Writing Boilerplate

Eloquent UI eliminates the need to write repetitive HTML, Blade directives, and accessibility markup. Instead of this:

```html
<div class="row mb-3">
    <label for="email" class="col-sm-3 col-form-label">
        Email:
        <span class="text-danger" aria-hidden="true">*</span>
        <span class="visually-hidden">required</span>
    </label>
    <div class="col-sm-9">
        <div class="input-group has-validation">
            <span class="input-group-text bg-secondary" id="email-addon">@</span>
            <input
                type="email"
                name="email"
                class="form-control @error($name) is-invalid @enderror"
                id="email"
                aria-describedby="email-addon email-feedback"
                aria-required="true"
                value="{{ old('email') }}"
                required="required"
                placeholder="example@email.com"
            />
            <div class="form-text">
                Please enter your email address.
            </div>
            <div id="email-feedback" class="invalid-feedback" role="alert">
                @error('email')
                    {{ $message }}
                @enderror
            </div>
        </div>
    </div>
</div>
```

You write this:

```html
<x-eloquent-ui::form.email name="email" label="Email": hint="Please enter your email address." placeholder="example@email.com" required="true">
    <x-slot:prefix>
        <x-eloquent-ui::input.addon.text>@</x-eloquent-ui::input.addon.text>
    </x-slot:prefix>
</x-eloquent-ui::form.email>
```

## Complete Backend Integration

Eloquent UI isn't just about prettier templates. For example, the currency component provides:

**In your migration:**
```php
$table->currency('amount')->nullable()->index(double: true);
// Creates: amount (bigInteger), amount_currency (string), and composite index
```

**In your model:**
```php
protected function casts(): array
{
    return [
        'amount' => CurrencyCast::class,
    ];
}
```

**In your Blade view:**
```html
<x-eloquent-ui::form action="#" :model="$order">
    <x-eloquent-ui::currency name="amount" label="Amount" />
</x-eloquent-ui::form>
```

The component automatically handles:
- Model binding with the `Currency` value object
- Proper storage of cents as integers and currency codes
- Validation of min/max constraints
- Paste support with automatic decimal separator detection
- Currency dropdown with accessibility announcements
- Overflow/underflow between whole and cents fields

## Companion Package

This is a companion package to [Eloquent Tables](https://github.com/bricknpc/eloquent-tables), which provides powerful 
table components for Laravel. Together, they form a complete solution for building data-driven applications. Eloquent UI 
focuses on forms, input elements and frontend components, while Eloquent Tables handles data display and table 
interactions.

## Framework Support

Eloquent UI is built on top of [Bootstrap 5](https://getbootstrap.com). Although there are plans to support other 
UI frameworks in the future, Bootstrap is currently the only supported framework.

## Installation

```bash
composer require bricknpc/eloquent-ui
```

## Requirements

- PHP `^8.4|^8.5`
- Laravel `^12.0`
- Bootstrap 5

## Usage

### Publishing assets

```bash
php artisan vendor:publish --tag=eloquent-ui-config
php artisan vendor:publish --tag=eloquent-ui-views
php artisan vendor:publish --tag=eloquent-ui-translations
php artisan vendor:publish --tag=eloquent-ui-assets
```

You will need to publish at least the assets because those contain the JavaScript and CSS required to render the 
components. Include the assets in your layout:

```html
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

### View namespace

All views are available under the `eloquent-ui::` namespace.

```html
<x-eloquent-ui::confirmation />
```

## Documentation

Documentation is available at [https://bricknpc.github.io/eloquent-ui](https://bricknpc.github.io/eloquent-ui).

## Local development

### Clone and install the project

This project has a simple docker setup for local development. To start local development, download the project
and start the docker container. You need to have Docker installed on your local machine for this.

First, clone the project.

```bash
git clone https://github.com/bricknpc/eloquent-ui.git
cd eloquent-tables
```

Up the docker container and install the dependencies.

```bash
docker-compose up -d
docker-compose exec php composer install
```

### Executing commands in the container

You can execute commands in the container using the exec option.

```bash
docker-compose exec php <your command>
```

If you rather log in to the container and execute commands manually, you can use this:

```bash
docker-compose exec php bash
```

### Stopping the container

```bash
docker-compose down
```

### Adding new components

When adding new components, please keep in mind the following guidelines:

- Always define every variable in either the `@props` directive or the `@aware` directive. This way you can quickly see which variables a component expects, and you don't need to right a lot of `ìf` statements checking if a variable is set or exists.
- You can use some PHP in an anonymous component, but when it starts getting complex, please create an actual class-based component so it is easier to test.
- The goal of a component is always to write as little boilerplate code as possible while still allowing for maximum customisation. This can be a bit contradictory, but it is important to keep in mind that the goal is to make it as easy as possible to use the components in any project.

### Documentation

When starting the docker container, the documentation site will automatically be started as well and will be available
on http://localhost:3001/eloquent-ui. The documentation is built using [Docusaurus](https://docusaurus.io/). When
adding new features or making changes, please also update the documentation.

## Running tests

You can run the tests using the following command.

```bash
docker-compose exec php composer test
```

### Test coverage

Unfortunately, PHP Unit cannot create test coverage for blade views, and since most of the components in Eloquent UI
are anonymous components that only consist of a blade view, test coverage is not possible.

## Code quality tools

Eloquent Tables uses PHP CS Fixer and PHPStan to ensure a high-quality code base. You can run the tools locally
using the following commands.

**PHP CS Fixer:**
```bash
docker-compose exec php composer cs
```

**PHPStan:**
```bash
docker-compose exec php composer ps
```

## Community showcase

Are you using Eloquent UI in your project? Let us know by opening a pull request to add your project to the
[community showcase](https://github.com/bricknpc/eloquent-ui/blob/main/docs/src/pages/showcase.js). We love seeing
what people are building with Eloquent UI.

## Contributing

Pull requests are welcome. When creating a pull request, please include what you changed and why in the description of
the pull request. When fixing a bug, please include a test that reproduces the bug and describe how to test the bug
manually.

Before creating a pull request, please run the tests and code quality tools locally.