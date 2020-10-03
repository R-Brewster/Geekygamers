<?php
/**
 * Plugin Name: WooCommerce Clover Payment Gateway by Zaytech
 * Plugin URI: https://wordpress.org/plugins/woo-clover-gateway-by-zaytech/
 * Description: Process payments by your Clover Merchant Account and auto print teh orders to your Clover POS.
 * Author: Zaytech
 * Author URI: https://zaytechapps.com/
 * Version: 1.2.1
 * Requires at least: 4.4
 * Tested up to: 5.0
 * WC requires at least: 3.0
 * WC tested up to: 3.5
 * Text Domain: zaytech_woocci
 * Domain Path: /languages
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * WooCommerce requirement.
 */
function zaytech_woocci_missing_wc_notice() {
    /* translators: 1. URL link. */
    echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'we require WooCommerce to be installed and active. You can download %s here.', 'zaytech_woocci' ), '<a href="https://woocommerce.com/" target="_blank">WooCommerce</a>' ) . '</strong></p></div>';
}

add_action( 'plugins_loaded', 'zaytech_woocci_init' );
function zaytech_woocci_init() {
    load_plugin_textdomain( 'zaytech_woocci', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

    if ( ! class_exists( 'WooCommerce' ) ) {
        add_action( 'admin_notices', 'zaytech_woocci_missing_wc_notice' );
        return;
    }

    if ( ! class_exists( 'Woocci_Zaytech' ) ) :
        /**
         * Required minimums and constants
         */
        define( 'WOOCCI_VERSION', '1.2.1' );
        define( 'WOOCCI_MIN_PHP_VER', '5.6.0' );
        define( 'WOOCCI_MIN_WC_VER', '3.0.0' );
        define( 'WOOCCI_MAIN_FILE', __FILE__ );
        define( 'WOOCCI_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
        define( 'WOOCCI_PLUGIN_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

        class Woocci_Zaytech {

            /**
             * @var Singleton The reference the *Singleton* instance of this class
             */
            private static $instance;

            /**
             * Returns the *Singleton* instance of this class.
             *
             * @return Singleton The *Singleton* instance.
             */
            public static function get_instance() {
                if ( null === self::$instance ) {
                    self::$instance = new self();
                }
                return self::$instance;
            }

            /**
             * Private clone method to prevent cloning of the instance of the
             * *Singleton* instance.
             *
             * @return void
             */
            private function __clone() {}

            /**
             * Private unserialize method to prevent unserializing of the *Singleton*
             * instance.
             *
             * @return void
             */
            private function __wakeup() {}

            /**
             * Protected constructor to prevent creating a new instance of the
             * *Singleton* via the `new` operator from outside of this class.
             */
            private function __construct() {
                add_action( 'admin_init', array( $this, 'install' ) );
                $this->init();
            }

            /**
             * Init the plugin after plugins_loaded so environment variables are set.
             *
             * @since 1.0.0
             */
            public function init() {
                require_once dirname( __FILE__ ) . '/includes/woocci_Exception.php';
                require_once dirname( __FILE__ ) . '/includes/woocci_Logger.php';
                require_once dirname( __FILE__ ) . '/includes/woocci_Helper.php';
                include_once dirname( __FILE__ ) . '/includes/woocci_zaytech_api.php';
                require_once dirname( __FILE__ ) . '/includes/woocci_zay_gateway.php';


                add_filter( 'woocommerce_payment_gateways', array( $this, 'add_gateways' ) );

                add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );

	            add_action( 'woocommerce_api_'. strtolower( get_class($this) ), array( $this, 'callback_handler' ) );

            }

            /**
             * Updates the plugin version in db
             *
             * @since 1.0
             */
            public function update_plugin_version() {
                delete_option( 'wooccii_zaytech_version' );
                update_option( 'wooccii_zaytech_version', WOOCCI_VERSION );
            }

            /**
             * Handles upgrade routines.
             *
             * @since 1.0.0
             */
            public function install() {
                if ( ! is_plugin_active( plugin_basename( __FILE__ ) ) ) {
                    return;
                }

                if ( ! defined( 'IFRAME_REQUEST' ) && ( WOOCCI_VERSION !== get_option( 'woocci_version' ) ) ) {
                    do_action( 'woocci_updated' );

                    if ( ! defined( 'WOOCCI_INSTALLING' ) ) {
                        define( 'WOOCCI_INSTALLING', true );
                    }

                    $this->update_plugin_version();
                }
            }

            /**
             * Adds plugin action links.
             * @since 1.0.0
             */
            public function plugin_action_links( $links ) {
                $plugin_links = array(
                    '<a href="admin.php?page=wc-settings&tab=checkout&section=woocci_zaytech">Settings</a>'
                );
                return array_merge( $plugin_links, $links );
            }

            /**
             * Add the gateways to WooCommerce.
             *
             * @since 1.0.0
             */
            public function add_gateways( $methods ) {
                $methods[] = 'Woocci_zay_gateway';
                return $methods;
            }
            /**
             * Check the payment response.
             */
            public function callback_handler( ) {
	            $raw_post = file_get_contents( 'php://input' );
	            $decoded  = json_decode( $raw_post );
	            if(isset($decoded->woo_order)) {
		            $order = new WC_Order( $decoded->woo_order );
		            if($order) {
			            if(isset($decoded->payment_status)) {
				            if( $decoded->payment_status == "APPROVED" ) {
								$order->payment_complete();
								$order->add_order_note('Payment accepted by Clover, the payment ID is '.$decoded->payment_uuid);
				            } else {
					            if( $decoded->payment_status == "FAILED" ) {
						            $order->update_status('failed');
					            }
				            }
			            }
		            } else {
						Woocci_Logger::log("Received a payment status for an order does not exist : ".$decoded->order_id);
		            }
	            }
	           die();
            }
        }

        Woocci_Zaytech::get_instance();
    endif;
}