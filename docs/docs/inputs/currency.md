---
sidebar_position: 2
title: Currency Input
description: A fully accessible currency input component with support for multiple currencies, validation, and locale-specific formatting.
---

# Currency Input

The Currency Input component provides a user-friendly way to input monetary values with support for multiple currencies, 
custom validation, and full accessibility compliance.

## Usage

In its most basic form, the Currency input component only needs a name to render a set of input fields for the user to 
enter a currency value.

```bladehtml
<x-eloquent-ui::input.currency name="price" />
```

### Currencies

There are three distinct ways in which you can use the Currency component: without currency, with a single currency, or 
with multiple currencies.

#### Without currency

This is the simplest behaviour. You don't need to add anything to the component to use it without currency. Not providing 
a component will render the component without currency options. The `{{ name }}-currency` hidden field will be empty 
in this case.

#### With a single currency

If you provide a single currency value to the component, it will use a prefix for the component to show the currency. 
It will also add this value to the `{{ name }}-currency` hidden field, so you can get the currency value from the 
request.

#### With multiple currencies

If you provide an array of currency values to the component, it will render a dropdown menu with the available 
currencies. A dropdown menu will be rendered in front of the input fields, and changing the currency will update the 
`{{ name }}-currency` hidden field accordingly. It will also broadcast the `CurrencyChanged` event when the currency 
changes, which also updates the accessibility labels of the input fields.

The currency array must be a key => value array, where the key is the currency value set in the `{{ name }}-currency` 
hidden field, and the value is the currency name that should be shown in the dropdown menu.

```php

$currencies = [
    'EUR' => 'Euro',
    'USD' => 'US Dollar',
    // Other currencies...
];

```

:::info[Validation of currencies]

If you provide an array of currencies to the component, you should provide the same array to the validation rule as 
well to make sure the frontend and backend validation logic matches.

:::

### Optional attributes

## Features

The Currency component supports the following features:

- **Tabindex** - The currency input component can be focused using the `tabindex` attribute. Keep in mind that the currency component consists of two or three input fields, depending on whether the currency is provided, so the tabindex for the next field will have to account for this.
- **Usability** - When typing a number into the whole number field, pressing either `.` or `,` will automatically move focus to the cent field. You can disable this behaviour be setting the `focus-switch` property to `false` directly on the component or globally in your config file.
- **Copy/paste support** - Pasting any number value into the whole number or cent field will automatically format it correctly and divide it into whole and cents. It can handle both `.` and `,` as decimal separators, and `.`, `,`, ` ` (space) and `_` as thousands separators.

## Backend logic

### Validation

Because the component internally renders three separate input fields, you can't use the default Laravel validation 
rules to validate the currency value. Instead, you'll need to use the provided `Currency` validation rule.

```php
<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use BrickNPC\EloquentUI\Http\Rules\Currency;

class StoreOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'price' => [new Currency(
                required: true,
                min: 0,
                max: 9999.99,
                currencies: ['EUR', 'USD'], 
            )],
        ];
    }
}

```

All properties of the `Currency` rule are optional. If no properties are provided, the rule will just validate whether 
the value is a valid currency amount.

#### Custom validation

For more complex validation logic, you will have to implement your own validation logic. If you do so, please consider 
opening a pull request to add it to the package.

### Getting the value from the request

To help you get the currency value from the request, the Currency input component comes with a `HasCurrencyInput` trait. 
This trait adds a `currency` method to your request class that returns the currency value as a 
`BrickNPC\EloquentUI\ValueObjects\CurrencyInput` object.

```php
<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use BrickNPC\EloquentUI\Http\Rules\Currency;
use BrickNPC\EloquentUI\Http\Traits\HasCurrencyInput;

class StoreOrderRequest extends FormRequest
{
    use HasCurrencyInput;

    public function getPrice(): int
    {
        return $this->currency('price')->amountInCents;
    }
}
```

The `CurrencyInput` has the following public properties that can be accessed:

| Property         | Type           | Description                                        |
|------------------|----------------|----------------------------------------------------|
| `$whole`         | `int`          | The amount before the decimal separator as an int. |
| `$cents`         | `int`          | The amount of cents as an int.                     |
| `$amount`        | `float`        | The total amount as a float.                       |
| `$amountInCents` | `int`          | The total amount in cents as an integer.           |
| `currency`       | `string\|null` | The currency selected.                             |

## Advanced usage

Internally, the Currency input component is split into three separate inputs: a hidden text field for the currency, 
a number field for the number of cents, and a number field for the whole number. They are added to the DOM with the 
following names and ID's:

- `{{ name }}-whole`
- `{{ name }}-cents`
- `{{ name }}-currency`

You can get these inputs from the request manually by using their names and use them in your own validation logic. You 
can also write custom JavaScript or CSS code to handle custom logic and styling by using these input names/ID's directly.

:::warning[A note about validation]

If you want to implement your own validation logic, make sure to account for leading zeros in the cents input field. 
All values in the cent field are left padded with zeros until they are two digits long. Laravel's `numeric` validation 
rule will not work correctly with this input, flagging any values with leading zeros as invalid.

:::

### Data attributes

Like with all other components, the Currency component supports custom data attributes. Adding a `data-` attribute to 
the Currency component will add it to the topmost HTML element of the component, which in this case is the `row`
element.

```bladehtml
<div {{ $attributes->merge(['class' => 'row mb-3']) }}> <!-- <-- This is the element the data attributes are added to -->
    The component
</div>
```