<?php
/**
 * Plugin Name: Custom Product Card By SyntaxSurge
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

// Shortcode [product_card link="" img1="" img2="" name="" show_tag="true"]
function cpc_shortcode($atts) {
    // Ensure all attributes are sanitized
    $atts = shortcode_atts(
        array(
            'link' => 'https://syntaxsurge.com',
            'img1' => '',
            'img2' => '',
            'name' => 'Sample Product Name',
            'show_tag' => 'true'
        ),
        $atts,
        'product_card'
    );

    // Sanitize and validate data before output
    $link = esc_url($atts['link']);
    $img1 = esc_url($atts['img1']);
    $img2 = esc_url($atts['img2']);
    $name = sanitize_text_field($atts['name']);
    $show_tag = filter_var($atts['show_tag'], FILTER_VALIDATE_BOOLEAN); // converting to boolean

    ob_start();
    ?>
    <a href="<?php echo $link; ?>" class="product-card-link" target="_blank">
        <div class="product-card">
            <?php 
            // Check if tag should be displayed
            if($show_tag) : 
            ?>
                <div class="recommendation-tag">RECOMMENDED PRODUCT</div>
            <?php 
            endif; 
            ?>
            <div class="product-content">
                <div class="product-images">
                    <?php 
                    // Check if img1 is provided and render image
                    if (!empty($img1)) : 
                    ?>
                        <img src="<?php echo $img1; ?>" alt="Product 1">
                    <?php 
                    endif; 

                    // Check if img2 is provided and render image
                    if (!empty($img2)) : 
                    ?>
                        <img src="<?php echo $img2; ?>" alt="Product 2">
                    <?php 
                    endif; 
                    ?>
                </div>
                <div class="product-name"><?php echo esc_html($name); ?></div>
            </div>
        </div>
    </a>
    <?php
    return ob_get_clean();
}
add_shortcode('product_card', 'cpc_shortcode');
