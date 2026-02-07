---
sidebar_position: 1
title: Intro
---

# Inputs Overview

All input components are located in the `input` namespace.

```html
<x-eloquent-ui::input.component-name />
```

## Labels

There are two ways to add labels to input components. You can either create it yourself by using the [Row](../form/row.md) 
component, or you can use the `label` attribute on the input component which will internally use the [Row](../form/row.md) 
component as well.

Wrapping the input component in a [Row](../form/row.md) component yourself gives you some more control over the input, 
but in most cases won't be necessary.

```html
<!-- Input without any label -->
<x-eloquent-ui::input.currency />

<!-- With a label using the Row component -->
<x-eloquent-ui::form.row>
    <x-eloquent-ui::input.currency />
</x-eloquent-ui::form.row>

<!-- With a label using the label attribute -->
<x-eloquent-ui::input.currency label="Currency" />
```

## Label customisation

The [Row](../form/row.md) component has a number of different options for customising the label. You can add any of these 
options on the input component as well when using the `label` attribute. You can also set them on the 
[Form](../form/form.md) component. See their respective documentation for more information.

## Eloquent models

If you provide an Eloquent model to the Form component the input is part of, the input will 
automatically try to get the value from the model. You can override this behaviour by providing a `valueUsing` closure 
or by setting the `value` attribute.

```html
<!-- Using the valueUsing closure -->
<x-eloquent-ui::form :model="$model">
    <x-eloquent-ui::input.currency name="total_price" valueUsing="fn(Model $model, array $attributes) => $model->price" />
</x-eloquent-ui::form>

<!-- Using the value attribute -->
<x-eloquent-ui::form :model="$model">
    <x-eloquent-ui::input.currency name="total_price" value="100" />
</x-eloquent-ui::form>
```