<?php
/**
 * Loader Class
 *
 * Registers all actions and filters for the plugin
 *
 * @package BigSEO_Schema_Manager
 */

if (!defined('ABSPATH')) {
    exit;
}

class BigSEO_Loader {

    protected $actions;
    protected $filters;

    public function __construct() {
        $this->actions = array();
        $this->filters = array();
    }

    /**
     * Add action hook
     */
    public function add_action($hook, $component, $callback, $priority = 10, $accepted_args = 1) {
        $this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * Add filter hook
     */
    public function add_filter($hook, $component, $callback, $priority = 10, $accepted_args = 1) {
        $this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * Add hook to internal array
     */
    private function add($hooks, $hook, $component, $callback, $priority, $accepted_args) {
        $hooks[] = array(
            'hook' => $hook,
            'component' => $component,
            'callback' => $callback,
            'priority' => $priority,
            'accepted_args' => $accepted_args
        );
        return $hooks;
    }

    /**
     * Execute all registered hooks
     */
    public function run() {
        foreach ($this->filters as $hook) {
            add_filter(
                $hook['hook'],
                array($hook['component'], $hook['callback']),
                $hook['priority'],
                $hook['accepted_args']
            );
        }

        foreach ($this->actions as $hook) {
            add_action(
                $hook['hook'],
                array($hook['component'], $hook['callback']),
                $hook['priority'],
                $hook['accepted_args']
            );
        }

        // Initialize all components
        $this->init_components();
    }

    /**
     * Initialize all plugin components
     */
    private function init_components() {
        // Admin components
        if (is_admin()) {
            $admin = new BigSEO_Admin();
            $admin->init_hooks();

            $metabox = new BigSEO_Metabox();
            $metabox->init_hooks();
        }

        // Frontend components
        $injector = new BigSEO_Injector();
        $injector->init_hooks();

        // AJAX/REST API
        $ajax = new BigSEO_Ajax();
        $ajax->init_hooks();
    }
}
