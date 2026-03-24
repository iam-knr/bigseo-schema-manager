<?php
/**
 * Fired during plugin deactivation.
 *
 * @package    BigSEO_Schema_Manager
 * @subpackage BigSEO_Schema_Manager/includes
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class BigSEO_Deactivator {

    /**
     * Runs on plugin deactivation.
     *
     * Note: We do NOT delete post_meta or options here.
     * Data cleanup is handled by uninstall.php only.
     *
     * @since 1.0.0
     */
    public static function deactivate() {
        // Flush rewrite rules on deactivation.
        flush_rewrite_rules();
    }
}
