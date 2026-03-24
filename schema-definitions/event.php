<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

return array(
    array(
        'key' => '@type',
        'label' => 'Type',
        'type' => 'hidden',
        'default' => 'Event',
        'required' => true,
    ),
    array(
        'key' => 'name',
        'label' => 'Event Name',
        'type' => 'text',
        'placeholder' => 'My Event',
        'required' => true,
        'help' => 'The name of the event',
    ),
    array(
        'key' => 'description',
        'label' => 'Description',
        'type' => 'textarea',
        'placeholder' => 'Event description',
        'required' => true,
    ),
    array(
        'key' => 'startDate',
        'label' => 'Start Date',
        'type' => 'datetime',
        'placeholder' => 'YYYY-MM-DD HH:MM',
        'required' => true,
        'help' => 'When the event starts',
    ),
    array(
        'key' => 'endDate',
        'label' => 'End Date',
        'type' => 'datetime',
        'placeholder' => 'YYYY-MM-DD HH:MM',
        'required' => false,
        'help' => 'When the event ends',
    ),
    array(
        'key' => 'location',
        'label' => 'Location',
        'type' => 'group',
        'required' => true,
        'fields' => array(
            array(
                'key' => 'name',
                'label' => 'Venue Name',
                'type' => 'text',
                'placeholder' => 'Convention Center',
                'required' => true,
            ),
            array(
                'key' => 'address',
                'label' => 'Address',
                'type' => 'text',
                'placeholder' => '123 Main St, City, State',
                'required' => false,
            ),
        ),
    ),
    array(
        'key' => 'offers',
        'label' => 'Ticket Information',
        'type' => 'group',
        'required' => false,
        'fields' => array(
            array(
                'key' => 'price',
                'label' => 'Price',
                'type' => 'text',
                'placeholder' => '50.00',
                'required' => false,
            ),
            array(
                'key' => 'priceCurrency',
                'label' => 'Currency',
                'type' => 'text',
                'placeholder' => 'USD',
                'required' => false,
            ),
            array(
                'key' => 'url',
                'label' => 'Ticket URL',
                'type' => 'url',
                'placeholder' => 'https://example.com/tickets',
                'required' => false,
            ),
        ),
    ),
);
