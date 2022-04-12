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
        // add_shortcode( 'thepost', [$this, 'render_shortcode'] );
        add_action( 'wp_enqueue_scripts', [$this, 'ql_woocommerce_ajax_add_to_cart_js'] );
    }

    public function ql_woocommerce_ajax_add_to_cart_js()
    {
        if ( function_exists( 'is_product' ) && is_product() ) {
            wp_enqueue_script( 'ajax_custom_script', LII_AJAXCART_ASSETS . '/main.js', array( 'jquery' ));
            wp_localize_script(
                'ajax_custom_script', 
                'pw_script_vars', 
                array(
                    // 'ajax_url' => admin_url('?wc-ajax=add_to_cart'),
                    'ajax_url' => '?wc-ajax=add_to_cart',
                )
            );
        }
    }

    public function frontend_cart()
    {
        $product_id        = apply_filters( 'ql_woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
        $quantity          = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( $_POST['quantity'] );
        $variation_id      = absint( $_POST['variation_id'] );
        $passed_validation = apply_filters( 'ql_woocommerce_add_to_cart_validation', true, $product_id, $quantity );
        $product_status    = get_post_status( $product_id );
        if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id ) && 'publish' === $product_status ) {
            do_action( 'ql_woocommerce_ajax_added_to_cart', $product_id );
            if ( 'yes' === get_option( 'ql_woocommerce_cart_redirect_after_add' ) ) {
                wc_add_to_cart_message( array( $product_id => $quantity ), true );
            }
            //WC_AJAX::get_refreshed_fragments();
           // WC_AJAX::add_to_cart();
        } else {
            $data = array(
                'error'       => true,
                'product_url' => apply_filters( 'ql_woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ) );
            echo wp_send_json( $data );
        }
        wp_die();
    }
}
