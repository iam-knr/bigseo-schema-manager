<?php
/**
 * Schema Injector Class
 *
 * Handles injection of JSON-LD schema markup into wp_head
 *
 * @package BigSEO_Schema_Manager
 */

if (!defined('ABSPATH')) {
    exit;
}

class BigSEO_Injector {

    private $generator;

    public function __construct() {
        $this->generator = new BigSEO_Generator();
    }

    public function init_hooks() {
        add_action('wp_head', array($this, 'inject_schema'), 1);
    }

    /**
     * Inject schema into wp_head
     */
    public function inject_schema() {
        if (!is_singular()) {
            return;
        }

        $post_id = get_the_ID();
        
        // Check if schema is enabled for this post
        $enabled = get_post_meta($post_id, '_bigseo_enable_schema', true);
        if ($enabled !== '1') {
            return;
        }

        // Get schema type and data
        $schema_type = get_post_meta($post_id, '_bigseo_schema_type', true);
        $schema_data = get_post_meta($post_id, '_bigseo_schema_data', true);

        if (empty($schema_type) || empty($schema_data)) {
            return;
        }

        // Decode JSON data
        $schema_data = json_decode($schema_data, true);
        if (!$schema_data) {
            return;
        }

        // Generate JSON-LD
        $json_ld = $this->generator->generate($schema_type, $schema_data);

        if ($json_ld) {
            echo "\n<!-- BigSEO Schema Manager -->\n";
            echo '<script type="application/ld+json">' . "\n";
            echo $json_ld . "\n";
            echo '</script>' . "\n";
            echo "<!-- /BigSEO Schema Manager -->\n";
        }
    }

    /**
     * Inject breadcrumb schema (if enabled globally)
     */
    public function inject_breadcrumb_schema() {
        $enable_breadcrumbs = get_option('bigseo_enable_breadcrumbs', false);
        
        if (!$enable_breadcrumbs || !is_singular()) {
            return;
        }

        $post_id = get_the_ID();
        $breadcrumb_data = $this->generate_breadcrumb_data($post_id);
        
        if ($breadcrumb_data) {
            $json_ld = $this->generator->generate('breadcrumb', $breadcrumb_data);
            if ($json_ld) {
                echo "\n<!-- BigSEO Breadcrumb Schema -->\n";
                echo '<script type="application/ld+json">' . "\n";
                echo $json_ld . "\n";
                echo '</script>' . "\n";
                echo "<!-- /BigSEO Breadcrumb Schema -->\n";
            }
        }
    }

    /**
     * Generate breadcrumb data from post hierarchy
     */
    private function generate_breadcrumb_data($post_id) {
        $post = get_post($post_id);
        if (!$post) {
            return false;
        }

        $items = array();
        
        // Home page
        $items[] = array(
            'name' => get_bloginfo('name'),
            'url' => home_url('/')
        );

        // Parent pages/categories
        if ($post->post_parent) {
            $parent_ids = array_reverse(get_post_ancestors($post_id));
            foreach ($parent_ids as $parent_id) {
                $items[] = array(
                    'name' => get_the_title($parent_id),
                    'url' => get_permalink($parent_id)
                );
            }
        } elseif (get_post_type($post_id) === 'post') {
            $categories = get_the_category($post_id);
            if (!empty($categories)) {
                $category = $categories[0];
                $items[] = array(
                    'name' => $category->name,
                    'url' => get_category_link($category->term_id)
                );
            }
        }

        // Current page
        $items[] = array(
            'name' => get_the_title($post_id),
            'url' => get_permalink($post_id)
        );

        return array('items' => $items);
    }
}
