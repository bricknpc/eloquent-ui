# Eloquent UI

Eloquent UI is a PHP-first UI framework for Laravel applications. It provides high-level UI constructs such as 
confirmation modals, currency inputs, and interactive components without requiring developers to write Blade, 
JavaScript, or CSS.

It also helps you to stop having to write boilerplate like this:

```bladehtml
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

```bladehtml
<x-eloquent-ui::form.email name="email" required hint="Please enter your email address." placeholder="example@email.com" prefix="@" />
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

### View namespace

All views are available under the `eloquent-ui::` namespace.

```bladehtml
<x-bui::confirmation />
```

## Documentation

Documentation will soon be available at [https://bricknpc.github.io/eloquent-ui](https://bricknpc.github.io/eloquent-ui).

## Development

Start the development environment:

```bash
docker compose up -d
```

Login to the container:

```bash
docker composer exec php bash
```

### Installing dependencies

```bash
docker compose exec php composer install
docker compose exec php npm install
```

### Building the frontend assets

```bladehtml
docker composer exec php npm run build
```

Make sure to build the assets when publishing new versions. When the docker containers are running, the assets will 
automatically be rebuilt (it may take a few seconds for the changes to take effect).

### Tests and code quality

```bash
docker compose exec php composer test # Run tests
docker compose exec php composer cs # Run code style checks
docker compose exec php composer ps # Run PHPStan
```

Docs will locally be available at http://localhost:3001