<?php
/**
 * Plugin Name:       BigSEO Schema Manager
 * Plugin URI:        https://bigseo.in/schema-manager
 * Description:       Generate and inject JSON-LD schema markup automatically into the <head> of any WordPress page or post. Supports 30+ schema types from Schema.org.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Big SEO
 * Author URI:        https://bigseo.in
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       bigseo-schema-manager
 * Domain Path:       /languages
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ─── Plugin Constants ──────────────────────────────────────────────────────────
define( 'BIGSEO_SCHEMA_VERSION',     '1.0.0' );
define( 'BIGSEO_SCHEMA_PLUGIN_FILE', __FILE__ );
define( 'BIGSEO_SCHEMA_PLUGIN_DIR',  plugin_dir_path( __FILE__ ) );
define( 'BIGSEO_SCHEMA_PLUGIN_URL',  plugin_dir_url( __FILE__ ) );
define( 'BIGSEO_SCHEMA_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

// ─── Autoload Core Classes ─────────────────────────────────────────────────────
require_once BIGSEO_SCHEMA_PLUGIN_DIR . 'includes/class-bigseo-activator.php';
require_once BIGSEO_SCHEMA_PLUGIN_DIR . 'includes/class-bigseo-deactivator.php';
require_once BIGSEO_SCHEMA_PLUGIN_DIR . 'includes/class-bigseo-schema-types.php';
require_once BIGSEO_SCHEMA_PLUGIN_DIR . 'includes/class-bigseo-sanitizer.php';
require_once BIGSEO_SCHEMA_PLUGIN_DIR . 'includes/class-bigseo-injector.php';
require_once BIGSEO_SCHEMA_PLUGIN_DIR . 'includes/class-bigseo-loader.php';
require_once BIGSEO_SCHEMA_PLUGIN_DIR . 'admin/class-bigseo-admin.php';
require_once BIGSEO_SCHEMA_PLUGIN_DIR . 'admin/class-bigseo-metabox.php';
require_once BIGSEO_SCHEMA_PLUGIN_DIR . 'public/class-bigseo-public.php';

// ─── Activation / Deactivation Hooks ──────────────────────────────────────────
register_activation_hook( __FILE__, array( 'BigSEO_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'BigSEO_Deactivator', 'deactivate' ) );

/**
 * Begins execution of the plugin.
 *
 * @since 1.0.0
 */
function bigseo_schema_run() {
    $loader = new BigSEO_Loader();
    $loader->run();
}
bigseo_schema_run();
