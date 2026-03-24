<?php
/**
 * Fired during plugin activation.
 *
 * @package    BigSEO_Schema_Manager
 * @subpackage BigSEO_Schema_Manager/includes
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class BigSEO_Activator {

    /**
     * Runs on plugin activation.
     *
     * Creates the necessary database options and sets the plugin version.
     *
     * @since 1.0.0
     */
    public static function activate() {

        // Store the plugin version for future upgrade checks.
        if ( ! get_option( 'bigseo_schema_version' ) ) {
            add_option( 'bigseo_schema_version', BIGSEO_SCHEMA_VERSION );
        }

        // Initialise global schema settings if not already present.
        if ( ! get_option( 'bigseo_schema_global' ) ) {
            add_option( 'bigseo_schema_global', array() );
        }

        // Flush rewrite rules so our REST routes are live immediately.
        flush_rewrite_rules();
    }
}
