# Eloquent UI

Eloquent UI is a PHP-first UI framework for Laravel applications. It provides high-level UI constructs such as 
confirmation modals, currency inputs, and interactive components without requiring developers to write Blade, 
JavaScript, or CSS.

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

### View namespace
All views are available under the bui:: namespace.

```bladehtml
<x-bui::confirmation-modal />
```

### Development
Start the development environment:

```bash
docker compose up -d
```

Docs will be available at http://localhost:3001