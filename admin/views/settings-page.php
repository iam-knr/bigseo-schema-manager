<?php
/**
 * Settings page view template for global schema configuration.
 *
 * @package    BigSEO_Schema_Manager
 * @subpackage BigSEO_Schema_Manager/admin/views
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <div class="bigseo-schema-settings-wrap">
        <div class="bigseo-settings-header">
            <p class="description">
                <?php esc_html_e( 'Configure global schema markup that applies to every page on your site (e.g., Organization, WebSite, Breadcrumbs).', 'bigseo-schema-manager' ); ?>
            </p>
        </div>

        <div class="bigseo-tabs-wrapper">
            <nav class="nav-tab-wrapper">
                <a href="#global-schema" class="nav-tab nav-tab-active">
                    <?php esc_html_e( 'Global Schema', 'bigseo-schema-manager' ); ?>
                </a>
                <a href="#documentation" class="nav-tab">
                    <?php esc_html_e( 'Documentation', 'bigseo-schema-manager' ); ?>
                </a>
            </nav>

            <div id="global-schema" class="tab-content active">
                <!-- React app mount point -->
                <div id="bigseo-global-schema-root"></div>
                
                <div class="bigseo-save-section">
                    <button type="button" id="bigseo-save-global" class="button button-primary button-large">
                        <?php esc_html_e( 'Save Global Schema', 'bigseo-schema-manager' ); ?>
                    </button>
                    <span class="spinner"></span>
                    <span class="bigseo-save-message"></span>
                </div>
            </div>

            <div id="documentation" class="tab-content">
                <div class="bigseo-docs-panel">
                    <h2><?php esc_html_e( 'Plugin Documentation', 'bigseo-schema-manager' ); ?></h2>
                    
                    <div class="bigseo-doc-section">
                        <h3><?php esc_html_e( 'Supported Schema Types', 'bigseo-schema-manager' ); ?></h3>
                        <p><?php esc_html_e( 'This plugin supports 27+ schema types including:', 'bigseo-schema-manager' ); ?></p>
                        <ul class="bigseo-schema-list">
                            <li><strong><?php esc_html_e( 'Content:', 'bigseo-schema-manager' ); ?></strong> Article, BlogPosting, NewsArticle, WebPage</li>
                            <li><strong><?php esc_html_e( 'Business:', 'bigseo-schema-manager' ); ?></strong> LocalBusiness, Organization, Restaurant, Store</li>
                            <li><strong><?php esc_html_e( 'E-commerce:', 'bigseo-schema-manager' ); ?></strong> Product, Offer, AggregateOffer</li>
                            <li><strong><?php esc_html_e( 'Reviews:', 'bigseo-schema-manager' ); ?></strong> Review, AggregateRating</li>
                            <li><strong><?php esc_html_e( 'Knowledge:', 'bigseo-schema-manager' ); ?></strong> FAQPage, HowTo, Recipe, Course</li>
                            <li><strong><?php esc_html_e( 'Media:', 'bigseo-schema-manager' ); ?></strong> VideoObject, ImageObject, AudioObject</li>
                            <li><strong><?php esc_html_e( 'Technical:', 'bigseo-schema-manager' ); ?></strong> BreadcrumbList, WebSite</li>
                            <li><strong><?php esc_html_e( 'Jobs:', 'bigseo-schema-manager' ); ?></strong> JobPosting</li>
                        </ul>
                    </div>

                    <div class="bigseo-doc-section">
                        <h3><?php esc_html_e( 'How to Use', 'bigseo-schema-manager' ); ?></h3>
                        <ol>
                            <li><?php esc_html_e( 'Edit any post or page', 'bigseo-schema-manager' ); ?></li>
                            <li><?php esc_html_e( 'Scroll to the "Schema Markup (JSON-LD)" meta box', 'bigseo-schema-manager' ); ?></li>
                            <li><?php esc_html_e( 'Select a schema type from the dropdown', 'bigseo-schema-manager' ); ?></li>
                            <li><?php esc_html_e( 'Fill in the required fields', 'bigseo-schema-manager' ); ?></li>
                            <li><?php esc_html_e( 'Save or publish your post', 'bigseo-schema-manager' ); ?></li>
                            <li><?php esc_html_e( 'Test with Google Rich Results Test', 'bigseo-schema-manager' ); ?></li>
                        </ol>
                    </div>

                    <div class="bigseo-doc-section">
                        <h3><?php esc_html_e( 'Resources', 'bigseo-schema-manager' ); ?></h3>
                        <ul>
                            <li>
                                <a href="https://schema.org/" target="_blank" rel="noopener">
                                    <?php esc_html_e( 'Schema.org Documentation', 'bigseo-schema-manager' ); ?>
                                </a>
                            </li>
                            <li>
                                <a href="https://search.google.com/test/rich-results" target="_blank" rel="noopener">
                                    <?php esc_html_e( 'Google Rich Results Test', 'bigseo-schema-manager' ); ?>
                                </a>
                            </li>
                            <li>
                                <a href="https://developers.google.com/search/docs/appearance/structured-data/intro-structured-data" target="_blank" rel="noopener">
                                    <?php esc_html_e( 'Google Structured Data Guide', 'bigseo-schema-manager' ); ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bigseo-schema-settings-wrap {
    max-width: 1200px;
    margin-top: 20px;
}
.bigseo-settings-header {
    background: #fff;
    padding: 20px;
    border: 1px solid #ccd0d4;
    margin-bottom: 20px;
}
.bigseo-tabs-wrapper {
    background: #fff;
    border: 1px solid #ccd0d4;
}
.tab-content {
    display: none;
    padding: 20px;
}
.tab-content.active {
    display: block;
}
.bigseo-save-section {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #ddd;
}
.bigseo-save-section .spinner {
    float: none;
    margin: 0 10px;
}
.bigseo-save-message {
    color: #46b450;
    font-weight: 600;
}
.bigseo-docs-panel {
    max-width: 900px;
}
.bigseo-doc-section {
    margin-bottom: 30px;
}
.bigseo-schema-list {
    list-style: disc;
    margin-left: 20px;
}
</style>
