<?php
/**
 * Meta box view template for per-page schema editor.
 * This is the HTML shell where the React SchemaBuilder component mounts.
 *
 * @package    BigSEO_Schema_Manager
 * @subpackage BigSEO_Schema_Manager/admin/views
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="bigseo-schema-metabox-wrapper">
    <div class="bigseo-notice">
        <p>
            <?php esc_html_e( 'Add structured data (JSON-LD schema) to this page to help search engines understand your content better.', 'bigseo-schema-manager' ); ?>
        </p>
    </div>

    <!-- React app mount point -->
    <div id="bigseo-schema-builder-root"></div>

    <!-- Hidden input to store schema data (synced by React before save) -->
    <input 
        type="hidden" 
        name="bigseo_schema_data" 
        id="bigseo-schema-data" 
        value="<?php echo esc_attr( wp_json_encode( $existing_schemas ) ); ?>" 
    />

    <div class="bigseo-help-text">
        <p>
            <?php
            printf(
                /* translators: %s: Google Rich Results Test URL */
                esc_html__( 'After publishing, test your schema with %s.', 'bigseo-schema-manager' ),
                '<a href="https://search.google.com/test/rich-results" target="_blank" rel="noopener">' . esc_html__( 'Google Rich Results Test', 'bigseo-schema-manager' ) . '</a>'
            );
            ?>
        </p>
    </div>
</div>

<style>
.bigseo-schema-metabox-wrapper {
    padding: 15px;
    background: #fff;
}
.bigseo-notice {
    padding: 12px;
    background: #e7f5fe;
    border-left: 4px solid #0073aa;
    margin-bottom: 20px;
}
.bigseo-notice p {
    margin: 0;
    font-size: 13px;
}
.bigseo-help-text {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #ddd;
    font-size: 12px;
    color: #666;
}
.bigseo-help-text p {
    margin: 0;
}
</style>
