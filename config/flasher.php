<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

return array(
    'default' => 'toastr',

    'plugins' => [
        'toastr' => [
            'scripts' => [
                '/vendor/flasher/jquery.min.js',
                '/vendor/flasher/toastr.min.js',
                '/vendor/flasher/flasher-toastr.min.js',
            ],
            'styles' => [
                '/vendor/flasher/toastr.min.css',
            ],
            'options' => [
                // Optional: Add global options here
                'closeButton' => true
            ],
        ],
    ],

    'auto_translate' => true,

    'auto_render' => true,

    'filter_criteria' => array(
        'limit' => 5, // Limit the number of notifications to display
    ),
);
