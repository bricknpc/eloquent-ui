# Eloquent UI

Eloquent UI is a PHP-first UI framework for Laravel applications. It provides high-level UI constructs such as 
confirmation modals, currency inputs, and interactive components without requiring developers to write Blade, 
JavaScript, or CSS.

It also helps you to stop having to write boilerplate like this:

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

And replace it with this:

```html
<x-eloquent-ui::form.email name="email" label="Email": hint="Please enter your email address." placeholder="example@email.com" required="true">
    <x-slot:prefix>
        <x-eloquent-ui::input.addon.text>@</x-eloquent-ui::input.addon.text>
    </x-slot:prefix>
</x-eloquent-ui::form.email>
```

This is a companion package to the [Eloquent Tables](https://github.com/bricknpc/eloquent-tables) package, which is 
why there are no table components included in Eloquent UI.

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