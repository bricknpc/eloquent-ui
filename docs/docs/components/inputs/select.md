---
sidebar_position: 4
title: Select / Dropdown
description: The select component adds a select input to your form.
---

# Select / Dropdown

Select and Dropdown components are aliases and behave the same. For this documentation, we will use `select`, but note 
that anywhere we use `<x-eloquent-ui::input.select>` you can use `<x-eloquent-ui::input.dropdown>` as well.

A select component in its most basic form only needs a name and options.

```html
<x-eloquent-ui::input.select name="color" :options="['#f00' => 'Red', '#0f0' => 'Green', '#00f' => 'Blue']" />
```

## Usage

### Options

### Prepend empty

When the component is not marked as required, it will automatically prepend an empty option to the list of options no 
matter how the options are defined. You can disable this behaviour by setting the `prepend-empty` attribute to `false`.

```html
<x-eloquent-ui::input.select name="color" :options="[]" prepend-empty="false" />
```

## Features

### Model binding

### Render using

## Backend

Select or dropdown components do not provide any custom backend logic. All default Laravel validation rules can be used 
to validate select or dropdown components.

## Advanced usage