---
sidebar_position: 9
title: Password
description: The password input component.
---

# Password

The password input component is an alias of the [Text](text) input component with the `type` set to `password`.

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