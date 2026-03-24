<?php
/**
 * AJAX Handler Class
 * 
 * Handles all AJAX requests for the plugin
 * 
 * @package BigSEO_Schema_Manager
 */

if (!defined('ABSPATH')) {
    exit;
}

class BigSEO_Ajax {
    
    private $generator;
    
    public function __construct() {
        $this->generator = new BigSEO_Generator();
        $this->init_hooks();
    }
    
    /**
     * Initialize AJAX hooks
     */
    private function init_hooks() {
        add_action('wp_ajax_generate_schema', [$this, 'handle_generate_schema']);
        add_action('wp_ajax_get_schema_definition', [$this, 'handle_get_definition']);
        add_action('wp_ajax_save_schema', [$this, 'handle_save_schema']);
        add_action('wp_ajax_delete_schema', [$this, 'handle_delete_schema']);
    }
    
    /**
     * Handle schema generation request
     */
    public function handle_generate_schema() {
        check_ajax_referer('bigseo_schema_nonce', 'nonce');
        
        if (!current_user_can('edit_posts')) {
            wp_send_json_error(['message' => 'Unauthorized']);
        }
        
        $schema_type = sanitize_text_field($_POST['schema_type'] ?? '');
        $form_data = json_decode(stripslashes($_POST['form_data'] ?? '{}'), true);
        
        if (empty($schema_type)) {
            wp_send_json_error(['message' => 'Schema type is required']);
        }
        
        $schema = $this->generator->generate($schema_type, $form_data);
        
        if (is_wp_error($schema)) {
            wp_send_json_error(['message' => $schema->get_error_message()]);
        }
        
        wp_send_json_success(['schema' => $schema]);
    }
    
    /**
     * Get schema definition
     */
    public function handle_get_definition() {
        check_ajax_referer('bigseo_schema_nonce', 'nonce');
        
        $schema_type = sanitize_text_field($_POST['schema_type'] ?? '');
        
        if (empty($schema_type)) {
            wp_send_json_error(['message' => 'Schema type is required']);
        }
        
        $file_path = BIGSEO_PLUGIN_DIR . 'schema-definitions/' . sanitize_file_name($schema_type) . '.php';
        
        if (!file_exists($file_path)) {
            wp_send_json_error(['message' => 'Schema definition not found']);
        }
        
        $definition = include $file_path;
        wp_send_json_success(['definition' => $definition]);
    }
    
    /**
     * Save schema to post meta
     */
    public function handle_save_schema() {
        check_ajax_referer('bigseo_schema_nonce', 'nonce');
        
        if (!current_user_can('edit_posts')) {
            wp_send_json_error(['message' => 'Unauthorized']);
        }
        
        $post_id = intval($_POST['post_id'] ?? 0);
        $schema_type = sanitize_text_field($_POST['schema_type'] ?? '');
        $schema_data = json_decode(stripslashes($_POST['schema_data'] ?? '{}'), true);
        
        if (empty($post_id) || empty($schema_type)) {
            wp_send_json_error(['message' => 'Invalid request']);
        }
        
        update_post_meta($post_id, '_bigseo_schema_type', $schema_type);
        update_post_meta($post_id, '_bigseo_schema_data', $schema_data);
        
        wp_send_json_success(['message' => 'Schema saved successfully']);
    }
    
    /**
     * Delete schema from post
     */
    public function handle_delete_schema() {
        check_ajax_referer('bigseo_schema_nonce', 'nonce');
        
        if (!current_user_can('edit_posts')) {
            wp_send_json_error(['message' => 'Unauthorized']);
        }
        
        $post_id = intval($_POST['post_id'] ?? 0);
        
        if (empty($post_id)) {
            wp_send_json_error(['message' => 'Post ID is required']);
        }
        
        delete_post_meta($post_id, '_bigseo_schema_type');
        delete_post_meta($post_id, '_bigseo_schema_data');
        
        wp_send_json_success(['message' => 'Schema deleted successfully']);
    }
}
