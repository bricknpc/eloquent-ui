<?php

declare(strict_types=1);

use BrickNPC\EloquentUI\Enums\Position;

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
         * The default position of the label relative to the input. Can be overridden on a per-field basis.
         */
        'position' => Position::Left,
        /*
         * The default style to use for required fields. The style should be a Bootstrap 5 theme colour, like primary,
         * secondary, success, danger, warning, info, light, or dark. If you have a custom theme, you can use that as
         * well.
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
        'addon-style' => 'outline-secondary',
        /*
         * The icon displayed next to required fields. Can be any stringable value, like an HTML entity or an icon.
         */
        'required-icon'  => '*',

        /*
         * Currency input configuration
         */
        'currency' => [
            'generic-symbol' => '¤',
        ],
    ],
];
