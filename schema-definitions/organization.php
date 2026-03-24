<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

return array(
    array(
        'key' => '@type',
        'label' => 'Type',
        'type' => 'hidden',
        'default' => 'Organization',
        'required' => true,
    ),
    array(
        'key' => 'name',
        'label' => 'Organization Name',
        'type' => 'text',
        'placeholder' => 'Company Name',
        'required' => true,
        'help' => 'The name of your organization',
    ),
    array(
        'key' => 'url',
        'label' => 'Website URL',
        'type' => 'url',
        'placeholder' => 'https://example.com',
        'required' => true,
        'help' => 'Your organization website',
    ),
    array(
        'key' => 'logo',
        'label' => 'Logo URL',
        'type' => 'url',
        'placeholder' => 'https://example.com/logo.png',
        'required' => false,
        'help' => 'URL of your organization logo',
    ),
    array(
        'key' => 'description',
        'label' => 'Description',
        'type' => 'textarea',
        'placeholder' => 'Describe your organization',
        'required' => false,
    ),
    array(
        'key' => 'address',
        'label' => 'Address',
        'type' => 'group',
        'required' => false,
        'fields' => array(
            array(
                'key' => 'streetAddress',
                'label' => 'Street Address',
                'type' => 'text',
                'placeholder' => '123 Main St',
                'required' => false,
            ),
            array(
                'key' => 'addressLocality',
                'label' => 'City',
                'type' => 'text',
                'placeholder' => 'San Francisco',
                'required' => false,
            ),
            array(
                'key' => 'addressRegion',
                'label' => 'State/Region',
                'type' => 'text',
                'placeholder' => 'CA',
                'required' => false,
            ),
            array(
                'key' => 'postalCode',
                'label' => 'Postal Code',
                'type' => 'text',
                'placeholder' => '94103',
                'required' => false,
            ),
            array(
                'key' => 'addressCountry',
                'label' => 'Country',
                'type' => 'text',
                'placeholder' => 'US',
                'required' => false,
            ),
        ),
    ),
    array(
        'key' => 'contactPoint',
        'label' => 'Contact Information',
        'type' => 'group',
        'required' => false,
        'fields' => array(
            array(
                'key' => 'telephone',
                'label' => 'Phone',
                'type' => 'text',
                'placeholder' => '+1-415-555-1234',
                'required' => false,
            ),
            array(
                'key' => 'contactType',
                'label' => 'Contact Type',
                'type' => 'select',
                'options' => array(
                    'customer support' => 'Customer Support',
                    'sales' => 'Sales',
                    'billing' => 'Billing',
                ),
                'required' => false,
            ),
        ),
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
                'placeholder' => 'https://facebook.com/yourpage',
                'required' => true,
            ),
        ),
    ),
);
