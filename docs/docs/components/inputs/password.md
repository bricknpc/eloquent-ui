---
sidebar_position: 4
title: Password
description: The password input component.
---

# Password

The password input component is an alias of the [Text](text) input component with the `type` set to `password` and a 
few extra features.

```html
<x-eloquent-ui::input.password name="my-name" />
```

## Switch between password and text

By default, password inputs have a toggle icon to switch between password and text. This allows users to check their 
password. You can disable this behaviour by adding the `allow-type-switch` attribute to the component. You can also 
disable the toggle functionality by setting it in the config.

```html
<x-eloquent-ui::input.password name="my-name" allow-type-switch="false" />
```

You can also change what icon is used for the toggle by setting the `switch-icon` attribute. This icon can also be 
set in the config.

```html
<x-eloquent-ui::input.password name="my-name" switch-icon="◉" />
```

## With confirmation

Often when creating a password or updating a password, you may want to add a second input to confirm the password. 
You can do this by adding the `confirm` attribute to the component. This will add a second password input below the 
first with the same name with `_confirmation` appended to it. You can use this directly with Laravel's `confirmed` 
validation rule.

Setting this attribute will also automatically disable the toggle functionality between password and text.

```html
<x-eloquent-ui::input.password name="my-name" confirm="true" />
```

:::info[UX Best Practices]
Most UX guidelines recommend that you don't require users to confirm their password but instead use the password toggle 
to allow users to check their password. We only add this option here because Laravel still supports the `confirmed` 
validation rule.
:::

:::warning[Experimental]
You should treat the `confirm` attribute as experimental. It may change or be removed in the future.
:::

## Model values

Since passwords are stored as hashes in the database, the password input will not automatically try to get the value 
from the Eloquent model if it is set on the form. Therefore, it also does not support the `valueUsing` attribute or 
the `value` attribute.