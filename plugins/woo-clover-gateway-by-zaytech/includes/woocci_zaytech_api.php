<?php

class Woocci_zaytech_api {

    /**
     * Your unique access token to link you store with your Clover POS
     * see How it works section for more information
     * or visit smartonlineorder.com
     * @var string
     */
    private $accessToken;
    /**
     * An API service Provided by Zaytechapps that will create the order for you in your Clover POS
     * and will allow you accept payments directly in your MMerchant account
     * @var string
     */
    public $api_url;

    /**
     * Set it to true to enable debug mode and see the API response
     * @var bool
     */
    public $debug = false;


    function __construct($token) {
        if(isset( $token )) {
            $this->accessToken = $token;
        } else {
            throw new Woocci_Exception("Api key required");
        }
        /**
         * put here the api url
         * to use teh sandbox envorement
         * change it https://api-sandbox.smartonlineorders.com/
         */
        $this->api_url = "https://api.smartonlineorders.com/";
    }

    /**
     * The payment page url
     * We use an external page as an option for website without SSL
     * @return string
     */
    public function getPaymentUrl() {
        return "https://checkout.smartonlineorder.com/pay/";
    }

    /**
     * For future usage, this function will return teh keys to crypt teh card information when we will add the
     * direct payments feature
     * @return bool|array
     */
    public function getPayKey() {
        return $this->apiGet("paykey");

    }

    /**
     *  To update the order note on Clover POS
     * @param $orderId
     * @param $note
     * @return bool
     */
    public function updateOrderNote($orderId,$note) {
        $data = array(
            "note"=>$note
        );
        return $this->apiPost("update_local_order/".$orderId,$data);
    }

    /**
     * To create new order on CLover POS
     * @param $data // Order information
     * @return bool|mixed
     */
    public function createOrder($data){
        return $this->apiPost("create_order",$data);
    }

    /**
     * Assigne customer to the order
     * @param $customer
     * @return bool|mixed
     */
    public function assignCustomer($customer) {
        $data = array(
            "customer" => json_encode($customer)
        );
        $res =  $this->apiPost("assign_customer",$data);
        return $res;
    }

    /**
     * Add lines to Clover Order
     * @param $order_id
     * @param $qte
     * @param $name
     * @param $price
     * @return bool|mixed
     */
    public function addlineWithPriceToOrder($order_id,$qte,$name,$price) {
        $data = array(
          "oid"=>$order_id,
          "qte"=>$qte,
          "itemName"=>$name,
          "itemprice"=>$price,
        );
        return $this->apiPost("create_line_in_order",$data);
    }

    /**
     * Apply coupons on the order
     * @param $order_id
     * @param $discount
     * @return bool|mixed
     */
	public function addDiscountToOrder($order_id,$discount)
	{
	    $data = array(
	      "orderId"  => $order_id,
	      "discount"  => json_encode($discount),

        );
		return $this->apiPost("discounts/add",$data);
	}

    /**
     * To send get request to our Zaytech API
     * @param $url
     * @return bool|array
     */
    private function apiGet($url) {
        $args = array(
            "headers"=> array(
                "Accept"=>"application/json",
                "X-Authorization"=>$this->accessToken,
            )
        );
        $url = $this->api_url.$url;
        $response = wp_remote_get($url,$args);
        if ( is_array( $response ) ) {
            if($response["response"]["code"] === 200)
                return $response['body'];
        }
        return false;
    }

    /**
     * To send post requests to Zaytech api
     * @param $url
     * @param $data
     * @return bool|mixed
     */
    private function apiPost($url, $data) {
        $args = array(
            "headers" => array(
                "Accept"=>"application/json",
                "X-Authorization"=>$this->accessToken,
            ),
            "body" => $data
        );
        $url = $this->api_url.$url;
        $response = wp_remote_post($url,$args);
        if ( is_array( $response ) ) {
            if($response["response"]["code"] === 200)
                return $response['body'];
        }
        return false;
    }

}