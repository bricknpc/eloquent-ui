---
sidebar_position: 3
title: Card Form
description: A secure, accessible form wrapper component with built-in CSRF protection, method spoofing, and support for file uploads with card styling.
---

# Card Form

The card form component is an extension of the [Form](form.md) component. It offers the same functionality and features 
as the form component but with a card styling.

```html
<x-eloquent-ui::form.card action="/products/create">
    <!-- Form content -->
</x-eloquent-ui::form.card>
```

## Attributes

All attributes you add to the card form component will be passed along to the underlying form element, except for any 
custom classes, which will be applied to the card element instead.

## Slots

### Header

Like with normal cards, you can add a header to the card form component by adding a `header` slot.

```html
<x-eloquent-ui::form.card action="/products/create">
    <x-slot:header>
        <h2 class="fs-3 text-dark">Create Product</h2>
    </x-slot:header>
    <!-- Form content -->
</x-eloquent-ui::form.card>
```

You can add any attributes to the header slot, including custom classes, and they will be applied to the header element.

### Footer

Like with normal cards, you can add a footer to the card form component by adding a `footer` slot.

```html
<x-eloquent-ui::form.card action="/products/create">
    <!-- Form content -->
    <x-slot:footer>
        Footer content
    </x-slot:footer>
</x-eloquent-ui::form.card>
```

You can add any attributes to the footer slot, including custom classes, and they will be applied to the footer element.