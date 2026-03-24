<?php
/**
 * Schema Generator Class
 * 
 * Handles schema generation logic and data processing
 * 
 * @package BigSEO_Schema_Manager
 */

if (!defined('ABSPATH')) {
    exit;
}

class BigSEO_Generator {
    
    /**
     * Generate schema based on type and form data
     */
    public function generate($schema_type, $form_data) {
        $definition = $this->load_definition($schema_type);
        
        if (!$definition) {
            return new WP_Error('invalid_schema', 'Invalid schema type');
        }
        
        $schema = $this->build_schema($definition, $form_data);
        
        return $schema;
    }
    
    /**
     * Load schema definition file
     */
    private function load_definition($schema_type) {
        $file_path = BIGSEO_PLUGIN_DIR . 'schema-definitions/' . sanitize_file_name($schema_type) . '.php';
        
        if (!file_exists($file_path)) {
            return false;
        }
        
        return include $file_path;
    }
    
    /**
     * Build schema from definition and form data
     */
    private function build_schema($definition, $form_data) {
        $schema = [];
        
        foreach ($definition as $key => $value) {
            if (is_array($value) && isset($value['type'])) {
                if (isset($form_data[$key]) && !empty($form_data[$key])) {
                    $schema[$key] = $this->format_value($form_data[$key], $value['type']);
                }
            } elseif ($key === '@context' || $key === '@type') {
                $schema[$key] = $value;
            }
        }
        
        return $schema;
    }
    
    /**
     * Format value based on type
     */
    private function format_value($value, $type) {
        switch ($type) {
            case 'url':
                return esc_url($value);
            case 'email':
                return sanitize_email($value);
            case 'number':
                return floatval($value);
            case 'date':
            case 'datetime':
                return $value;
            default:
                return sanitize_text_field($value);
        }
    }
}
