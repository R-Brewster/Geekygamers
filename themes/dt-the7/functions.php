<?php
/**
 * The7 theme.
 *
 * @since   1.0.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since 1.0.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1200; /* pixels */
}

/**
 * Initialize theme.
 *
 * @since 1.0.0
 */
require trailingslashit( get_template_directory() ) . 'inc/init.php';
add_action( 'woocommerce_after_single_product_summary', 5 );
//add_action( 'woocommerce_after_single_product_summary' , 'bbloomer_add_below_prod_gallery', 5 );
 
/*function bbloomer_add_below_prod_gallery() {
   echo '<div class="woocommerce-product-gallery">';
   echo "<span>'Reward points obtainable from in-store purchases only.'</span>";
   echo '</div>';
}*/


add_action('woocommerce_before_cart', 'check_product_category_in_cart');
function check_product_category_in_cart() {
    // HERE set your product categories in the array (can be IDs, slugs or names)
    $categories = array('special');
    $found      = false; // Initializing

    // Loop o through cart items      
    foreach ( WC()->cart->get_cart() as $cart_item ) {
	   
	
        // If product categories is found
        if ( has_term( $categories, 'product_cat', $cart_item['product_id'] ) ) {


		
		
        }
    }

    // If any defined product category is found, we display a notice

}

/* 
add_filter( 'woocommerce_checkout_fields' , 'bbloomer_remove_billing_postcode_checkout' );
function bbloomer_remove_billing_postcode_checkout( $fields ) {
			unset($fields['billing']['billing_postcode']);
			return $fields;
		}*/
/* 		
function disable_shipping_calc_on_cart( $show_shipping ) {
    if( is_cart() ) {
        return false;
    }
    return $show_shipping;
}
add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99 );	
 */



?>