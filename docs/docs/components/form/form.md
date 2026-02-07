---
sidebar_position: 2
title: Form
description: A secure, accessible form wrapper component with built-in CSRF protection, method spoofing, and support for file uploads.
---

# Form

The Form component provides a secure wrapper around HTML forms with built-in Laravel integration, including CSRF
protection, HTTP method spoofing, and support for file uploads.

## Usage

In its most basic form, the Form component only needs an action to render a working form with CSRF protection.

```html
<!-- Basic form -->
<x-eloquent-ui::form action="/products">
    <!-- Form fields here -->
</x-eloquent-ui::form>

<!-- Form with method -->
<x-eloquent-ui::form action="/products" method="post">
    <!-- Form fields here -->
</x-eloquent-ui::form>
```

### HTTP Methods

The Form component supports all standard HTTP methods. By default, forms use the `POST` method. You can specify
different methods using the `method` attribute.

```html
<!-- POST request (default) -->
<x-eloquent-ui::form action="/products">
    <!-- Fields -->
</x-eloquent-ui::form>

<!-- GET request -->
<x-eloquent-ui::form action="/products/search" method="get">
    <!-- Fields -->
</x-eloquent-ui::form>

<!-- PUT request (uses method spoofing) -->
<x-eloquent-ui::form action="/products/1" method="put">
    <!-- Fields -->
</x-eloquent-ui::form>

<!-- PATCH request (uses method spoofing) -->
<x-eloquent-ui::form action="/products/1" method="patch">
    <!-- Fields -->
</x-eloquent-ui::form>

<!-- DELETE request (uses method spoofing) -->
<x-eloquent-ui::form action="/products/1" method="delete">
    <!-- Fields -->
</x-eloquent-ui::form>
```

:::info[Method Spoofing]

Since HTML forms only support `GET` and `POST` methods natively, the Form component automatically adds Laravel's
`@method` directive when you specify `PUT`, `PATCH`, or `DELETE`. This allows Laravel to route the request correctly.

:::

### File Uploads

When your form needs to handle file uploads, set the `files` attribute to `true`. This automatically adds the correct
`enctype="multipart/form-data"` attribute to the form.

```html
<x-eloquent-ui::form action="/products" method="post" :files="true">
    <x-eloquent-ui::input.file-row name="image" label="Product Image" />
    <!-- Other fields -->
</x-eloquent-ui::form>
```

### Form Identification

You can give your form a unique identifier using the `name` attribute. This sets both the `id` and `name` attributes
on the form element, which is useful for JavaScript interactions and accessibility.

```html
<x-eloquent-ui::form action="/products" name="product-form">
    <!-- Fields -->
</x-eloquent-ui::form>
```

This renders as:

```html
<form id="product-form" name="product-form" action="/products" method="post">
    <!-- Fields -->
</form>
```

### Attributes

The Form component supports all HTML form attributes. For some attributes, additional logic is applied to
ensure they work correctly with the Form component.

#### Target

Specify where to display the form response:

```html
<!-- Open response in a new tab -->
<x-eloquent-ui::form action="/export" target="_blank">
    <!-- Fields -->
</x-eloquent-ui::form>

<!-- Other valid targets: _self, _parent, _top -->
<x-eloquent-ui::form action="/products" target="_self">
    <!-- Fields -->
</x-eloquent-ui::form>
```

:::info[Security]

When using `target="_blank"`, the Form component automatically adds `rel="noopener noreferrer"` for security purposes.

:::

#### Rel

Define the relationship between the current document and the linked resource:

```html
<x-eloquent-ui::form action="/external-api" target="_blank" rel="external noopener">
    <!-- Fields -->
</x-eloquent-ui::form>
```

## Eloquent models

Forms can automatically set the values of the form fields based on the attributes of an Eloquent model. Pass the
model to the `model` attribute and the inputs inside the form will be automatically filled with the model's attributes.

```html
<x-eloquent-ui::form action="/products" method="post" :model="$product">
    <!-- Fields -->
</x-eloquent-ui::form>
```

Individual inputs will look for a matching attribute on the model and will use the value of that attribute as the
default value for the input. You can overwrite this behaviour by passing a custom closure to the `valueUsing` attribute
on the input or by using the `value` attribute directly, which takes precedence over the model's attribute.

```html
<!-- Using a closure -->
<x-eloquent-ui::form action="/products" method="post" :model="$product">
    <x-eloquent-ui::input name="name" label="Product Name" :valueUsing="fn(Product $product, array $componentAttributes) => $product->display_name" />
</x-eloquent-ui::form>

<!-- Using the value attribute -->
<x-eloquent-ui::form action="/products" method="post" :model="$product">
    <x-eloquent-ui::input name="name" label="Product Name" value="Custom value" />
</x-eloquent-ui::form>
```

