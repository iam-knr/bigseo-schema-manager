<?php
/**
 * Sanitizes and validates all incoming schema data before saving.
 *
 * @package    BigSEO_Schema_Manager
 * @subpackage BigSEO_Schema_Manager/includes
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class BigSEO_Sanitizer {

    /**
     * Sanitizes schema data array recursively.
     *
     * @param array $data Raw schema data from POST/AJAX.
     * @return array Sanitized schema data.
     * @since 1.0.0
     */
    public static function sanitize_schema_data( $data ) {
        if ( ! is_array( $data ) ) {
            return array();
        }

        $sanitized = array();

        foreach ( $data as $key => $value ) {
            // Sanitize the key.
            $clean_key = sanitize_key( $key );

            // Recursively sanitize nested arrays.
            if ( is_array( $value ) ) {
                $sanitized[ $clean_key ] = self::sanitize_schema_data( $value );
            }
            // URLs.
            elseif ( filter_var( $value, FILTER_VALIDATE_URL ) ) {
                $sanitized[ $clean_key ] = esc_url_raw( $value );
            }
            // Emails.
            elseif ( is_email( $value ) ) {
                $sanitized[ $clean_key ] = sanitize_email( $value );
            }
            // Numbers (integers and floats).
            elseif ( is_numeric( $value ) ) {
                $sanitized[ $clean_key ] = ( strpos( $value, '.' ) !== false )
                    ? floatval( $value )
                    : intval( $value );
            }
            // Booleans.
            elseif ( is_bool( $value ) || in_array( $value, array( 'true', 'false' ), true ) ) {
                $sanitized[ $clean_key ] = filter_var( $value, FILTER_VALIDATE_BOOLEAN );
            }
            // Everything else: text.
            else {
                $sanitized[ $clean_key ] = sanitize_text_field( $value );
            }
        }

        return $sanitized;
    }

    /**
     * Validates required fields for a given schema type.
     *
     * @param string $type   Schema type slug.
     * @param array  $data   Schema data to validate.
     * @return array|WP_Error Validated data or WP_Error on failure.
     * @since 1.0.0
     */
    public static function validate_required_fields( $type, $data ) {
        $fields = BigSEO_Schema_Types::get_fields( $type );

        if ( ! $fields ) {
            return new WP_Error( 'invalid_type', 'Schema type not supported.' );
        }

        $missing = array();

        foreach ( $fields as $field ) {
            if ( ! empty( $field['required'] ) ) {
                $key = $field['key'];
                if ( empty( $data[ $key ] ) ) {
                    $missing[] = $field['label'];
                }
            }
        }

        if ( ! empty( $missing ) ) {
            return new WP_Error(
                'missing_fields',
                sprintf(
                    'Required fields missing: %s',
                    implode( ', ', $missing )
                )
            );
        }

        return $data;
    }
}
