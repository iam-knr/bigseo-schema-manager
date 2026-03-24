<?php
/**
 * Master registry of all supported Schema.org types and their field definitions.
 * Acts as the single source of truth for the entire plugin.
 *
 * @package    BigSEO_Schema_Manager
 * @subpackage BigSEO_Schema_Manager/includes
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class BigSEO_Schema_Types {

    /**
     * Returns the complete list of all supported schema types.
     *
     * @return array Associative array keyed by schema type slug.
     * @since 1.0.0
     */
    public static function get_all_types() {
        return array(
            // Content Types
            'article'           => array( 'label' => 'Article',           'category' => 'Content' ),
            'blogposting'       => array( 'label' => 'Blog Posting',      'category' => 'Content' ),
            'newsarticle'       => array( 'label' => 'News Article',      'category' => 'Content' ),
            'webpage'           => array( 'label' => 'Web Page',          'category' => 'Content' ),
            
            // Business Types
            'localbusiness'     => array( 'label' => 'Local Business',    'category' => 'Business' ),
            'organization'      => array( 'label' => 'Organization',      'category' => 'Business' ),
            'restaurant'        => array( 'label' => 'Restaurant',        'category' => 'Business' ),
            'store'             => array( 'label' => 'Store',             'category' => 'Business' ),
            
            // Products & Offers
            'product'           => array( 'label' => 'Product',           'category' => 'E-commerce' ),
            'offer'             => array( 'label' => 'Offer',             'category' => 'E-commerce' ),
            'aggregateoffer'    => array( 'label' => 'Aggregate Offer',   'category' => 'E-commerce' ),
            
            // Reviews & Ratings
            'review'            => array( 'label' => 'Review',            'category' => 'Reviews' ),
            'aggregaterating'   => array( 'label' => 'Aggregate Rating',  'category' => 'Reviews' ),
            
            // Events
            'event'             => array( 'label' => 'Event',             'category' => 'Events' ),
            
            // Media
            'videoobject'       => array( 'label' => 'Video Object',      'category' => 'Media' ),
            'imageobject'       => array( 'label' => 'Image Object',      'category' => 'Media' ),
            'audioobject'       => array( 'label' => 'Audio Object',      'category' => 'Media' ),
            
            // People & Identity
            'person'            => array( 'label' => 'Person',            'category' => 'People' ),
            'profilepage'       => array( 'label' => 'Profile Page',      'category' => 'People' ),
            
            // Knowledge
            'faqpage'           => array( 'label' => 'FAQ Page',          'category' => 'Knowledge' ),
            'howto'             => array( 'label' => 'How-To',            'category' => 'Knowledge' ),
            'course'            => array( 'label' => 'Course',            'category' => 'Knowledge' ),
            'recipe'            => array( 'label' => 'Recipe',            'category' => 'Knowledge' ),
            
            // Technical
            'breadcrumblist'    => array( 'label' => 'Breadcrumb List',   'category' => 'Technical' ),
            'website'           => array( 'label' => 'Website',           'category' => 'Technical' ),
            
            // Jobs
            'jobposting'        => array( 'label' => 'Job Posting',       'category' => 'Jobs' ),
        );
    }

    /**
     * Returns the field definition array for a specific schema type.
     *
     * @param string $type Schema type slug (e.g., 'article', 'localbusiness').
     * @return array|null Field configuration array or null if type doesn't exist.
     * @since 1.0.0
     */
    public static function get_fields( $type ) {
        $file = BIGSEO_SCHEMA_PLUGIN_DIR . 'schema-definitions/' . $type . '.php';
        
        if ( file_exists( $file ) ) {
            return require $file;
        }
        
        return null;
    }

    /**
     * Checks if a given schema type is supported.
     *
     * @param string $type Schema type slug.
     * @return bool
     * @since 1.0.0
     */
    public static function is_valid_type( $type ) {
        $types = self::get_all_types();
        return isset( $types[ $type ] );
    }
}
