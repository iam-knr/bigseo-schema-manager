<?php
/**
 * Schema Generator Class
 *
 * Generates JSON-LD schema markup from field data
 *
 * @package BigSEO_Schema_Manager
 */

if (!defined('ABSPATH')) {
    exit;
}

class BigSEO_Generator {

    /**
     * Generate JSON-LD schema
     */
    public function generate($schema_type, $schema_data) {
        if (empty($schema_type) || empty($schema_data)) {
            return false;
        }

        // Remove empty values
        $schema_data = $this->remove_empty_values($schema_data);

        // Add @context and @type
        $json_ld = array(
            '@context' => 'https://schema.org',
            '@type' => $this->format_schema_type($schema_type)
        );

        // Merge with schema data
        $json_ld = array_merge($json_ld, $schema_data);

        // Convert to JSON
        $json_output = json_encode($json_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return $json_output;
    }

    /**
     * Format schema type name (convert kebab-case to PascalCase)
     */
    private function format_schema_type($type) {
        // Handle special cases
        $type_map = array(
            'local-business' => 'LocalBusiness',
            'job-posting' => 'JobPosting',
            'faqpage' => 'FAQPage',
            'breadcrumb' => 'BreadcrumbList',
            'software' => 'SoftwareApplication',
            'music' => 'MusicAlbum'
        );

        if (isset($type_map[$type])) {
            return $type_map[$type];
        }

        // Convert to PascalCase
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $type)));
    }

    /**
     * Remove empty values from array
     */
    private function remove_empty_values($data) {
        $cleaned = array();
        
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = $this->remove_empty_values($value);
                if (!empty($value)) {
                    $cleaned[$key] = $value;
                }
            } elseif ($value !== '' && $value !== null) {
                $cleaned[$key] = $value;
            }
        }
        
        return $cleaned;
    }

    /**
     * Validate required fields
     */
    public function validate_required_fields($schema_type, $schema_data) {
        $schema_types = new BigSEO_Schema_Types();
        $fields = $schema_types->get_schema_fields($schema_type);
        
        if (!$fields) {
            return array('valid' => false, 'errors' => array('Invalid schema type'));
        }

        $errors = array();
        
        foreach ($fields as $field) {
            if (!empty($field['required'])) {
                $key = $field['key'];
                if (empty($schema_data[$key])) {
                    $errors[] = sprintf('%s is required', $field['label']);
                }
            }
        }

        return array(
            'valid' => empty($errors),
            'errors' => $errors
        );
    }

    /**
     * Generate structured data for specific types
     */
    public function generate_breadcrumb($items) {
        $itemListElement = array();
        
        foreach ($items as $index => $item) {
            $itemListElement[] = array(
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url']
            );
        }

        $breadcrumb = array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $itemListElement
        );

        return json_encode($breadcrumb, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
