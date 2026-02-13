---
sidebar_position: 3
title: List group cards
description: List group cards in Eloquent UI
---

# List group cards

A list group card is a card element containing a list of items. You could create a list group card with the custom 
card components yourself, but this component is provided for convenience.

In its simplest form, a list group card is a card with a list of items.

```html
<x-eloquent-ui::card.list>
    <x-eloquent-ui::card.list-item>Item 1</x-eloquent-ui::card.list-item>
    <x-eloquent-ui::card.list-item>Item 2</x-eloquent-ui::card.list-item>
</x-eloquent-ui::card.list>
```

## Usage

### Theme

The list card does not support the `theme` attribute, but if you want to add it, you can add the class to the 
component.

```html
<x-eloquent-ui::card.list class="text-bg-primary">
    <x-eloquent-ui::card.list-item>Item 1</x-eloquent-ui::card.list-item>
    <x-eloquent-ui::card.list-item>Item 2</x-eloquent-ui::card.list-item>
</x-eloquent-ui::card.list>
```

### Header

You can add a header to the list card by adding the `header` slot. This will render a header tag inside the list card 
element.

:::warning[Slot]
It is important that you use a slot to add a header and not just an attribute since the component will also try to render
any attributes you add to the slot.
:::

```html
<x-eloquent-ui::card.list>
    <x-slot:header>My header</x-slot:header>
</x-eloquent-ui::card.list>
```

#### Header attributes

You can add any attributes to the header slot. These will be added to the header tag, including the `class` attribute.

```html
<x-eloquent-ui::card.list>
    <x-slot:header class="p-3 text-end">My header</x-slot:header>
</x-eloquent-ui::card.list>
```

### Footer

You can add a header to the list card by adding the `footer` slot. This will render a footer tag inside the list card 
element.

:::warning[Slot]
It is important that you use a slot to add a footer and not just an attribute since the component will also try to render
any attributes you add to the slot.
:::

```html
<x-eloquent-ui::card.list>
    <x-slot:footer>My footer</x-slot:footer>
</x-eloquent-ui::card.list>
```

#### Footer attributes

You can add any attributes to the footer slot. These will be added to the footer tag, including the `class` attribute.

```html
<x-eloquent-ui::card.list>
    <x-slot:footer class="p-3 text-end">My footer</x-slot:footer>
</x-eloquent-ui::card.list>
```

## Backend

There are no backend components for list cards.