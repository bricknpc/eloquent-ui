# Eloquent UI

Eloquent UI is a PHP-first UI framework for Laravel applications. It provides high-level UI constructs such as 
confirmation modals, currency inputs, and interactive components without requiring developers to write Blade, 
JavaScript, or CSS.

This is a companion package to the [Eloquent Tables](https://github.com/bricknpc/eloquent-tables) package which is 
why there are no table components included.

## Installation

```bash
composer require bricknpc/eloquent-ui
```

## Usage

### Publishing assets

```bash
php artisan vendor:publish --tag=eloquent-ui-config
php artisan vendor:publish --tag=eloquent-ui-views
php artisan vendor:publish --tag=eloquent-ui-assets
```

You will need to publish as least the assets because those contain the JavaScript and CSS required to render the 
components.

### View namespace

All views are available under the `bui::` namespace.

```bladehtml
<x-bui::confirmation />
```

## Development

Start the development environment:

```bash
docker compose up -d
```

Docs will be available at http://localhost:3001