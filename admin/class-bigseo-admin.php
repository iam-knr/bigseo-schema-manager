<?php
/**
 * Admin Class
 *
 * Admin-facing functionality: menu pages, enqueue assets, settings
 *
 * @package BigSEO_Schema_Manager
 */

if (!defined('ABSPATH')) {
    exit;
}

class BigSEO_Admin {

    public function init_hooks() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            'BigSEO Schema Manager',
            'BigSEO Schema',
            'manage_options',
            'bigseo-schema',
            array($this, 'render_settings_page'),
            'dashicons-networking',
            30
        );
    }

    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting('bigseo_schema_settings', 'bigseo_default_organization');
        register_setting('bigseo_schema_settings', 'bigseo_default_logo');
        register_setting('bigseo_schema_settings', 'bigseo_enable_breadcrumbs');
    }

    /**
     * Render settings page
     */
    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        include BIGSEO_PLUGIN_DIR . 'admin/views/settings-page.php';
    }

    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_admin_scripts($hook) {
        // Only load on our settings page
        if ($hook !== 'toplevel_page_bigseo-schema') {
            return;
        }

        wp_enqueue_script(
            'bigseo-admin',
            plugin_dir_url(dirname(__FILE__)) . 'public/dist/admin.bundle.js',
            array(),
            '1.0.0',
            true
        );

        // Pass data to React
        wp_localize_script('bigseo-admin', 'bigSeoData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'restUrl' => rest_url('bigseo/v1/'),
            'nonce' => wp_create_nonce('wp_rest'),
            'schemaTypes' => (new BigSEO_Schema_Types())->get_available_types()
        ));
    }
}
