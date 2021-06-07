<?php

return [
    'template' => [
        'content_placeholder' => 'content',
        'css_placeholder' => 'css',
        'js_placeholder' => 'js',
    ],
    'route' => [
        'prefix' => 'acl',
        'name_prefix' => 'acl.',
        'middleware' => ['web']
    ]
];
