<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

return array(
    array(
        'key' => '@type',
        'label' => 'Type',
        'type' => 'hidden',
        'default' => 'Product',
        'required' => true,
    ),
    array(
        'key' => 'name',
        'label' => 'Product Name',
        'type' => 'text',
        'placeholder' => 'Enter product name',
        'required' => true,
        'help' => 'The name of the product',
    ),
    array(
        'key' => 'description',
        'label' => 'Description',
        'type' => 'textarea',
        'placeholder' => 'Describe the product',
        'required' => true,
        'help' => 'Product description',
    ),
    array(
        'key' => 'image',
        'label' => 'Product Image URL',
        'type' => 'url',
        'placeholder' => 'https://example.com/image.jpg',
        'required' => false,
        'help' => 'URL of the product image',
    ),
    array(
        'key' => 'brand',
        'label' => 'Brand Name',
        'type' => 'text',
        'placeholder' => 'Brand',
        'required' => false,
        'help' => 'The brand of the product',
    ),
    array(
        'key' => 'offers',
        'label' => 'Price',
        'type' => 'group',
        'required' => false,
        'fields' => array(
            array(
                'key' => 'price',
                'label' => 'Price',
                'type' => 'text',
                'placeholder' => '29.99',
                'required' => true,
            ),
            array(
                'key' => 'priceCurrency',
                'label' => 'Currency',
                'type' => 'text',
                'placeholder' => 'USD',
                'required' => true,
            ),
            array(
                'key' => 'availability',
                'label' => 'Availability',
                'type' => 'select',
                'options' => array(
                    'InStock' => 'In Stock',
                    'OutOfStock' => 'Out of Stock',
                    'PreOrder' => 'Pre-Order',
                ),
                'required' => false,
            ),
        ),
    ),
    array(
        'key' => 'aggregateRating',
        'label' => 'Aggregate Rating',
        'type' => 'group',
        'required' => false,
        'fields' => array(
            array(
                'key' => 'ratingValue',
                'label' => 'Rating',
                'type' => 'number',
                'placeholder' => '4.5',
                'required' => true,
            ),
            array(
                'key' => 'reviewCount',
                'label' => 'Review Count',
                'type' => 'number',
                'placeholder' => '89',
                'required' => true,
            ),
        ),
    ),
);
