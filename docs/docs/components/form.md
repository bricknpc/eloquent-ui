---
sidebar_position: 1
title: Form
description: A secure, accessible form wrapper component with built-in CSRF protection, method spoofing, and support for file uploads.
---

# Forms

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

### Optional attributes

The Form component supports several optional HTML form attributes:

#### Autocomplete

Control browser autocomplete behaviour for the entire form:

```html
<!-- Enable autocomplete (browser default) -->
<x-eloquent-ui::form action="/login" autocomplete="on">
    <!-- Fields -->
</x-eloquent-ui::form>

<!-- Disable autocomplete for sensitive data -->
<x-eloquent-ui::form action="/payment" autocomplete="off">
    <!-- Fields -->
</x-eloquent-ui::form>
```

#### Novalidate

Disable browser-side HTML5 validation when you prefer to rely on server-side validation:

```html
<x-eloquent-ui::form action="/products" :novalidate="true">
    <!-- Fields will only use Laravel validation -->
</x-eloquent-ui::form>
```

:::warning[No-validation]

Setting `novalidate="true"` is only recommended when using Laravel's validation system to ensure correct and validated 
input on the backend.

:::

:::tip[Server-side Validation]

Using Laravel's server-side validation should always be implemented even when using client-side validation, because 
client-side validation can be bypassed by malicious users.

:::

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

#### Accept-Charset

Specify the character encoding for form submission:

```html
<x-eloquent-ui::form action="/products" accept-charset="UTF-8">
    <!-- Fields -->
</x-eloquent-ui::form>
```

#### Rel

Define the relationship between the current document and the linked resource:

```html
<x-eloquent-ui::form action="/external-api" target="_blank" rel="external noopener">
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