<?php
/**
 * Handles injection of JSON-LD schema markup into wp_head.
 *
 * @package    BigSEO_Schema_Manager
 * @subpackage BigSEO_Schema_Manager/includes
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class BigSEO_Injector {

    /**
     * Outputs all applicable JSON-LD <script> blocks into the <head>.
     * Hooked to wp_head with priority 1 (very early).
     *
     * @since 1.0.0
     */
    public function inject_schema() {

        $schemas_to_output = array();

        // 1. Global schemas (apply to every page).
        $global_schemas = get_option( 'bigseo_schema_global', array() );
        if ( ! empty( $global_schemas ) && is_array( $global_schemas ) ) {
            foreach ( $global_schemas as $schema ) {
                if ( ! empty( $schema ) ) {
                    $schemas_to_output[] = $schema;
                }
            }
        }

        // 2. Per-page/post schemas.
        if ( is_singular() ) {
            $post_id      = get_queried_object_id();
            $post_schemas = get_post_meta( $post_id, '_bigseo_schema_data', true );

            if ( ! empty( $post_schemas ) && is_array( $post_schemas ) ) {
                foreach ( $post_schemas as $schema ) {
                    if ( ! empty( $schema ) ) {
                        $schemas_to_output[] = $schema;
                    }
                }
            }
        }

        // 3. Post-type-level schemas (applied to all posts of a type).
        if ( is_singular() ) {
            $post_id   = get_queried_object_id();
            $post_type = get_post_type( $post_id );
            $pt_schemas = get_option( 'bigseo_schema_posttype_' . $post_type, array() );

            if ( ! empty( $pt_schemas ) && is_array( $pt_schemas ) ) {
                foreach ( $pt_schemas as $schema ) {
                    if ( ! empty( $schema ) ) {
                        $schemas_to_output[] = $schema;
                    }
                }
            }
        }

        // Output each schema block.
        foreach ( $schemas_to_output as $schema_data ) {
            $this->output_schema_block( $schema_data );
        }
    }

    /**
     * Renders a single <script type="application/ld+json"> block.
     *
     * @param array $schema_data Associative array representing the schema.
     * @since 1.0.0
     */
    private function output_schema_block( $schema_data ) {
        if ( empty( $schema_data ) || ! is_array( $schema_data ) ) {
            return;
        }

        // Ensure @context is always set.
        if ( ! isset( $schema_data['@context'] ) ) {
            $schema_data = array_merge(
                array( '@context' => 'https://schema.org' ),
                $schema_data
            );
        }

        $json = wp_json_encode( $schema_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );

        if ( $json ) {
            echo '<script type="application/ld+json">' . "\n";
            echo $json . "\n";
            echo '</script>' . "\n";
        }
    }
}
