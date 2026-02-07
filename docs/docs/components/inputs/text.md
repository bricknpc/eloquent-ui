---
sidebar_position: 2
title: Text
description: The text input component.
---

# Template

The text input component creates an HTML text input element.

```html
<x-eloquent-ui::input.text name="username" />
```

## Usage

In its most basic form, the text component only needs a `name` attribute to render a working input field, including 
error handling and accessibility features. The ID of the input element is the same as the `name` attribute.

```html
<x-eloquent-ui::input.text name="username" />
```

### Type

By default, the input element is rendered as a `type="text"` input field. You can change this by setting the `type` 
attribute. The component supports all HTML input types.

```html
<x-eloquent-ui::input.text name="email" type="email" />

<x-eloquent-ui::input.text name="age" type="number" />

<x-eloquent-ui::input.text name="date" type="datetime-local" />
```

### Label

You can set the label of the input field by using the `label` attribute. This will internally wrap the input component
in a [Row](../form/row) component and open up all customisation options for the row.

```html
<x-eloquent-ui::input.text name="username" label="Username:" />
```

If you want to use a custom label, you can set the `label-id` attribute to the ID of the custom label. This will
automatically add the necessary `aria-labelledby` attribute to the input field.

```html
<label id="username-label" for="username">Username:</label>
<x-eloquent-ui::input.text name="username" label-id="username-label" />
```

### Required inputs

You can mark an input as required by setting the `required` attribute. This will automatically add the necessary `aria-` 
attributes to the input field.

```html
<x-eloquent-ui::input.text name="username" required />
```

### Disabled and readonly inputs

You can disable or make an input field readonly by setting the `disabled` or `readonly` attributes. This will 
automatically add the necessary `aria-` attributes to the input field.

```html
<x-eloquent-ui::input.text name="username" readonly />

<x-eloquent-ui::input.text name="username" disabled="disabled" />
```

### Hints

Hints are small texts that are displayed below the input field. They can be used to provide additional information or 
to display validation errors. You can add hints by using the `hint` attribute.

```html
<x-eloquent-ui::input.text name="username" hint="Please enter your username." />
```

### Other attributes

The text component supports all standard HTML attributes, like `placeholder`, `min`, `max`, `step`, `title`, `pattern`, 
etc. You can add any of these attributes to the component, and they will be rendered on the input element.

```html
<x-eloquent-ui::input.text name="username" title="Your username" pattern="[a-zA-Z0-9]+" placeholder="Choose a username." />
```

## Features

### Addons

You can add an addon to the left or right side of the input field by using the `prefix` or `suffix` slots. You are 
free to write your own addon markup, but Eloquent UI also provides a number of predefined addons for you to use. These 
predefined addons can be found in the `input.addon` namespace.

```html
<x-eloquent-ui::input.text name="username">
    <x-slot:prefix id="username-prefix">
        <x-eloquent-ui::input.addon.text id="username-prefix" style="primary">@</x-eloquent-ui::input.addon.text>
    </x-slot:prefix>
</x-eloquent-ui::input.text>
```

```html
<x-eloquent-ui::input.text name="website">
    <x-slot:suffix id="website-suffix">
        <x-eloquent-ui::input.addon.icon id="website-suffix">.com</x-eloquent-ui::input.addon.icon>
    </x-slot:suffix>
</x-eloquent-ui::input.text>
```
:::warning[Accessibility]
Both the prefix and suffix slots require a unique `id` attribute, which must be the same `id` as the addon itself. 
This is so that accessibility features like `aria-describedby` work correctly for things like screen readers.
:::

See the [addon documentation](addons) for more details about addons.

### Combining text inputs with rows

Like all other input components, the text component can be combined with the row component to create a more complex 
input field.

```html
<x-eloquent-ui::form.row for="username" label="Username" required>
    <x-eloquent-ui::input.text name="username" required>
</x-eloquent-ui::form.row>
```

See the [row documentation](../form/row) for more information.

## Backend logic

The text input component has no custom backend logic. All normal Laravel validation rules can be used with this 
component.

## Advanced usage

You can add custom `data-` attributes to the input element by adding them to the component. These attributes will be 
rendered on the input element.

```html
<x-eloquent-ui::input.text name="username" data-custom="custom-value" />
```