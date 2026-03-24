<?php
/**
 * Article schema field definitions.
 *
 * @package BigSEO_Schema_Manager
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

return array(
    array(
        'key'         => '@type',
        'label'       => 'Type',
        'type'        => 'hidden',
        'default'     => 'Article',
        'required'    => true,
    ),
    array(
        'key'         => 'headline',
        'label'       => 'Headline',
        'type'        => 'text',
        'placeholder' => 'Article title',
        'required'    => true,
        'auto_fill'   => 'post_title',
        'help'        => 'The headline of the article (max 110 characters recommended).',
    ),
    array(
        'key'         => 'description',
        'label'       => 'Description',
        'type'        => 'textarea',
        'placeholder' => 'Brief description of the article',
        'required'    => false,
        'auto_fill'   => 'post_excerpt',
        'help'        => 'A short summary of the article.',
    ),
    array(
        'key'         => 'image',
        'label'       => 'Image URL',
        'type'        => 'url',
        'placeholder' => 'https://example.com/image.jpg',
        'required'    => true,
        'auto_fill'   => 'featured_image',
        'help'        => 'URL of the article\'s featured image (min 696px wide).',
    ),
    array(
        'key'         => 'author',
        'label'       => 'Author',
        'type'        => 'object',
        'required'    => true,
        'fields'      => array(
            array(
                'key'         => '@type',
                'label'       => 'Author Type',
                'type'        => 'select',
                'options'     => array( 'Person', 'Organization' ),
                'default'     => 'Person',
                'required'    => true,
            ),
            array(
                'key'         => 'name',
                'label'       => 'Author Name',
                'type'        => 'text',
                'placeholder' => 'John Doe',
                'required'    => true,
                'auto_fill'   => 'author_name',
            ),
        ),
    ),
    array(
        'key'         => 'publisher',
        'label'       => 'Publisher',
        'type'        => 'object',
        'required'    => true,
        'fields'      => array(
            array(
                'key'         => '@type',
                'label'       => 'Publisher Type',
                'type'        => 'hidden',
                'default'     => 'Organization',
                'required'    => true,
            ),
            array(
                'key'         => 'name',
                'label'       => 'Publisher Name',
                'type'        => 'text',
                'placeholder' => 'Example Publisher',
                'required'    => true,
                'auto_fill'   => 'site_name',
            ),
            array(
                'key'         => 'logo',
                'label'       => 'Publisher Logo',
                'type'        => 'object',
                'required'    => true,
                'fields'      => array(
                    array(
                        'key'         => '@type',
                        'label'       => 'Logo Type',
                        'type'        => 'hidden',
                        'default'     => 'ImageObject',
                        'required'    => true,
                    ),
                    array(
                        'key'         => 'url',
                        'label'       => 'Logo URL',
                        'type'        => 'url',
                        'placeholder' => 'https://example.com/logo.png',
                        'required'    => true,
                        'auto_fill'   => 'site_logo',
                        'help'        => 'Publisher logo (600x60px recommended).',
                    ),
                ),
            ),
        ),
    ),
    array(
        'key'         => 'datePublished',
        'label'       => 'Date Published',
        'type'        => 'datetime',
        'required'    => true,
        'auto_fill'   => 'post_date',
        'help'        => 'ISO 8601 format (e.g., 2024-01-15T10:30:00+00:00).',
    ),
    array(
        'key'         => 'dateModified',
        'label'       => 'Date Modified',
        'type'        => 'datetime',
        'required'    => false,
        'auto_fill'   => 'post_modified',
    ),
);
