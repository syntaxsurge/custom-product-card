<?php
/**
 * Plugin Name: Custom Product Card
 * Plugin URI: https://syntaxsurge.com/product/custom-product-card
 * Description: A custom plugin to add a product card via a shortcode.
 * Version: 1.0
 * Author: SyntaxSurge
 * Author URI: https://syntaxsurge.com
 */

// Prevent direct file access
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Enqueue CSS
function cpc_enqueue_styles() {
    wp_enqueue_style('cpc_styles', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('wp_enqueue_scripts', 'cpc_enqueue_styles');

// Shortcode [product_card link="" img1="" img2="" name=""]
function cpc_shortcode($atts) {
    // Ensure all attributes are sanitized
    $atts = shortcode_atts(
        array(
            'link' => 'https://example.com',
            'img1' => '',
            'img2' => '',
            'name' => 'Sample Product Name',
        ),
        $atts,
        'product_card'
    );

    // Sanitize and validate data before output
    $link = esc_url($atts['link']);
    $img1 = esc_url($atts['img1']);
    $img2 = esc_url($atts['img2']);
    $name = sanitize_text_field($atts['name']);

    ob_start();
    ?>
    <a href="<?php echo $link; ?>" class="product-card-link" target="_blank">
        <div class="product-card">
            <div class="recommendation-tag">RECOMMENDED PRODUCT</div>
            <div class="product-content">
                <div class="product-images">
                    <img src="<?php echo $img1; ?>" alt="Product 1">
                    <img src="<?php echo $img2; ?>" alt="Product 2">
                </div>
                <div class="product-name"><?php echo esc_html($name); ?></div>
            </div>
        </div>
    </a>
    <?php
    return ob_get_clean();
}
add_shortcode('product_card', 'cpc_shortcode');
