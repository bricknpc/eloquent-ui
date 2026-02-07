---
sidebar_position: 4
title: Row
description: The row component provides a flexible way to layout your form.
---

# Row

The row component provides a flexible way to lay out your form. It adds a label to your input component as well. 

```html
<x-eloquent-ui::form.row for="email" label="Email">
    <x-eloquent-ui::input.text name="email" type="email" />
</x-eloquent-ui::form.row>
```

## Usage

In its simplest form, the row component only needs a `for` attribute to render it.

```html
<x-eloquent-ui::form.row for="email">
    <x-eloquent-ui::input.text name="email" type="email" />
</x-eloquent-ui::form.row>
```

:::note[Complicated input components]

Some of the more complicated input components render multiple input elements, so the `for` attribute on the row
component should sometimes be set to something else than the input component's `name` attribute. See the documentation
for the specific input component for more information.

Alternatively, you can use the `label-id` attribute on the input component to tell the component which label
describes it. The ID of the label is always the value of the `for` attribute on the row component followed by `-label`,
for example `email-label`.

:::

### Label

You can also specify a text for the label by adding a `label` attribute. If no label is provided, the row component uses 
the value of the `for` attribute in title case as the label.

```html
<x-eloquent-ui::form.row for="email" label="Email address">
    <x-eloquent-ui::input.text name="email" type="email" />
</x-eloquent-ui::form.row>
```

### Label position

The Row component lets you customise where the label is rendered compared to the input component. By default, the label
is rendered to the left of the input component. You can change the position by adding the `label-position` attribute 
to the row component. The value of this attribute should be one of the `BrickNPC\EloquentUI\Enums\LabelPosition` 
enum values.

```html
<x-eloquent-ui::form.row for="email" label="Email address" :label-position="BrickNPC\EloquentUI\Enums\LabelPosition::Top">
    <x-eloquent-ui::input.text name="email" type="email" />
</x-eloquent-ui::form.row>
```

```html
<x-eloquent-ui::form.row for="email" label="Email address" :label-position="BrickNPC\EloquentUI\Enums\LabelPosition::Bottom">
    <x-eloquent-ui::input.text name="email" type="email" />
</x-eloquent-ui::form.row>
```

### Required indicator

If a row component is used in combination with a required input component, you can add the `requried` attribute to 
the row component. This will render a visual indicator that the input is required, as well as add the necessary `aria-`
tags and visually hidden text to make it accessible.

```html
<x-eloquent-ui::form.row for="email" required>
    <x-eloquent-ui::input.text name="email" type="email" />
</x-eloquent-ui::form.row>
```

You can customise the required indicator by providing the `required-icon="*"` attribute. By default, the required 
indicator is an asterisk (`*`). You can also change the default value for this indicator in the config file to change 
it for all row components.

```html
<x-eloquent-ui::form.row for="email" required required-icon="!">
    <x-eloquent-ui::input.text name="email" type="email" />
</x-eloquent-ui::form.row>
```

You may also customise the style of the required indicator by adding the `required-style="danger"` attribute. The value 
of this attribute should be one of your theme colours, like `danger` or `primary`. By default, the required indicator 
is rendered as `danger`. You can also change the default value for this indicator in the config file to change it for 
all row components globally.

```html
<x-eloquent-ui::form.row for="email" required required-icon="!" required-style="warning">
    <x-eloquent-ui::input.text name="email" type="email" />
</x-eloquent-ui::form.row>
```

## Advanced usage

You can add any additional HTML attributes to the row component, including custom CSS classes. These will be added to 
the topmost HTML element of the component, which for this component is the row `div`.

```html
<div {{ $attributes->merge(['class' => 'row']) }}> <!-- This is where the attributes are added -->
```