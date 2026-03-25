<?php
/**
 * Deactivator Class
 *
 * Fired during plugin deactivation
 *
 * @package BigSEO_Schema_Manager
 */

if (!defined('ABSPATH')) {
    exit;
}

class BigSEO_Deactivator {

    /**
     * Run on plugin deactivation
     */
    public static function deactivate() {
        // Flush rewrite rules
        flush_rewrite_rules();

        // Clear transients/caches
        self::clear_plugin_cache();

        // Remove activation flag
        delete_option('bigseo_plugin_activated');
    }

    /**
     * Clear plugin-specific caches
     */
    private static function clear_plugin_cache() {
        // Delete any transients
        delete_transient('bigseo_schema_cache');
        
        // Clear WordPress object cache
        wp_cache_flush();
    }
}
