---
sidebar_position: 4
title: Toasts
description: Easy toast messages
---

# Toasts

Toasts are small push notifications that appear somewhere on the screen. You can use them by simply placing the 
toaster component in your layout.

```html
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Head content -->
    </head>
    <body>
        <!-- Other content -->
        <x-eloquent-ui::toast.toaster />
    </body>
</html>
```

Toasts are queued up in the toaster service and will be displayed automatically when the page loads for the next 
request. They are ideal to let users know that, for instance, a form submission was successful, or that an error 
occurred.

## Usage

:::warning[JavaScript]
Bootstrap does not automatically initialise toasts after installation. Toasts are opt-in for performance reasons, so 
you must initialise them yourself. Therefore, Eloquent UI also does not automatically initialise toasts after 
installation. You must manually activate them. See the installation instructions below on how to do this.
:::

### Installation

To activate toasts, you need to manually add the following snippet to your JavaScript:

```javascript
// This snipped assumes you have Bootstrap 5 installed and imported in your script like this:
import * as bootstrap from 'bootstrap';
// If you are using a different way to initialise Bootstrap, you will need to adjust the snippet accordingly.

// The next line is provided by the Eloquent UI package in the JavaScript asset, but in case for some reason 
// `window.EloquentUI` is not defined, you can define it yourself. You will also need the correct meta tag in your 
// layout. See installation instructions for the package in general for more information.
/**
 * @typedef {Object} EloquentUI
 * @property {string} ns
 *
 * @type {EloquentUI}
 */
window.EloquentUI = JSON.parse(document.querySelector('meta[name="eloquent-ui"]').content);

// This is the part actually needed for the Toast component to work.
const EloquentUIToastList = document.querySelectorAll('.toast');
[...EloquentUIToastList].forEach(toast => new bootstrap.Toast(
    toast, {
        autohide: toast.dataset[`${window.EloquentUI.ns}AutoHide`] === 'true',
        delay: parseInt(toast.dataset[`${window.EloquentUI.ns}AutoHideDelay`]),
    },
).show());
```

### Position

By default, the toast container will be positioned to the bottom right of the screen. You can change this by adding the 
`location` attribute to the toast component. The value of this `location` attribute should be one of the 
`BrickNPC\EloquentUI\Enums\ToastLocation` enum cases.

```html
<x-eloquent-ui::toast.toaster :location="BrickNPC\EloquentUI\Enums\ToastLocation::TopRight" />
```

There are eight available positions:

- `BrickNPC\EloquentUI\Enums\ToastLocation::TopLeft`
- `BrickNPC\EloquentUI\Enums\ToastLocation::TopRight`
- `BrickNPC\EloquentUI\Enums\ToastLocation::BottomLeft`
- `BrickNPC\EloquentUI\Enums\ToastLocation::BottomRight` (default)
- `BrickNPC\EloquentUI\Enums\ToastLocation::TopCenter`
- `BrickNPC\EloquentUI\Enums\ToastLocation::BottomCenter`
- `BrickNPC\EloquentUI\Enums\ToastLocation::LeftMiddle`
- `BrickNPC\EloquentUI\Enums\ToastLocation::RightMiddle`

### Attributes

You can pass any attribute to the toast component that you would normally pass to a regular HTML element, including 
custom classes. It will be added to the toast container element.

```html
<x-eloquent-ui::toast.toaster 
    :location="BrickNPC\EloquentUI\Enums\ToastLocation::TopRight" 
    class="m-2" 
    data-custom="toaster-container" 
/>
```

## Backend

Eloquent UI not only provides a frontend component for toasts, it also adds a Toaster service to your app that you can 
use to send out toast messages.

### Toaster

To use the Toaster service, you need to inject the `BrickNPC\EloquentUI\Services\Toaster` class where you want to use 
it. Since toasts are a frontend thing, it is most logical to use the Toaster in your frontend controllers.

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use BrickNPC\EloquentUI\Enums\ToastTheme;
use BrickNPC\EloquentUI\Services\Toaster;
use App\Http\Requests\StoreProductRequest;
use BrickNPC\EloquentUI\ValueObjects\Toast;

readonly class StoreProductController
{
    public function __construct(
        private Toaster $toaster,
    ) {}
    

    public function __invoke(StoreProductRequest $request)
    {
        // Authentication, store product, etc.
        
        $this->toaster->success('Product created successfully!');
        
        // Or manually toast
        $this->toaster->toast(new Toast(
            title: 'Product created successfully!',
            description: 'The new product has been created successfully.',
            theme: ToastTheme::Success,
            autohide: true,
            autohideDelayInMs: 5000,
            borderTheme: 'dark',
        ));
        
        // Or in case of an error
        $this->toaster->danger('Could not create product.', $exception->getMessage());
    }
}
```

### Toast options

When sending out a toast, there are several different options available.

| Option:             | Type:                                  | Required:                               | Description:                                                                                                                                                                                            |
|---------------------|----------------------------------------|-----------------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `title`             | `string`                               | Yes                                     | The title of the toast message.                                                                                                                                                                         |
| `description`       | `string`                               | No                                      | A description of the toast message that will be displayed below the title.                                                                                                                              |
| `theme`             | `BrickNPC\EloquentUI\Enums\ToastTheme` | Yes (defaults to `ToastTheme::Success`) | The theme of the toast. Either `ToastTheme::Success`, `ToastTheme::Warning`, `ToastTheme::Danger` or `ToastTheme::Info`. This will not affect functionality, only the colour of the icon in the header. |
| `autohide`          | `bool`                                 | Yes (defaults to `true`)                | Whether the toast should automatically hide after a delay.                                                                                                                                              |
| `autohideDelayInMs` | `int`                                  | Yes (defaults to `5000`)                | The delay in milliseconds before the toast should autohide.                                                                                                                                             |
| `borderTheme`       | `string`                               | Yes (defaults to `dark`)                | The theme for the border colour of the toasts. This should be one of your Bootstrap theme colours, like `primary`, `warning` or `dark`.                                                                 |

### Helper methods

The toaster service has a few helper methods to create toasts more easily.

| Method      | Description                                   |
|-------------|-----------------------------------------------|
| `success()` | Pushes a success themed toast to the toaster. |
| `warning()` | Pushes a warning themed toast to the toaster. |
| `danger()`  | Pushes a danger themed toast to the toaster.  |
| `info()`    | Pushes an info themed toast to the toaster.   |


## Advanced Usage

### Getting the toasts

You can manually get the toasts from the toaster service by calling the `getToasts()` method on the 
`BrickNPC\Services\Toaster` service. This will return an array of `BrickNPC\EloquentUI\ValueObjects\Toast` objects that 
are so far queued up in the toaster.

### Toasts in your views

The toast component automatically injects all toasts that have been queued up in the toaster into every view. You can 
access them through the `$_eloquent_ui__toasts` variable in your views. The content will be an array of 
`BrickNPC\EloquentUI\ValueObjects\Toast` objects.