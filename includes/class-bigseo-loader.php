<?php
/**
 * Registers all actions and filters for the plugin.
 *
 * @package    BigSEO_Schema_Manager
 * @subpackage BigSEO_Schema_Manager/includes
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class BigSEO_Loader {

    /**
     * Array of actions registered with WordPress.
     * @var array
     */
    protected $actions = array();

    /**
     * Array of filters registered with WordPress.
     * @var array
     */
    protected $filters = array();

    /**
     * Constructor - initialises all hooks.
     */
    public function __construct() {
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Register all admin-facing hooks.
     */
    private function define_admin_hooks() {
        $admin   = new BigSEO_Admin();
        $metabox = new BigSEO_Metabox();

        // Enqueue admin scripts & styles.
        $this->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_styles' );
        $this->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts' );

        // Admin menu.
        $this->add_action( 'admin_menu', $admin, 'add_plugin_admin_menu' );

        // Plugin settings link on plugins list page.
        $this->add_filter(
            'plugin_action_links_' . BIGSEO_SCHEMA_PLUGIN_BASENAME,
            $admin,
            'add_action_links'
        );

        // Save settings via AJAX.
        $this->add_action( 'wp_ajax_bigseo_save_global_schema', $admin, 'ajax_save_global_schema' );

        // Meta box registration & save.
        $this->add_action( 'add_meta_boxes', $metabox, 'register_meta_box' );
        $this->add_action( 'save_post',      $metabox, 'save_meta_box_data' );

        // REST API endpoint for schema data (used by React UI).
        $this->add_action( 'rest_api_init', $metabox, 'register_rest_routes' );
    }

    /**
     * Register all public-facing hooks.
     */
    private function define_public_hooks() {
        $injector = new BigSEO_Injector();
        $public   = new BigSEO_Public();

        // Inject JSON-LD into <head>.
        $this->add_action( 'wp_head', $injector, 'inject_schema', 1 );

        // Optional: front-end CSS/JS (minimal for this plugin).
        $this->add_action( 'wp_enqueue_scripts', $public, 'enqueue_styles' );
        $this->add_action( 'wp_enqueue_scripts', $public, 'enqueue_scripts' );
    }

    // ─── Helpers ────────────────────────────────────────────────────────────

    private function add_action( $hook, $component, $callback, $priority = 10, $args = 1 ) {
        $this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $args );
    }

    private function add_filter( $hook, $component, $callback, $priority = 10, $args = 1 ) {
        $this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $args );
    }

    private function add( $hooks, $hook, $component, $callback, $priority, $args ) {
        $hooks[] = array(
            'hook'      => $hook,
            'component' => $component,
            'callback'  => $callback,
            'priority'  => $priority,
            'args'      => $args,
        );
        return $hooks;
    }

    /**
     * Run the Loader: register all queued actions and filters with WordPress.
     */
    public function run() {
        foreach ( $this->actions as $hook ) {
            add_action(
                $hook['hook'],
                array( $hook['component'], $hook['callback'] ),
                $hook['priority'],
                $hook['args']
            );
        }
        foreach ( $this->filters as $hook ) {
            add_filter(
                $hook['hook'],
                array( $hook['component'], $hook['callback'] ),
                $hook['priority'],
                $hook['args']
            );
        }
    }
}
