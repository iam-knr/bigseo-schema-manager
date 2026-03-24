<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

return array(
    array(
        'key' => '@type',
        'label' => 'Type',
        'type' => 'hidden',
        'default' => 'FAQPage',
        'required' => true,
    ),
    array(
        'key' => 'mainEntity',
        'label' => 'FAQ Items',
        'type' => 'repeater',
        'required' => true,
        'help' => 'Add your frequently asked questions and answers',
        'fields' => array(
            array(
                'key' => 'question',
                'label' => 'Question',
                'type' => 'text',
                'placeholder' => 'What is your question?',
                'required' => true,
            ),
            array(
                'key' => 'answer',
                'label' => 'Answer',
                'type' => 'textarea',
                'placeholder' => 'Your answer here',
                'required' => true,
            ),
        ),
    ),
);
