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
        add_action( 'wp_footer', [$this, 'frontend_markup'] );
        add_filter( 'woocommerce_add_to_cart_fragments', [$this, 'iconic_cart_count_fragments'], 10, 1 );
    }

    /**
     * Enqueue Ajax Scripts
     *
     * @return void
     */


    function iconic_cart_count_fragments( $fragments ) {
        
        $fragments['span.lii-cart-count'] = '<span class="lii-cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
        
        return $fragments;
        
    }

    public function frontend_markup()
    {
      require_once LII_AJAXCART_DIR_PATH . 'assets/front.php';
    }

    /**
     * Enqueue All Scripts
     */

    public function ajax_add_to_cart_js()
    {
        wp_enqueue_style( 'bootstrap-css','//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' );
        wp_enqueue_style( 'main-css', LII_AJAXCART_ASSETS . '/css/style.css' );
        wp_enqueue_style( 'bootstrap-icon-css', '//cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css' );
        wp_enqueue_script( 'main-js', LII_AJAXCART_ASSETS . '/js/main.js', array( 'jquery' ));
        wp_enqueue_script( 'bootstrap-js', '//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', true );
        
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
        ob_start();

        // phpcs:disable WordPress.Security.NonceVerification.Missing
        if ( !isset( $_POST['product_id'] ) ) {
            return;
        }

        $product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
        $product           = wc_get_product( $product_id );
        $quantity          = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( wp_unslash( $_POST['quantity'] ) );
        $passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
        $product_status    = get_post_status( $product_id );
        $variation_id      = 0;
        $variation         = array();

        if ( $product && 'variation' === $product->get_type() ) {
            $variation_id = $product_id;
            $product_id   = $product->get_parent_id();
            $variation    = $product->get_variation_attributes();
        }

        if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation ) && 'publish' === $product_status ) {

            do_action( 'woocommerce_ajax_added_to_cart', $product_id );

            if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
                wc_add_to_cart_message( array( $product_id => $quantity ), true );
            }

            self::get_refreshed_fragments();

        } else {

            // If there was an error adding to the cart, redirect to the product page to show any errors.
            $data = array(
                'error'       => true,
                'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
            );

            wp_send_json( $data );
        }
        // phpcs:enable
    }
}
