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

All input components have two variants: a version with a label that can be used in regular forms, and a version 
without a label that can be used anywhere or in case you want to add your own label.

The versions with a label have `-row` as a suffix to their name. The currency input, for instance, has these two 
variants:

```html
<!-- With label -->
<x-eloquent-ui::input.currency-row />

<!-- Without label -->
<x-eloquent-ui::input.currency />
```

### Label position

All labelled components have a `labelPosition` property that can be set to one of the 
`BrickNPC\EloquentUI\Enums\LabelPosition` values. The default value is set in the configuration file, but it can be 
overridden on a per-component basis.

## Advanced usage

### Custom data attributes

Every input component supports custom data attributes. You can add as many data attributes as you want to any component,
and they will be added to the top most element of the component.

```html
<x-eloquent-ui::input.text data-custom-attribute="custom-value" />
```