## Label configuration

All input components support a `label` attribute, which when provided adds a label to the input. The label can be
customised with a number of different options. You can set these options on each input individually or on the form
component itself to apply them to all inputs inside the form. If nothing is set on the form or the input component,
the values from the config will be used.

### Label position

The label position determines where the label is rendered relative to the input. It should be one of the
`BrickNPC\EloquentUI\Enums\LabelPosition` enum values.

```html
<x-eloquent-ui::form action="/products" method="post" :labelPosition="BrickNPC\EloquentUI\Enums\LabelPosition::Top">
    <!-- Fields -->
</x-eloquent-ui::form>
```

### Label width

When adding a label to an input, Eloquent UI uses Bootstrap's grid system to determine the width of the label. You can
set the width of the label using the `label-width` attribute on the form or the input component. The value should be the
number of columns the label should span.

```html
<x-eloquent-ui::form action="/products" method="post" label-width="2">
    <!-- Fields -->
</x-eloquent-ui::form>
```

### Row class

When adding a label input, Eloquent UI wraps the label and the input in a `.row` element. You can add custom classes to
this row using the `row-class` attribute on the form or the input component.

```html
<x-eloquent-ui::form action="/products" method="post" row-class="mb-1 border-bottom border-secondary">
    <!-- Fields -->
</x-eloquent-ui::form>
```

### Required indicator

When marking an input as required and providing a label at the same time, the label is rendered with both visible and
accessible indicators for required fields. You can set the icon used for the required indicator using the
`required-icon` attribute on the form or the input component. You can also set the style of the required indicator
using the `required-style` attribute.

```html
<x-eloquent-ui::form action="/products" method="post" required-icon="!" required-style="warning">
    <!-- Fields -->
</x-eloquent-ui::form>
```

## Features

The Form component includes several built-in features for security and Laravel integration.

### CSRF Protection

All forms except those using the `GET` method automatically include Laravel's CSRF token via the `@csrf` directive.
This protection is built-in and requires no additional configuration.

```html
<x-eloquent-ui::form action="/products" method="post">
    <!-- @csrf is automatically included -->
</x-eloquent-ui::form>
```

If you want to add a CSRF token to a `GET` request as well, you can either use the `@csrf` blade directive directly or
set the `force-csrf` attribute to `true`.

```html
<x-eloquent-ui::form action="/products" method="get">
    @csrf
    <!-- Form elements -->
</x-eloquent-ui::form>

<x-eloquent-ui::form action="/products" method="get" :force-csrf="true">
    <!-- Form elements -->
</x-eloquent-ui::form>
```

:::warning[GET CSRF token]

Adding a CSRF token to a `GET` request is not recommended, because it exposes the CSRF token to the URL of the request.

:::

### Method Spoofing

When using HTTP methods other than `GET` and `POST`, the Form component automatically includes Laravel's `@method`
directive to enable proper routing.

```html
<x-eloquent-ui::form action="/products/1" method="put">
    <!-- @method('PUT') is automatically included -->
</x-eloquent-ui::form>
```

### Accessibility

The Form component is designed with accessibility in mind:

- Uses semantic `<form>` HTML element
- Supports custom `id` and `name` attributes for form identification
- Allows passing `aria-` attributes via the `{{ $attributes }}` bag
- Works seamlessly with accessible form field components

```html
<x-eloquent-ui::form 
    action="/products" 
    name="product-form"
    aria-labelledby="form-title"
>
    <h2 id="form-title">Add New Product</h2>
    <!-- Fields -->
</x-eloquent-ui::form>
```

## Advanced Usage

### Custom Attributes

You can add any custom HTML attributes to the form using Laravel's attribute bag:

```html
<x-eloquent-ui::form 
    action="/products" 
    class="needs-validation" 
    data-turbo="false"
    x-data="productForm()"
    novalidate
    autocomplete="off"
>
    <!-- Fields -->
</x-eloquent-ui::form>
```

This renders as:

```html
<form 
    action="/products" 
    method="post" 
    class="needs-validation" 
    data-turbo="false" 
    x-data="productForm()"
    novalidate
    autocomplete="off"
>
    <!-- @csrf and fields -->
</form>
```

### Data Attributes

The Form component supports custom data attributes for JavaScript integration:

```html
<x-eloquent-ui::form 
    action="/products" 
    data-controller="form"
    data-action="submit->form#validate"
>
    <!-- Fields -->
</x-eloquent-ui::form>
```