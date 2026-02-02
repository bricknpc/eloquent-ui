@php
    use function BrickNPC\EloquentUI\ns;

    $allowTypeSwitch ??= config('eloquent-ui.input.password.allow-type-switch', "true");
    if ($allowTypeSwitch === true) {
        $allowTypeSwitch = "true";
    } elseif ($allowTypeSwitch === false) {
        $allowTypeSwitch = "false";
    }

    $switchIcon ??= config('eloquent-ui.input.password.switch-icon', '👁');

    $switchAttribute = 'data-' . ns() . '-password-allow-switch';
    $iconAttribute = 'data-' . ns() . '-password-switch-icon';

    $attributes[$switchAttribute] = $allowTypeSwitch;
    $attributes[$iconAttribute] = $switchIcon;
@endphp
<x-eloquent-ui::input.text
    type="password"
    {{ $attributes->except(['allow-type-switch', 'switch-icon']) }}
/>