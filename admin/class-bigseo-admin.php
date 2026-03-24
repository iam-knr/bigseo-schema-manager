<?php
/**
 * Admin-facing functionality: menu pages, enqueue assets, settings.
 *
 * @package    BigSEO_Schema_Manager
 * @subpackage BigSEO_Schema_Manager/admin
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class BigSEO_Admin {

    /**
     * Enqueue admin CSS.
     *
     * @param string $hook Current admin page hook.
     * @since 1.0.0
     */
    public function enqueue_styles( $hook ) {
        // Only load on plugin's own pages and post edit screens.
        if ( strpos( $hook, 'bigseo-schema' ) === false && ! in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
            return;
        }

        wp_enqueue_style(
            'bigseo-schema-admin',
            BIGSEO_SCHEMA_PLUGIN_URL . 'admin/css/dist/admin.css',
            array(),
            BIGSEO_SCHEMA_VERSION,
            'all'
        );
    }

    /**
     * Enqueue admin JavaScript (React bundle).
     *
     * @param string $hook Current admin page hook.
     * @since 1.0.0
     */
    public function enqueue_scripts( $hook ) {
        // Only load on plugin's own pages and post edit screens.
        if ( strpos( $hook, 'bigseo-schema' ) === false && ! in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
            return;
        }

        wp_enqueue_script(
            'bigseo-schema-builder',
            BIGSEO_SCHEMA_PLUGIN_URL . 'admin/js/dist/schema-builder.js',
            array( 'wp-element', 'wp-components', 'wp-api-fetch' ),
            BIGSEO_SCHEMA_VERSION,
            true
        );

        // Pass data from PHP to React via wp_localize_script.
        wp_localize_script(
            'bigseo-schema-builder',
            'bigSEOSchema',
            array(
                'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
                'restUrl'    => rest_url( 'bigseo/v1/' ),
                'nonce'      => wp_create_nonce( 'wp_rest' ),
                'schemaTypes' => BigSEO_Schema_Types::get_all_types(),
                'currentPost' => get_the_ID(),
            )
        );
    }

    /**
     * Register the plugin's admin menu.
     *
     * @since 1.0.0
     */
    public function add_plugin_admin_menu() {
        add_menu_page(
            __( 'BigSEO Schema Manager', 'bigseo-schema-manager' ),  // Page title
            __( 'Schema Manager', 'bigseo-schema-manager' ),          // Menu title
            'manage_options',                                          // Capability
            'bigseo-schema-settings',                                  // Menu slug
            array( $this, 'display_settings_page' ),                   // Callback
            'dashicons-editor-code',                                   // Icon
            80                                                         // Position
        );
    }

    /**
     * Renders the plugin's settings page.
     *
     * @since 1.0.0
     */
    public function display_settings_page() {
        require_once BIGSEO_SCHEMA_PLUGIN_DIR . 'admin/views/settings-page.php';
    }

    /**
     * Adds "Settings" link to plugins list page.
     *
     * @param array $links Existing action links.
     * @return array Modified action links.
     * @since 1.0.0
     */
    public function add_action_links( $links ) {
        $settings_link = sprintf(
            '<a href="%s">%s</a>',
            admin_url( 'admin.php?page=bigseo-schema-settings' ),
            __( 'Settings', 'bigseo-schema-manager' )
        );
        array_unshift( $links, $settings_link );
        return $links;
    }

    /**
     * AJAX handler: saves global schema settings.
     *
     * @since 1.0.0
     */
    public function ajax_save_global_schema() {
        check_ajax_referer( 'bigseo_schema_nonce', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( 'Insufficient permissions.' );
        }

        $raw_data = isset( $_POST['schema_data'] ) ? json_decode( stripslashes( $_POST['schema_data'] ), true ) : array();
        $sanitized = BigSEO_Sanitizer::sanitize_schema_data( $raw_data );

        update_option( 'bigseo_schema_global', $sanitized );

        wp_send_json_success( array( 'message' => 'Global schema saved successfully.' ) );
    }
}
