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
$hi = $_POST['product_id'];
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
        echo $hi;

        die();
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