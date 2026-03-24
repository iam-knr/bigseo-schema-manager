<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

return array(
    array(
        'key' => '@type',
        'label' => 'Type',
        'type' => 'hidden',
        'default' => 'Person',
        'required' => true,
    ),
    array(
        'key' => 'name',
        'label' => 'Full Name',
        'type' => 'text',
        'placeholder' => 'John Doe',
        'required' => true,
        'help' => 'The person\'s full name',
    ),
    array(
        'key' => 'jobTitle',
        'label' => 'Job Title',
        'type' => 'text',
        'placeholder' => 'CEO',
        'required' => false,
    ),
    array(
        'key' => 'description',
        'label' => 'Description',
        'type' => 'textarea',
        'placeholder' => 'Bio or description',
        'required' => false,
    ),
    array(
        'key' => 'image',
        'label' => 'Photo URL',
        'type' => 'url',
        'placeholder' => 'https://example.com/photo.jpg',
        'required' => false,
    ),
    array(
        'key' => 'url',
        'label' => 'Website URL',
        'type' => 'url',
        'placeholder' => 'https://example.com',
        'required' => false,
    ),
    array(
        'key' => 'sameAs',
        'label' => 'Social Media URLs',
        'type' => 'repeater',
        'required' => false,
        'help' => 'Add social media profile URLs',
        'fields' => array(
            array(
                'key' => 'url',
                'label' => 'URL',
                'type' => 'url',
                'placeholder' => 'https://twitter.com/username',
                'required' => true,
            ),
        ),
    ),
);
