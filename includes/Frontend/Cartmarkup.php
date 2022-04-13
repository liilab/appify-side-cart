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
        add_action( 'wp_ajax_update_cart', [$this, 'update_cart'] );
        add_action( 'wp_ajax_nopriv_update_cart', [$this, 'update_cart'] );
        add_action( 'wp_enqueue_scripts', [$this, 'ajax_add_to_cart_js'] );
        add_action( 'wp_enqueue_scripts', [$this, 'ajax_update_cart_js'] );
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
    public function ajax_update_cart_js()
    {
            wp_enqueue_script( 'ajax_custom_scrip', LII_AJAXCART_ASSETS . '/ajax_update_cart.js', array( 'jquery' ) );
            wp_localize_script(
                'ajax_custom_scrip',
                'script_var',
                array(
                    'ajax_ur' => '?wc-ajax=get_refreshed_fragments',
                )
            );
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

    public function update_cart()
    {
        ob_start();

		woocommerce_mini_cart();

		$mini_cart = ob_get_clean();

		$data = array(
			'fragments' => apply_filters(
				'woocommerce_add_to_cart_fragments',
				array(
					'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
				)
			),
			'cart_hash' => WC()->cart->get_cart_hash(),
		);

		wp_send_json( $data );
    }
}
