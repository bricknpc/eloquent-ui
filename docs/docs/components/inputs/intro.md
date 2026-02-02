---
sidebar_position: 1
title: Intro
---

# Inputs Overview

All input components are located in the `input` namespace.

```html
<x-eloquent-ui::input.type-here />
```

## Labels

By default, input components have no labels added to them. You can add labels to any input component by wrapping it in 
a [Row](../form/row) component.

```html
<!-- Without label -->
<x-eloquent-ui::input.currency />

<!-- With label -->
<x-eloquent-ui::form.row>
    <x-eloquent-ui::input.currency />
</x-eloquent-ui::form.row>
```