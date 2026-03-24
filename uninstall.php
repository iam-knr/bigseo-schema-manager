<?php
/**
 * Fired when the plugin is uninstalled.
 * Removes all plugin data from the database.
 *
 * @package    BigSEO_Schema_Manager
 * @since      1.0.0
 */

// If uninstall not called from WordPress, exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Delete plugin options.
delete_option( 'bigseo_schema_version' );
delete_option( 'bigseo_schema_global' );

// Delete all post-type-level schema options.
$post_types = get_post_types( array( 'public' => true ), 'names' );
foreach ( $post_types as $post_type ) {
    delete_option( 'bigseo_schema_posttype_' . $post_type );
}

// Delete all post meta (schema data from individual posts/pages).
global $wpdb;
$wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_bigseo_schema_data'" );

// Clean up: flush rewrite rules.
flush_rewrite_rules();
