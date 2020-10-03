<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Woocci_zay_gateway class.
 *
 * @extends WC_Payment_Gateway
 */
class Woocci_zay_gateway extends WC_Payment_Gateway  {
	/**
	 * The delay between retries.
	 *
	 * @var int
	 */
	public $retry_interval;
	/**
	 * The title.
	 *
	 * @var int
	 */
	public $title;
	/**
	 * The method_description.
	 *
	 * @var int
	 */
	public $method_description;
	/**
	 * The description.
	 *
	 * @var int
	 */
	public $description;

	/**
	 * API access secret key
	 *
	 * @var string
	 */
	public $secret_key;
	/*
	 * API handler
	 */
	private $api;


	/**
	 * Constructor
	 */
	public function __construct() {
		$this->retry_interval = 1;
		$this->id             = 'woocci_zaytech';
		$this->method_title   = __( 'Clover Integration', 'zaytech_woocci' );
		$this->method_description = sprintf(  'Zaytech Woocommerce integration for Clover works by adding a payment option on the checkout page. This allows payments to be processed by your Clover Merchant Account. All orders can either auto print to your Clover POS or you can print them manually. Make accepting credit card payments simple with the Woocommerce Clover payment gateway. You can get the api key from this <a href="%1$s" target="_blank">link</a>', 'https://www.clover.com/oauth/authorize?client_id=6MWGRRXJD5HMW');
		$this->has_fields         = false;

		// Load the form fields.
		$this->init_form_fields();

		// Load the settings.
        $this->init_settings();

		$this->secret_key = $this->get_option( 'secret_key' );
		$this->title        = $this->get_option( 'title' );
		$this->enabled        = $this->get_option( 'enabled' );
        $this->description  = $this->get_option( 'description' );
        try{
	        $this->api = new Woocci_zaytech_api($this->secret_key);
        }catch (Woocci_Exception $e){
            echo $e->getMessage();
        }

		// Hooks.
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );


	}

	/**
	 * Checks if keys are set.
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public function are_keys_set() {
		if ( empty( $this->secret_key ) ) {
			return false;
		}

		return true;
	}
	/*
	 * Icons
	 */
    public function payment_icons() {
        return apply_filters(
            'woocci_payment_icons',
            array(
                'visa'       => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/visa.svg" class="stripe-visa-icon stripe-icon" alt="Visa" />',
                'amex'       => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/amex.svg" class="stripe-amex-icon stripe-icon" alt="American Express" />',
                'mastercard' => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/mastercard.svg" class="stripe-mastercard-icon stripe-icon" alt="Mastercard" />',
                'discover'   => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/discover.svg" class="stripe-discover-icon stripe-icon" alt="Discover" />',
                'diners'     => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/diners.svg" class="stripe-diners-icon stripe-icon" alt="Diners" />',
                'jcb'        => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/jcb.svg" class="stripe-jcb-icon stripe-icon" alt="JCB" />',
                'alipay'     => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/alipay.svg" class="stripe-alipay-icon stripe-icon" alt="Alipay" />',
                'wechat'     => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/wechat.svg" class="stripe-wechat-icon stripe-icon" alt="Wechat Pay" />',
                'bancontact' => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/bancontact.svg" class="stripe-bancontact-icon stripe-icon" alt="Bancontact" />',
                'ideal'      => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/ideal.svg" class="stripe-ideal-icon stripe-icon" alt="iDeal" />',
                'p24'        => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/p24.svg" class="stripe-p24-icon stripe-icon" alt="P24" />',
                'giropay'    => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/giropay.svg" class="stripe-giropay-icon stripe-icon" alt="Giropay" />',
                'eps'        => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/eps.svg" class="stripe-eps-icon stripe-icon" alt="EPS" />',
                'multibanco' => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/multibanco.svg" class="stripe-multibanco-icon stripe-icon" alt="Multibanco" />',
                'sofort'     => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/sofort.svg" class="stripe-sofort-icon stripe-icon" alt="SOFORT" />',
                'sepa'       => '<img src="' . WOOCCI_PLUGIN_URL . '/assets/images/sepa.svg" class="stripe-sepa-icon stripe-icon" alt="SEPA" />',
            )
        );
    }


	/**
	 * Get_icon function.
	 *
	 * @since 1.0.0
	 * @return string | void
	 */
	public function get_icon() {
		$icons = $this->payment_icons();

		$icons_str = '';

		$icons_str .= isset( $icons['visa'] ) ? $icons['visa'] : '';
		$icons_str .= isset( $icons['amex'] ) ? $icons['amex'] : '';
		$icons_str .= isset( $icons['mastercard'] ) ? $icons['mastercard'] : '';

		//return apply_filters( 'woocommerce_gateway_icon', $icons_str, $this->id );
	}
	/**
	 * Initialise Gateway Settings Form Fields
	 */
	public function init_form_fields() {
		$this->form_fields = apply_filters('woocci_settings',array(
            'enabled'    => array(
                'title'       => __( 'Enable/Disable', 'zaytech_woocci' ),
                'label'       => __( 'Enable', 'zaytech_woocci' ),
                'type'        => 'checkbox',
                'description' => '',
                'default'     => 'yes',
            ),
            'secret_key' => array(
                'title'       => __( 'API Key', 'zaytech_woocci' ),
                'type'        => 'password',
                'description' => __( 'Get your API key from your account.', 'zaytech_woocci' ),
                'default'     => '',
                'desc_tip'    => true,
            ),
            'title'       => array(
                'title'       => __( 'Title', 'zaytech_woocci' ),
                'type'        => 'text',
                'description' => __( 'This controls the title which the user sees during checkout.', 'zaytech_woocci' ),
                'default'     => __( 'Gateway for Clover', 'zaytech_woocci' ),
                'desc_tip'    => true,
            ),
            'description'       => array(
                'title'       => __( 'Description', 'zaytech_woocci' ),
                'type'        => 'text',
                'description' => __( 'This controls the title which the user sees during checkout.', 'zaytech_woocci' ),
                'default'     => __( 'You will be taken to a secure checkout page to enter credit card information.', 'zaytech_woocci' ),
                'desc_tip'    => true,
            )
        ));

	}


    /**
     * Gets the locale with normalization that only Stripe accepts.
     *
     * @since 1.0.0
     * @return string $locale
     */
    public function get_locale() {
        $locale = get_locale();
        if ( 'NO' === substr( $locale, 3, 2 ) ) {
            $locale = 'no';
        } else {
            $locale = substr( get_locale(), 0, 2 );
        }

        return $locale;
    }

	/**
	 * Process the payment
	 * @return array
	 */
	public function process_payment( $order_id ) {
		try {
			global $woocommerce;
			$order = new WC_Order( $order_id );
			$discount = $order->get_total_discount();
			$cloverDiscount = null;
			if($discount > 0) {
				$discountName = "Coupons : - ";
				foreach( $order->get_used_coupons() as $coupon_name ){
					$discountName .= $coupon_name. '-';
				}
				$cloverDiscount = array(
					"value"=>$discount,
					"type"=>"amount",
					"name"=>$discountName
				);
			}

            $merchant_website = $this->get_return_url($order);
            $callback_url = add_query_arg( 'wc-api', 'woocci_zaytech', home_url( '/' ) );
			$cloverOrder = array (
			        "note"=>'Smart Online Order | Via WooCommerce | '. $order->get_billing_first_name() .' '.$order->get_billing_last_name(),
                    "OrderType"=>"default",
                    "paymentmethod"=>"scp",
                    "taxAmount"=>$order->get_total_tax(),
                    "total"=>$order->get_total(),
					"source"=>"woo",
                    "instructions"=>Woocci_Helper::woocci_get_wc_order_notes($order_id)
            );

			if( $order->has_shipping_address() ) {
			    $cloverOrder["deliveryfee"] = $order->calculate_shipping();
				$cloverOrder["deliveryName"]= $order->get_shipping_method();
            }

			$orderCreated = json_decode($this->api->createOrder($cloverOrder),true);
			if(!$orderCreated){
				return array(
					'result'   => 'fail',
					'redirect' => '',
				);
			}
			// Update teh order after creation with personal information liek redirect url and customer info

            $note = array(
                "customer"=>array(
                    "oid"=>$orderCreated['id'],
                    "name"=>$order->get_billing_first_name() .' '.$order->get_billing_last_name(),
                    "phone"=>$order->get_billing_phone(),
                    "email"=>$order->get_billing_email(),
                    "address"=> array(
                        "address1"=>$order->get_billing_address_1(),
                        "zip"=>$order->get_billing_postcode(),
                        "city"=>$order->get_billing_city(),
                        "state"=>$order->get_billing_state(),
                        "country"=>$order->get_billing_country()
                    )
                ),
                'site_url'=>$merchant_website,
                'redirect_with_order_number'=>false,
                'redirect_url'=>$this->get_return_url( $order ),
                'woo_commerce_response'=>$callback_url,
                "orderWebRef"=>$order_id
            );
			$result = json_decode($this->api->updateOrderNote($orderCreated['id'],json_encode($note)));

			foreach ($order->get_items() as $item_id => $item_data) {
				// Get an instance of corresponding the WC_Product object
				$product = $item_data->get_product();
				$product_name  = $product->get_name(); // Get the product name
                $product_price = $product->get_price();
				$item_quantity = $item_data->get_quantity(); // Get the item quantity
                $this->api->addlineWithPriceToOrder($orderCreated['id'],$item_quantity,$product_name,$product_price);
			}
			if( $order->has_shipping_address() ) {
				$this->api->addlineWithPriceToOrder($orderCreated['id'],1,$cloverOrder["deliveryName"],$cloverOrder["deliveryfee"]);
			}
			//add the discounts
			if( $cloverDiscount ) {
				 $this->api->addDiscountToOrder($orderCreated['id'],$cloverDiscount);
			}
			//ASSIGNE CUSTOMER
            $this->api->assignCustomer($note["customer"]);

			// Mark as on-hold (we're awaiting the cheque)
			//$order->update_status('on-hold', __( 'Awaiting online payment', 'woocommerce' ));

			// Reduce stock levels
			//$order->reduce_order_stock();
			wc_reduce_stock_levels($order_id);

			// Remove cart
			$woocommerce->cart->empty_cart();

			Woocci_Logger::log( sprintf( 'Redirecting to Secure Checkout page for order %s', $order_id ) );

			$order->add_order_note("Order created in Clover with the id : ".$orderCreated['id']);

			if(isset($result->merchant)) {
				$url = $this->api->getPaymentUrl().strtolower($orderCreated['merchant']).'/'.strtolower($orderCreated['id']);
				return array(
					'result' => 'success',
					'redirect' => $url
				);
			} else {
			  throw new Woocci_Exception('Error in payment, please contact us') ;
			}


		} catch ( Woocci_Exception $e ) {
			wc_add_notice( $e->getLocalizedMessage(), 'error' );
            Woocci_Logger::log( 'Error: ' . $e->getMessage() );
			/* translators: error message */
			$order->update_status( 'failed' );
			return array(
				'result'   => 'fail',
				'redirect' => '',
			);
		}
	}

}
