<?php

declare(strict_types=1);

use BrickNPC\EloquentUI\Enums\LabelPosition;

return [
    /*
     * Some components use data attributes to store state. This option allows you to change the namespace used for those
     * in case there are conflicts with other libraries.
     */
    'data-namespace' => 'eloquent-ui',
    /*
     * Currency formatting configuration
     */
    'decimal-separator'   => ',',
    'thousands-separator' => '.',

    /*
     * Input configuration
     * ==================================================
     *
     * Configuration options for the input components.
     */
    'input' => [
        /*
         * The default position of the label relative to the input. Can be overridden on a per-input basis.
         */
        'position' => LabelPosition::Left,
        /*
         * The default style to use for the required input marker. The style should be a Bootstrap 5 theme colour, like
         * primary, secondary, success, danger, warning, info, light, or dark. If you have a custom theme, you can use
         * that as well.
         */
        'required-style' => 'danger',
        /*
         * The default style to use for buttons that are part of input elements. The style should be a Bootstrap 5
         * theme colour, like primary, secondary, success, danger, warning, info, light, or dark. If you have a custom
         * theme, you can use that as well. Outline styles will also work for this.
         */
        'button-style' => 'outline-secondary',
        /*
         * The default style to use for prefix and suffix backgrounds that are part of input elements. The style should
         * be a Bootstrap 5 theme colour, like primary, secondary, success, danger, warning, info, light, or dark. If
         * you have a custom theme, you can use that as well.
         */
        'addon-style' => 'secondary',
        /*
         * The default style to use for prefix and suffix buttons that are part of input elements. The style should
         * be a Bootstrap 5 theme colour, like primary, secondary, success, danger, warning, info, light, or dark. If
         * you have a custom theme, you can use that as well. Outline styles will also work for this.
         */
        'addon-button-style' => 'secondary',
        /*
         * The icon displayed next to required fields. Can be any stringable value, like an HTML entity or an icon.
         */
        'required-icon' => '*',
        /*
         * The number of columns to use for the label when the label is to the left or the right of the input.
         */
        'label-width' => 3,
        /*
         * The default classes to apply to the row containing the label and input.
         */
        'row-class' => 'mb-3',

        /*
         * Currency input configuration
         * ==================================================
         *
         * Configuration options for the currency input component.
         */
        'currency' => [
            /*
             * The symbol to use for the currency when no currency is selected.
             */
            'generic-symbol' => '¤',
            /*
             * When set to true, typing a comma (,) or a dot (.) in the whole part of the currency input will switch
             * the focus to the cent part.
             */
            'focus-switch' => true,
        ],

        /*
         * Password input configuration
         * ==================================================
         *
         * Configuration options for the password input component.
         */
        'password' => [
            /*
             * When set to true, adds an icon to the input that allows the user to switch between password and text
             * input.
             */
            'allow-type-switch' => 'true',
            /*
             * The icon to use for the type switch.
             */
            'switch-icon' => '👁',
        ],
    ],
];
