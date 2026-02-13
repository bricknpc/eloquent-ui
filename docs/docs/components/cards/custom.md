---
sidebar_position: 2
title: Custom cards
description: Custom cards in Eloquent UI
---

# Custom cards

While the regular Card component covers most of the simple use cases, you can also create custom cards by using the 
individual card components. This is basically the same as just using the Bootstrap classes except with a 
different syntax.

## Usage

### Empty card

Every card you create should be wrapped in an empty `.card` element. You can do this by using the 
`<x-eloquent-ui::card.empty></x-eloquent-ui::card.empty>` component. This will simply be rendered as 
`<div class="card"></div>`.

```html
<x-eloquent-ui::card.empty>
    <!-- Card content elements -->
</x-eloquent-ui::card.empty>
```

### Header

To add a header to your card, use the `<x-eloquent-ui::card.header></x-eloquent-ui::card.header>` component.

```html
<x-eloquent-ui::card.empty>
    <x-eloquent-ui::card.header>Header</x-eloquent-ui::card.header>
    <!-- Card content elements -->
</x-eloquent-ui::card.empty>
```

You can add any attribute to the header element, like `class` or `style`, and it will be applied to the header element.

### Footer

To add a footer to your card, use the `<x-eloquent-ui::card.footer></x-eloquent-ui::card.footer>` component.

```html
<x-eloquent-ui::card.empty>
    <x-eloquent-ui::card.footer>Footer</x-eloquent-ui::card.footer>
    <!-- Card content elements -->
</x-eloquent-ui::card.empty>
```

You can add any attribute to the footer element, like `class` or `style`, and it will be applied to the footer element.

### Body

To add a body to your card, use the `<x-eloquent-ui::card.body></x-eloquent-ui::card.body>` component.

```html
<x-eloquent-ui::card.empty>
    <x-eloquent-ui::card.body>Body</x-eloquent-ui::card.body>
    <!-- Card content elements -->
</x-eloquent-ui::card.empty>
```

You can add any attribute to the body element, like `class` or `style`, and it will be applied to the body element.

### Title

To add a title to your card, use the `<x-eloquent-ui::card.title></x-eloquent-ui::card.title>` component.

```html
<x-eloquent-ui::card.empty>
    <x-eloquent-ui::card.title>Title</x-eloquent-ui::card.title>
    <!-- Card content elements -->
</x-eloquent-ui::card.empty>
```

You can add any attribute to the title element, like `class` or `style`, and it will be applied to the title element.

#### Size

By default, a card title is rendered as a `h3` element. You can change this by adding the `level` attribute to the 
component. This will change the `h` element to the specified level.

### Subtitle

To add a subtitle to your card, use the `<x-eloquent-ui::card.subtitle></x-eloquent-ui::card.subtitle>` component.

```html
<x-eloquent-ui::card.empty>
    <x-eloquent-ui::card.title>Title</x-eloquent-ui::card.title>
    <x-eloquent-ui::card.subtitle>Subtitle</x-eloquent-ui::card.subtitle>
    <!-- Card content elements -->
</x-eloquent-ui::card.empty>
```

You can add any attribute to the subtitle element, like `class` or `style`, and it will be applied to the subtitle 
element.

#### Size

By default, a card subtitle is rendered as a `h5` element. You can change this by adding the `level` attribute to the
component. This will change the `h` element to the specified level.

### List group

To add a list group to your card, use the `<x-eloquent-ui::card.list-body></x-eloquent-ui::card.list-body>` component.

```html
<x-eloquent-ui::card.empty>
    <x-eloquent-ui::card.list-body>
        <!-- List group elements -->
    </x-eloquent-ui::card.list-body>
</x-eloquent-ui::card.empty>
```

You can add any attribute to the list body element, like `class` or `style`, and it will be applied to the list group 
element.

#### List items

To add items to you list group, use the `<x-eloquent-ui::card.list-item></x-eloquent-ui::card.list-item>` component.

```html
<x-eloquent-ui::card.empty>
    <x-eloquent-ui::card.list-body>
        <x-eloquent-ui::card.list-item>Item</x-eloquent-ui::card.list-item>
        <x-eloquent-ui::card.list-item>Item</x-eloquent-ui::card.list-item>
    </x-eloquent-ui::card.list-body>
</x-eloquent-ui::card.empty>
```

You can add any attribute to the list item element, like `class` or `style`, and it will be applied to the list item
element.

### Image

To add an image to your card, use the `<x-eloquent-ui::card.image></x-eloquent-ui::card.image>` component.

```html
<x-eloquent-ui::card.empty>
    <x-eloquent-ui::card.image />
</x-eloquent-ui::card.empty>
```

You can add any attribute to the image element, like `class` or `style`, and it will be applied to the image
element.

#### Attributes

The image component supports the following attributes:

| Attribute  | Required | Description                                                                                                    |
|------------|----------|----------------------------------------------------------------------------------------------------------------|
| `src`      | Yes      | The `src` for the image element.                                                                               |
| `alt`      | No       | The `alt` tag for the image element.                                                                           |
| `location` | No       | The location of the image, like `top` or `bottom`. This is added to the `.card-img-` class. Defaults to `top`. |


### Text and links

These are helper components that add `.card-text` and `.card-link` elements.

```html
<x-eloquent-ui::card.empty>
    <x-eloquent-ui::card.body>
        <x-eloquent-ui::card.text>Text</x-eloquent-ui::card.text>
        <x-eloquent-ui::card.link href="#">Link</x-eloquent-ui::card.link>
    </x-eloquent-ui::card.body>
</x-eloquent-ui::card.empty>
```

## Backend

There are no backend components for custom cards.