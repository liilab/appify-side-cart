<?php
namespace ajax\cart\Frontend;

/**
 * The Cart Handler Cart
 */
class CartMarkup
{
    /**
     * Initialize the class
     */

    public function __construct()
    {
        add_action( 'wp_ajax_frontend_cart', [$this, 'frontend_cart'] );
        add_action( 'wp_ajax_nopriv_frontend_cart', [$this, 'frontend_cart'] );
        add_action( 'wp_enqueue_scripts', [$this, 'ajax_add_to_cart_js'] );
    }

    /**
     * Enqueue Ajax Scripts
     *
     * @return void
     */

    public function ajax_add_to_cart_js()
    {
        if ( function_exists( 'is_product' ) && is_product() ) {
            wp_enqueue_script( 'ajax_custom_script', LII_AJAXCART_ASSETS . '/ajax_add_to_cart.js', array( 'jquery' ) );
            wp_localize_script(
                'ajax_custom_script',
                'script_vars',
                array(
                    'ajax_url' => '?wc-ajax=add_to_cart',
                )
            );
        }
    }

    /**
     * WP Ajax Frontend Action
     *
     * @return void
     */

    public function frontend_cart()
    {
        $product_id        = apply_filters( 'lii_woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
        $quantity          = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( $_POST['quantity'] );
        $variation_id      = absint( $_POST['variation_id'] );
        $passed_validation = apply_filters( 'lii_woocommerce_add_to_cart_validation', true, $product_id, $quantity );
        $product_status    = get_post_status( $product_id );
        if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id ) && 'publish' === $product_status ) {
            do_action( 'lii_woocommerce_ajax_added_to_cart', $product_id );
            if ( 'yes' === get_option( 'ql_woocommerce_cart_redirect_after_add' ) ) {
                wc_add_to_cart_message( array( $product_id => $quantity ), true );
            }
            //WC_AJAX::get_refreshed_fragments();
        } else {
            $data = array(
                'error'       => true,
                'product_url' => apply_filters( 'lii_woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ) );
            echo wp_send_json( $data );
        }
        wp_die();
    }
}
