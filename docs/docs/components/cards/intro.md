---
sidebar_position: 1
title: Intro
description: Cards in Eloquent UI
---

# Cards

Cards are pretty simple components in Bootstrap and could easily be created with just the Bootstrap classes. Eloquent 
UI does provide a wrapper around the class component for a few reasons. The first is to keep the syntax consistent with 
the rest of the components. It wouldn't look nice if you're using `<x-eloquent-ui::component />` everywhere, but 
for cards you'd use the normal Bootstrap classes.

The second reason is future proofing. Although Bootstrap 5 is currently the only supported frontend, we do have plans 
to support other frameworks in the future. And Bootstrap itself may change its structure in the future.

And the final reason is that Eloquent UI provides a few extra features that are not available in Bootstrap, or that 
are a little more complicated to implement.

The simplest way to create a card is the simply include the `card` component.

```html
<x-eloquent-ui::card>
    Card content
</x-eloquent-ui::card>
```

## Usage

A card component has a few slots and attributes that can be used to customize the card.

### Theme

Cards can be rendered in any theme colour. Add the `theme` attribute to the card component. The value of this 
attribute should be one of your theme colours, like `primary`, `danger` or `secondary`. By default, a card will be 
rendered without a theme.

```html
<x-eloquent-ui::card theme="primary">
    Card content
</x-eloquent-ui::card>
```

### Title

You can add a simple title to the card by adding the `title` attribute. This will render a heading tag inside the body 
element of the card with the correct classes and content.

```html
<x-eloquent-ui::card title="My title">
    Card content
</x-eloquent-ui::card>
```

#### Title customisation

By default, the title will be rendered as a `h3` heading tag. You can change this by adding the `title-size` attribute. 
The value of this attribute should be a number between `1` and `6`.

```html
<x-eloquent-ui::card title="My title" title-size="4">
    Card content
</x-eloquent-ui::card>
```

#### Title class

If you cant to add additional classes to the title, you can use the `title-class` attribute. The value of this 
attribute should be a space-separated list of classes.

```html
<x-eloquent-ui::card title="My title" title-class="mb-3 text-center">
    Card content
</x-eloquent-ui::card>
```

### Header

You can add a header to the card by adding the `header` slot. This will render a header tag inside the card element.

:::warning[Slot]
It is important that you use a slot to add a header and not just an attribute since the component will also try to render
any attributes you add to the slot.
:::

```html
<x-eloquent-ui::card>
    <x-slot:header>My header</x-slot:header>
</x-eloquent-ui::card>
```

#### Header attributes

You can add any attributes to the header slot. These will be added to the header tag, including the `class` attribute.

```html
<x-eloquent-ui::card>
    <x-slot:header class="p-3 text-end">My header</x-slot:header>
</x-eloquent-ui::card>
```

### Footer

You can add a header to the card by adding the `footer` slot. This will render a footer tag inside the card element.

:::warning[Slot]
It is important that you use a slot to add a footer and not just an attribute since the component will also try to render
any attributes you add to the slot.
:::

```html
<x-eloquent-ui::card>
    <x-slot:footer>My footer</x-slot:footer>
</x-eloquent-ui::card>
```

#### Footer attributes

You can add any attributes to the footer slot. These will be added to the footer tag, including the `class` attribute.

```html
<x-eloquent-ui::card>
    <x-slot:footer class="p-3 text-end">My footer</x-slot:footer>
</x-eloquent-ui::card>
```

### Body

You can customise the body of the card by adding the `body-class` attribute. The value of this attribute should be a 
space-separated list of classes that will be applied to the body element.

```html
<x-eloquent-ui::card body-class="p-5 text-warning">
    My card
</x-eloquent-ui::card>
```

## Backend

The card component does not provide any custom backend logic.

## Advanced usage

Like with other components, you can pass any attributes to the card component. These will be added to the card element.

### Custom cards

If you want more control over how the card is built and what components are used, the Card component does provide 
separate components for the individual elements of a card. See the [Custom Cards](custom.md) section for more 
information.