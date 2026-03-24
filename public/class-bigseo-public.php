<?php

/**
 * Public-facing functionality (minimal for this plugin).
 *
 * @package    BigSEO_Schema_Manager
 * @subpackage BigSEO_Schema_Manager/public
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class BigSEO_Public {

    /**
     * Enqueue front-end CSS (if needed).
     *
     * @since 1.0.0
     */
    public function enqueue_styles() {
        // No front-end styles needed for this plugin.
        // Schema injection happens in <head> via JSON-LD only.
    }

    /**
     * Enqueue front-end JavaScript (if needed).
     *
     * @since 1.0.0
     */
    public function enqueue_scripts() {
        // No front-end scripts needed for this plugin.
        // JSON-LD is purely in the HTML <head> - no JS required.
    }
}
