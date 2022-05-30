<?php
namespace ajax\cart\Frontend;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Side_Cart
{

    /**
     * Initializes a singleton instance
     *
     * @return \Side_Cart
     */
    public static function init()
    {
        static $instance = false;

        if ( !$instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Construct Methods
     */

    public function __construct()
    {
        $this->hooks();
    }

    /**
     * Initialize All Necessary Wordpress Action/Filter Hook
     *
     */

    public function hooks()
    {
        add_action( 'wc_ajax_lii_ajaxcart_update_item_quantity', [$this, 'update_item_quantity'] );
    }


    public function update_item_quantity()
    {
        // GLOBAL $woocommerce;
        $id = $_POST['product_id'];
        echo $id;
        // $product = wc_get_product($id);

        // $carts= $woocommerce->cart;
        // //$hi = $carts['cart_contents'];
        // //print("<pre>".print_r( $carts,true)."</pre>");
        // //echo $hi;
        // //var_dump($carts[0]);
        // foreach ( $carts as $cart_item_keys => $cart_items ) {
        // 	//$products  		= apply_filters( 'woocommerce_cart_item_product', $cart_items['data'], $cart_items, $cart_item_keys );
        //     $name = $cart_items;
        //     break;
        // }
        // foreach($name as $nm){
        //     echo $nm["key"];
        // }
        // $id = $_POST['product_id'];
        // $new_qty = $_POST['quantity'];
        // global $woocommerce;
        // $items = $woocommerce->cart->get_cart();
    
            // foreach($items as $item => $values) { 
            //     $c_id= $values['product_id'];
            //     if($c_id==$id):
            //     $_product =  wc_get_product( $values['data']->get_id()); 
               
            //     WC()->cart->set_quantity( $item, $new_qty );
            //     echo "<b>".$_product->get_title().'</b>  <br> Quantity: '.$values['quantity'].'<br>'; 
            //     $price = get_post_meta($values['product_id'] , '_price', true);
            //     echo "  Price: ".$price."<br>";
            //     endif;
            // } 
            //echo '';

            //\WC_AJAX::get_refreshed_fragments();
        
//$hi=123;
        // $cart_key = sanitize_text_field( $_POST['cart_key'] );
        // $new_qty  = (float) $_POST['qty'];

        // if ( !is_numeric( $new_qty ) || $new_qty < 0 || !$cart_key ) {
        //     //$this->set_notice( __( 'Something went wrong', 'side-cart-woocommerce' ) );
        // }

        // $validated = apply_filters( 'lii_ajaxcart_update_quantity', true, $cart_key, $new_qty );

        // if ( $validated && !empty( WC()->cart->get_cart_item( $cart_key ) ) ) {

        //     $updated = $new_qty == 0 ? WC()->cart->remove_cart_item( $cart_key ) : WC()->cart->set_quantity( $cart_key, $new_qty );

        //     if ( $updated ) {

        //         if ( $new_qty == 0 ) {

        //             $notice = __( 'Item removed', 'side-cart-woocommerce' );

        //             $notice .= '<span class="xoo-wsc-undo-item" data-key="' . $cart_key . '">' . __( 'Undo?', 'side-cart-woocommerce' ) . '</span>';

        //         } else {
        //             $notice = __( 'Item updated', 'side-cart-woocommerce' );
        //         }

        //         //$this->set_notice( $notice, 'success' );

        //     }
        // }

        //$this->get_refreshed_fragments();
       

        //die();
    }
}

/**
 * Initializes the class
 *
 * @return \Side_Cart
 */
function lii_ajaxcart_side_cart(){
	return Side_Cart::init();
}

/**
 * Let's Go
 */
lii_ajaxcart_side_cart();