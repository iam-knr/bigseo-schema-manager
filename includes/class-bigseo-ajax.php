<?php
/**
 * AJAX Handler Class
 *
 * Handles all AJAX and REST API requests for the plugin
 *
 * @package BigSEO_Schema_Manager
 */

if (!defined('ABSPATH')) {
    exit;
}

class BigSEO_Ajax {

    private $generator;
    private $schema_types;
    private $sanitizer;

    public function __construct() {
        $this->generator = new BigSEO_Generator();
        $this->schema_types = new BigSEO_Schema_Types();
        $this->sanitizer = new BigSEO_Sanitizer();
    }

    public function init_hooks() {
        add_action('rest_api_init', array($this, 'register_rest_routes'));
    }

    /**
     * Register REST API routes
     */
    public function register_rest_routes() {
        // Get schema types
        register_rest_route('bigseo/v1', '/schema-types', array(
            'methods' => 'GET',
            'callback' => array($this, 'handle_get_schema_types'),
            'permission_callback' => array($this, 'check_permissions')
        ));

        // Get schema definition
        register_rest_route('bigseo/v1', '/schema-definitions/(?P<type>[a-zA-Z0-9-]+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'handle_get_definition'),
            'permission_callback' => array($this, 'check_permissions'),
            'args' => array(
                'type' => array(
                    'required' => true,
                    'validate_callback' => function($param) {
                        return is_string($param);
                    }
                )
            )
        ));

        // Save schema data
        register_rest_route('bigseo/v1', '/save-schema', array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_save_schema'),
            'permission_callback' => array($this, 'check_edit_permissions'),
            'args' => array(
                'post_id' => array(
                    'required' => true,
                    'validate_callback' => function($param) {
                        return is_numeric($param);
                    }
                ),
                'schema_type' => array(
                    'required' => true,
                    'validate_callback' => function($param) {
                        return is_string($param);
                    }
                ),
                'schema_data' => array(
                    'required' => true,
                    'validate_callback' => function($param) {
                        return is_array($param);
                    }
                )
            )
        ));

        // Generate schema preview
        register_rest_route('bigseo/v1', '/generate-schema', array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_generate_schema'),
            'permission_callback' => array($this, 'check_permissions'),
            'args' => array(
                'schema_type' => array(
                    'required' => true
                ),
                'schema_data' => array(
                    'required' => true
                )
            )
        ));

        // Delete schema
        register_rest_route('bigseo/v1', '/delete-schema/(?P<post_id>\\d+)', array(
            'methods' => 'DELETE',
            'callback' => array($this, 'handle_delete_schema'),
            'permission_callback' => array($this, 'check_edit_permissions'),
            'args' => array(
                'post_id' => array(
                    'required' => true,
                    'validate_callback' => function($param) {
                        return is_numeric($param);
                    }
                )
            )
        ));
    }

    public function check_permissions() {
        return current_user_can('edit_posts');
    }

    public function check_edit_permissions($request) {
        $post_id = $request->get_param('post_id');
        if ($post_id) {
            return current_user_can('edit_post', $post_id);
        }
        return current_user_can('edit_posts');
    }

    public function handle_get_schema_types($request) {
        $types = $this->schema_types->get_available_types();
        return new WP_REST_Response(array('success' => true, 'data' => $types), 200);
    }

    public function handle_get_definition($request) {
        $type = $request->get_param('type');
        $definition = $this->schema_types->get_schema_fields($type);
        if (!$definition) {
            return new WP_REST_Response(array('success' => false, 'message' => 'Schema type not found'), 404);
        }
        return new WP_REST_Response(array('success' => true, 'data' => $definition), 200);
    }

    public function handle_save_schema($request) {
        $post_id = $request->get_param('post_id');
        $schema_type = $request->get_param('schema_type');
        $schema_data = $request->get_param('schema_data');
        $sanitized_data = $this->sanitizer->sanitize_schema_data($schema_data, $schema_type);
        update_post_meta($post_id, '_bigseo_schema_type', sanitize_text_field($schema_type));
        update_post_meta($post_id, '_bigseo_schema_data', wp_json_encode($sanitized_data));
        update_post_meta($post_id, '_bigseo_enable_schema', '1');
        return new WP_REST_Response(array('success' => true, 'message' => 'Schema saved successfully', 'data' => array('post_id' => $post_id, 'schema_type' => $schema_type)), 200);
    }

    public function handle_generate_schema($request) {
        $schema_type = $request->get_param('schema_type');
        $schema_data = $request->get_param('schema_data');
        $sanitized_data = $this->sanitizer->sanitize_schema_data($schema_data, $schema_type);
        $json_ld = $this->generator->generate($schema_type, $sanitized_data);
        if (!$json_ld) {
            return new WP_REST_Response(array('success' => false, 'message' => 'Failed to generate schema'), 400);
        }
        return new WP_REST_Response(array('success' => true, 'data' => array('json_ld' => $json_ld, 'formatted' => json_encode(json_decode($json_ld), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))), 200);
    }

    public function handle_delete_schema($request) {
        $post_id = $request->get_param('post_id');
        delete_post_meta($post_id, '_bigseo_schema_type');
        delete_post_meta($post_id, '_bigseo_schema_data');
        delete_post_meta($post_id, '_bigseo_enable_schema');
        return new WP_REST_Response(array('success' => true, 'message' => 'Schema deleted successfully'), 200);
    }
}
