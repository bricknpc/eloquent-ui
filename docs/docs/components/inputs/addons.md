---
sidebar_position: 99
title: Addons
description: Addons for input elements
---

# Addons

Addons are used for input elements to add extra content before or after the input. Addons are not meant to be 
used as standalone components.

```html
<x-eloquent-ui::input.text name="username">
    <x-slot:prefix id="username-prefix">
        <x-eloquent-ui::input.addon.text id="username-prefix" style="primary">@</x-eloquent-ui::input.addon.text>
    </x-slot:prefix>
</x-eloquent-ui::input.text>
```

## Usage

There are four types of addons:

- Text addons
- Button addons
- Link addons
- Dropdown addons

### Text addons

Text addons are meant for adding text or icons to the input.

```html
<x-eloquent-ui::input.text name="username">
    <x-slot:prefix id="username-prefix">
        <x-eloquent-ui::input.addon.text id="username-prefix" style="primary">@</x-eloquent-ui::input.addon.text>
    </x-slot:prefix>
</x-eloquent-ui::input.text>
```

#### Attributes

| Attribute | Type     | Required | Description                                                                                                        |
|-----------|----------|----------|--------------------------------------------------------------------------------------------------------------------|
| `id`      | `string` | Yes      | A unique identifier to the addons that also must be added to the slot to link the addon and input together.        |
| `style`   | `string` | No       | The style how the addon should be rendered. This should be one of your theme colours, like `primary` or `warning`. |

### Button addons

Button addons are meant for adding text or icons to the input same as the text addon, except that a button addon uses a
button element instead of a span.

```html
<x-eloquent-ui::input.text name="username">
    <x-slot:prefix id="username-prefix">
        <x-eloquent-ui::input.addon.btn id="username-prefix" style="primary">@</x-eloquent-ui::input.addon.btn>
    </x-slot:prefix>
</x-eloquent-ui::input.text>
```

#### Attributes

| Attribute | Type     | Required | Description                                                                                                                                                                       |
|-----------|----------|----------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `id`      | `string` | Yes      | A unique identifier to the addons that also must be added to the slot to link the addon and input together.                                                                       |
| `style`   | `string` | No       | The style how the addon should be rendered. This should be one of your theme colours, like `primary` or `warning`. Outline versions also work for this, like `outline-secondary`. |

### Link addons

Link addons are meant for adding links to the input.

```html
<x-eloquent-ui::input.text name="username">
    <x-slot:prefix id="username-prefix">
        <x-eloquent-ui::input.addon.link href="/users" id="username-prefix" style="primary">@</x-eloquent-ui::input.addon.link>
    </x-slot:prefix>
</x-eloquent-ui::input.text>
```

#### Attributes

| Attribute | Type     | Required | Description                                                                                                                                                                       |
|-----------|----------|----------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `id`      | `string` | Yes      | A unique identifier to the addons that also must be added to the slot to link the addon and input together.                                                                       |
| `href`    | `string` | Yes      | The link to open when clicked.                                                                                                                                                    |
| `style`   | `string` | No       | The style how the addon should be rendered. This should be one of your theme colours, like `primary` or `warning`. Outline versions also work for this, like `outline-secondary`. |

### Dropdown addons

Dropdown addons are not yet implemented.