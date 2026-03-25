<?php
/**
 * Schema Types Class
 *
 * Manages all schema types and their definitions
 *
 * @package BigSEO_Schema_Manager
 */

if (!defined('ABSPATH')) {
    exit;
}

class BigSEO_Schema_Types {

    /**
     * Get all available schema types
     */
    public function get_available_types() {
        return array(
            array('value' => 'article', 'label' => 'Article'),
            array('value' => 'local-business', 'label' => 'Local Business'),
            array('value' => 'product', 'label' => 'Product'),
            array('value' => 'organization', 'label' => 'Organization'),
            array('value' => 'person', 'label' => 'Person'),
            array('value' => 'event', 'label' => 'Event'),
            array('value' => 'recipe', 'label' => 'Recipe'),
            array('value' => 'faqpage', 'label' => 'FAQ Page'),
            array('value' => 'breadcrumb', 'label' => 'Breadcrumb'),
            array('value' => 'course', 'label' => 'Course'),
            array('value' => 'job-posting', 'label' => 'Job Posting'),
            array('value' => 'movie', 'label' => 'Movie'),
            array('value' => 'music', 'label' => 'Music Album'),
            array('value' => 'restaurant', 'label' => 'Restaurant'),
            array('value' => 'software', 'label' => 'Software Application'),
            array('value' => 'video', 'label' => 'Video'),
            array('value' => 'book', 'label' => 'Book')
        );
    }

    /**
     * Get schema field definitions for a specific type
     */
    public function get_schema_fields($type) {
        $file_path = BIGSEO_PLUGIN_DIR . 'schema-definitions/' . $type . '.php';
        
        if (!file_exists($file_path)) {
            return false;
        }

        $fields = include $file_path;
        
        if (!is_array($fields)) {
            return false;
        }

        return $fields;
    }

    /**
     * Check if schema type is valid
     */
    public function is_valid_type($type) {
        $valid_types = array_column($this->get_available_types(), 'value');
        return in_array($type, $valid_types, true);
    }

    /**
     * Get schema type label
     */
    public function get_type_label($type) {
        $types = $this->get_available_types();
        
        foreach ($types as $schema_type) {
            if ($schema_type['value'] === $type) {
                return $schema_type['label'];
            }
        }
        
        return '';
    }
}
