<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Provides static methods as helpers.
 *
 * @since 1.0.0
 */
class Woocci_Helper {
    public static function woocci_get_wc_order_notes( $order_id){
        //make sure it's a number
        $order_id = intval($order_id);
        //get the post
        $post = get_post($order_id);
        //if there's no post, return as error
        if (!$post) return '';

        return $post->post_excerpt;
    }
}
