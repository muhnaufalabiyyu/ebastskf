<?php

return [
    'disable' => env('CAPTCHA_DISABLE', false),
    'characters' => ['1','2','3','4','5','6','7','8','9'],
    'default' => [
        'length' => 6,
        'width' => 125,
        'height' => 55,
        'quality' => 90,
        'math' => false,
        'expire' => 60,
        'lines' => 0,
        'bgColor' => '#ffff',
        'fontColors' => ['#0000', '#0000', '#0000', '#0000', '#0000'],
        'encrypt' => false,
    ],
    'math' => [
        'length' => 9,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => true,
    ],

    'flat' => [
        'length' => 6,
        'width' => 160,
        'height' => 46,
        'quality' => 90,
        'lines' => 30,
        'bgImage' => false,
        'bgColor' => '#000',
        'fontColors' => ['#0000', '#0000', '#0000', '#0000', '#0000'],
        'contrast' => -5,
    ],
    'mini' => [
        'length' => 3,
        'width' => 60,
        'height' => 32,
    ],
    'inverse' => [
        'length' => 5,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'sensitive' => true,
        'angle' => 12,
        'sharpen' => 10,
        'blur' => 2,
        'invert' => true,
        'contrast' => -5,
    ]
];
