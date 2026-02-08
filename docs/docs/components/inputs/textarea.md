---
sidebar_position: 7
title: Textarea
description: A fully accessible textarea input component.
---

# Textarea

The textarea input component creates an HTML textarea element.

```html
<x-eloquent-ui::input.textarea name="username" />
```

## Usage

In its most basic form, the textarea component only needs a `name` attribute to render a working textarea field, 
including error handling and accessibility features. The ID of the element is the same as the `name` attribute.

```html
<x-eloquent-ui::input.textarea name="username" />
```

### Label

You can set the label of the textarea field by using the `label` attribute. This will internally wrap the input component
in a [Row](../form/row) component and open up all customisation options for the row.

```html
<x-eloquent-ui::input.textarea name="about" label="About:" />
```

If you want to use a custom label, you can set the `label-id` attribute to the ID of the custom label. This will
automatically add the necessary `aria-labelledby` attribute to the textarea field.

```html
<label id="about-label" for="about">About:</label>
<x-eloquent-ui::input.textarea name="about" label-id="about-label" />
```

### Required inputs

You can mark a textarea as required by setting the `required` attribute. This will automatically add the necessary 
`aria-` attributes to the textarea field and also the label if you use the `label` attribute.

```html
<x-eloquent-ui::input.textarea name="username" required />
```

### Disabled and readonly inputs

You can disable or make the textarea readonly by setting the `disabled` or `readonly` attributes. This will
automatically add the necessary `aria-` attributes to the textarea.

```html
<x-eloquent-ui::input.textarea name="about" readonly />

<x-eloquent-ui::input.textarea name="about" disabled="disabled" />
```

### Hints

Hints are small texts that are displayed below the textarea. They can be used to provide additional information about 
the input. You can add hints by using the `hint` attribute.

```html
<x-eloquent-ui::input.textarea name="about" hint="Tell us about yourself." />
```

### Other attributes

The textarea component supports all standard HTML attributes, like `placeholder`, `title`, etc. You can add any of these 
attributes to the component, and they will be rendered on the textarea element.

```html
<x-eloquent-ui::input.textarea name="about" title="About you" placeholder="Tell us about yourself." />
```

## Features

### Combining text inputs with rows

Like all other input components, the textarea component can be combined with the row component to create a more complex
input field.

```html
<x-eloquent-ui::form.row for="about" label="About you:" required>
    <x-eloquent-ui::input.textarea name="about" required>
</x-eloquent-ui::form.row>
```

See the [row documentation](../form/row) for more information.

## Backend logic

The textarea input component has no custom backend logic. All normal Laravel validation rules can be used with this
component.

## Advanced usage

You can add custom `data-` attributes to the textarea element by adding them to the component. These attributes will be
rendered on the input element.

```html
<x-eloquent-ui::input.textarea name="about" data-custom="custom-value" />
```