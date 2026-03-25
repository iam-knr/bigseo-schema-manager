<?php
/**
 * Sanitizer Class
 *
 * Sanitizes and validates all schema input data
 *
 * @package BigSEO_Schema_Manager
 */

if (!defined('ABSPATH')) {
    exit;
}

class BigSEO_Sanitizer {

    /**
     * Sanitize schema data array
     */
    public function sanitize_schema_data($data, $schema_type) {
        if (!is_array($data)) {
            return array();
        }

        $sanitized = array();

        foreach ($data as $key => $value) {
            $sanitized_key = sanitize_key($key);
            
            if (is_array($value)) {
                $sanitized[$sanitized_key] = $this->sanitize_schema_data($value, $schema_type);
            } else {
                $sanitized[$sanitized_key] = $this->sanitize_field($value, $key);
            }
        }

        return $sanitized;
    }

    /**
     * Sanitize individual field based on its type
     */
    private function sanitize_field($value, $field_key) {
        // URL fields
        if (strpos($field_key, 'url') !== false || strpos($field_key, 'URL') !== false || $field_key === 'image' || $field_key === 'logo') {
            return esc_url_raw($value);
        }

        // Email fields
        if (strpos($field_key, 'email') !== false) {
            return sanitize_email($value);
        }

        // Numeric fields
        if (in_array($field_key, array('price', 'ratingValue', 'bestRating', 'worstRating', 'ratingCount', 'reviewCount'))) {
            return floatval($value);
        }

        // Date fields
        if (strpos($field_key, 'date') !== false || strpos($field_key, 'Date') !== false) {
            return sanitize_text_field($value);
        }

        // Text fields (default)
        return sanitize_text_field($value);
    }

    /**
     * Validate URL
     */
    public function validate_url($url) {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Validate email
     */
    public function validate_email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate date format
     */
    public function validate_date($date) {
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    /**
     * Validate datetime format
     */
    public function validate_datetime($datetime) {
        $formats = array(
            'Y-m-d\\TH:i:s',
            'Y-m-d\\TH:i:sP',
            'Y-m-d H:i:s',
            'c'
        );

        foreach ($formats as $format) {
            $d = \DateTime::createFromFormat($format, $datetime);
            if ($d) {
                return true;
            }
        }

        return false;
    }

    /**
     * Sanitize text field
     */
    public function sanitize_text($text) {
        return sanitize_text_field($text);
    }

    /**
     * Sanitize textarea field
     */
    public function sanitize_textarea($text) {
        return sanitize_textarea_field($text);
    }

    /**
     * Sanitize HTML content (for description fields)
     */
    public function sanitize_html($html) {
        return wp_kses_post($html);
    }
}
