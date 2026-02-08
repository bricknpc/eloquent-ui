---
sidebar_position: 1
title: Intro
description: Buttons are simple components that can be added to forms or as standalone elements.
---

# Buttons Intro

Buttons are simple components that can be added to forms or as standalone elements. In its simplest form, a button 
only needs a name and a type.

```html
<x-aloquent-ui::button name="save" type="submit">Save</x-aloquent-ui::button>
```

## Usage

Buttons have a few options that can be useful when combined with other components and a few options adopted from the 
Bootstrap framework.

### Theme

You can change the theme of a button by adding a `theme` attribute. The value of this attribute should be one of your 
Bootstrap theme colours like `primary`, `secondary` or `danger`. By default, all buttons use the primary theme.
Outline themes like `outline-primary`, `outline-danger`, etc, can also be used.

```html
<x-eloquent-ui::button name="save" type="submit" theme="outline-secondary">Save</x-eloquent-ui::button>
```

### No wrap

Bootstrap offers a way to stop text wrapping in buttons. You can add the `no-wrap` attribute to a button to enable this.

```html
<x-eloquent-ui::button name="save" type="submit" no-wrap="true">Save</x-eloquent-ui::button>
```

### Disabled and readonly

Buttons can be disabled or readonly by adding the `disabled` or `readonly` attributes respectively. This will also set 
the correct `aria` attributes to the element.

```html
<x-eloquent-ui::button name="save" type="submit" disabled="true">Save</x-eloquent-ui::button>

<x-eloquent-ui::button name="save" type="submit" readonly="true">Save</x-eloquent-ui::button>
```

### Toggle

You can turn the button into a toggle button by adding the `toggle` attribute. To set a button as toggled, add the 
`pressed` attribute.

```html
<x-eloquent-ui::button name="save" type="submit" toggle="true">Save</x-eloquent-ui::button><!-- Toggle button -->

<x-eloquent-ui::button name="save" type="submit" toggle="true" pressed="true">Save</x-eloquent-ui::button><!-- Active toggle button -->
```

### Offset

When using buttons in combination with a form that has labels on the start of the row, you can add the `offset` 
attribute to the button to offset it from its container by the same number of columns as the label width.

```html
<x-eloquent-ui::button name="save" type="submit" offset="3">Save</x-eloquent-ui::button>
```

### Once

Often when a button is part of a form or has some sort of action attached to it that should only be executed once, 
you want the button to become disabled after it's been clicked. You can do this by adding the `once` attribute to the 
button. This will disable the button after it's been clicked once.

```html
<x-eloquent-ui::button name="save" type="submit" once="true">Save</x-eloquent-ui::button>
```

## Features

### Aliases

To help you write more semantic code, there are a number of aliases for the button themes available. These aliases will 
set the correct theme for you without the need of having to set it yourself. The aliases are available as follows:

```html
<x-eloquent-ui::button.secondary name="save" type="submit">Save</x-eloquent-ui::button.secondary> <!-- Secondary themed button -->
<x-eloquent-ui::button.outline-dark name="save" type="submit">Save</x-eloquent-ui::button.outline-dark> <!-- Outline dark themed button -->
```

The aliases that are available are:

- `primary`
- `secondary`
- `tertiary`
- `quarternary`
- `success`
- `danger`
- `warning`
- `error`
- `info`
- `light`
- `dark`
- `outline-primary`
- `outline-secondary`
- `outline-tertiary`
- `outline-quarternary`
- `outline-success`
- `outline-danger`
- `outline-warning`
- `outline-error`
- `outline-info`
- `outline-light`
- `outline-dark`

### Submit buttons

To help you write more semantic code, there is also an alias for the `submit` button type. This alias will set 
the correct type for you without the need of having to set it yourself. The alias is available as follows:

```html
<x-eloquent-ui::button.submit name="save">Save</x-eloquent-ui::button.submit>
```

Just like the normal button, this version also has different theme aliases.

```html
<x-eloquent-ui::button.submit.secondary name="save">Save</x-eloquent-ui::button.submit.secondary> <!-- Secondary themed submit button -->
<x-eloquent-ui::button.submit.outline-dark name="save">Save</x-eloquent-ui::button.submit.outline-dark> <!-- Outline dark themed submit button -->
```

The aliases that are available are:

- `primary`
- `secondary`
- `tertiary`
- `quarternary`
- `success`
- `danger`
- `warning`
- `error`
- `info`
- `light`
- `dark`
- `outline-primary`
- `outline-secondary`
- `outline-tertiary`
- `outline-quarternary`
- `outline-success`
- `outline-danger`
- `outline-warning`
- `outline-error`
- `outline-info`
- `outline-light`
- `outline-dark`

### Reset buttons

To help you write more semantic code, there is also an alias for the `reset` button type. This alias will set
the correct type for you without the need of having to set it yourself. The alias is available as follows:

```html
<x-eloquent-ui::button.reset name="reset">Reset</x-eloquent-ui::button.reset>
```

Just like the normal button, this version also has different theme aliases.

```html
<x-eloquent-ui::button.reset.secondary name="reset">Reset</x-eloquent-ui::button.reset.secondary> <!-- Secondary themed reset button -->
<x-eloquent-ui::button.reset.outline-dark name="reset">Reset</x-eloquent-ui::button.reset.outline-dark> <!-- Outline dark themed reset button -->
```

The aliases that are available are:

- `primary`
- `secondary`
- `tertiary`
- `quarternary`
- `success`
- `danger`
- `warning`
- `error`
- `info`
- `light`
- `dark`
- `outline-primary`
- `outline-secondary`
- `outline-tertiary`
- `outline-quarternary`
- `outline-success`
- `outline-danger`
- `outline-warning`
- `outline-error`
- `outline-info`
- `outline-light`
- `outline-dark`

## Advanced Usage

You can add any custom HTML attributes you want to a button, including classes, and it will be rendered on the button 
element.

```html
<x-aloquent-ui::button name="save" type="submit" class="btn btn-lg" data-custom="value">Save</x-aloquent-ui::button>
```