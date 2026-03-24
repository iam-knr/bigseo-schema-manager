<?php
/**
 * BreadcrumbList Schema Definition
 * 
 * @package BigSEO_Schema_Manager
 */

if (!defined('ABSPATH')) {
    exit;
}

return [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        'type' => 'array',
        'items' => [
            'position' => [
                'type' => 'number',
                'label' => 'Position',
                'required' => true
            ],
            'name' => [
                'type' => 'text',
                'label' => 'Name',
                'required' => true
            ],
            'item' => [
                'type' => 'url',
                'label' => 'URL',
                'required' => true
            ]
        ]
    ]
];
