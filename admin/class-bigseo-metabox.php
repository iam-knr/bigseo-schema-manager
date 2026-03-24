<?php
/**
 * Registers and handles the per-page schema meta box.
 *
 * @package    BigSEO_Schema_Manager
 * @subpackage BigSEO_Schema_Manager/admin
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class BigSEO_Metabox {

    /**
     * Registers the schema meta box on post/page edit screens.
     *
     * @since 1.0.0
     */
    public function register_meta_box() {
        $post_types = get_post_types( array( 'public' => true ), 'names' );

        add_meta_box(
            'bigseo_schema_metabox',
            __( 'Schema Markup (JSON-LD)', 'bigseo-schema-manager' ),
            array( $this, 'render_meta_box' ),
            $post_types,
            'normal',
            'high'
        );
    }

    /**
     * Renders the meta box HTML (React mount point).
     *
     * @param WP_Post $post The current post object.
     * @since 1.0.0
     */
    public function render_meta_box( $post ) {
        // Security nonce.
        wp_nonce_field( 'bigseo_metabox_save', 'bigseo_metabox_nonce' );

        // Get existing schema data.
        $existing_schemas = get_post_meta( $post->ID, '_bigseo_schema_data', true );
        if ( ! is_array( $existing_schemas ) ) {
            $existing_schemas = array();
        }

        // Include the meta box template.
        require_once BIGSEO_SCHEMA_PLUGIN_DIR . 'admin/views/meta-box.php';
    }

    /**
     * Saves the meta box data when the post is saved.
     *
     * @param int $post_id The post ID.
     * @since 1.0.0
     */
    public function save_meta_box_data( $post_id ) {

        // Security checks.
        if ( ! isset( $_POST['bigseo_metabox_nonce'] ) ) {
            return;
        }
        if ( ! wp_verify_nonce( $_POST['bigseo_metabox_nonce'], 'bigseo_metabox_save' ) ) {
            return;
        }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // Get and sanitize the schema data.
        $raw_data = isset( $_POST['bigseo_schema_data'] ) ? json_decode( stripslashes( $_POST['bigseo_schema_data'] ), true ) : array();
        $sanitized = BigSEO_Sanitizer::sanitize_schema_data( $raw_data );

        // Save to post meta.
        if ( ! empty( $sanitized ) ) {
            update_post_meta( $post_id, '_bigseo_schema_data', $sanitized );
        } else {
            delete_post_meta( $post_id, '_bigseo_schema_data' );
        }
    }

    /**
     * Registers REST API routes for schema data retrieval (used by React).
     *
     * @since 1.0.0
     */
    public function register_rest_routes() {
        register_rest_route(
            'bigseo/v1',
            '/schema-fields/(?P<type>[a-z-]+)',
            array(
                'methods'             => 'GET',
                'callback'            => array( $this, 'rest_get_schema_fields' ),
                'permission_callback' => function() {
                    return current_user_can( 'edit_posts' );
                },
            )
        );
    }

    /**
     * REST API callback: returns field definitions for a schema type.
     *
     * @param WP_REST_Request $request REST request object.
     * @return WP_REST_Response|WP_Error
     * @since 1.0.0
     */
    public function rest_get_schema_fields( $request ) {
        $type = $request->get_param( 'type' );
        $fields = BigSEO_Schema_Types::get_fields( $type );

        if ( ! $fields ) {
            return new WP_Error( 'invalid_type', 'Schema type not found.', array( 'status' => 404 ) );
        }

        return rest_ensure_response( $fields );
    }
}
