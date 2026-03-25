<?php
/**
 * Activator Class
 *
 * Fired during plugin activation
 *
 * @package BigSEO_Schema_Manager
 */

if (!defined('ABSPATH')) {
    exit;
}

class BigSEO_Activator {

    /**
     * Run on plugin activation
     */
    public static function activate() {
        // Check WordPress version
        if (version_compare(get_bloginfo('version'), '5.0', '<')) {
            wp_die('BigSEO Schema Manager requires WordPress 5.0 or higher.');
        }

        // Check PHP version
        if (version_compare(PHP_VERSION, '7.4', '<')) {
            wp_die('BigSEO Schema Manager requires PHP 7.4 or higher.');
        }

        // Set default options
        self::set_default_options();

        // Flush rewrite rules
        flush_rewrite_rules();

        // Set activation flag
        update_option('bigseo_plugin_activated', true);
        update_option('bigseo_plugin_version', '1.0.0');
    }

    /**
     * Set default plugin options
     */
    private static function set_default_options() {
        // Default organization schema
        if (!get_option('bigseo_default_organization')) {
            update_option('bigseo_default_organization', json_encode(array(
                'name' => get_bloginfo('name'),
                'url' => home_url('/'),
                'logo' => ''
            )));
        }

        // Default settings
        if (!get_option('bigseo_enable_breadcrumbs')) {
            update_option('bigseo_enable_breadcrumbs', false);
        }

        if (!get_option('bigseo_default_logo')) {
            update_option('bigseo_default_logo', '');
        }
    }
}
