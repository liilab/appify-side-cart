<?php

namespace ajax\cart\Frontend;

if (!defined('ABSPATH')) {
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

        if (!$instance) {
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
        add_action('wc_ajax_lii_ajaxcart_add_to_cart', [$this, 'update_item_quantity']);
        add_filter('woocommerce_add_to_cart_fragments', [$this, 'set_ajax_fragments']);
        // add_action('wp_print_scripts', function(){
        //     wp_dequeue_script( 'wc-cart-fragments' );
        //     return true;
        // });
        // add_action('wp_enqueue_scripts', function () {
        //     global $woocommerce;

        //     $suffix = defined('SCRIPT_DEBUG') ?: '.min';
        //     wp_deregister_script('jquery-cookie');
        //     wp_register_script('jquery-cookie', $woocommerce->plugin_url() . '/assets/js/jquery-cookie/jquery_cookie' . $suffix . '.js', array('jquery'), '1.3.1', true);
        // });
    }



    /**
     * Create Fragment
     *
     */

    public function set_ajax_fragments($fragments)
    {
        $fragments['span.lii-cart-count']     = '<span class="lii-cart-count">' . count(WC()->cart->get_cart()) . '</span>';
        $fragments['span.lii-subtotal-price'] = '<span class="lii-subtotal-price">' . WC()->cart->get_cart_subtotal() . '</span>';
        $fragments['span.lii-shipping-price'] = '<span class="lii-shipping-price">' . WC()->cart->get_shipping_total() . '</span>';
        $fragments['span.lii-total-price']    = '<span class="lii-total-price">' . WC()->cart->get_total() . '</span>';

        ob_start();
        require LII_AJAXCART_DIR_PATH . 'templates/main-contents.php';
        $fragments['div.lii-main-contents'] = ob_get_clean();

        return $fragments;
    }

    /**
     * Add to Cart Action
     */

    public function update_item_quantity()
    {
        $cart_key     = sanitize_text_field($_POST['cart_key']);
        $new_qty     = (float) $_POST['qty'];

        if (!is_numeric($new_qty) || $new_qty < 0 || !$cart_key) {
            //$this->set_notice( __( 'Something went wrong', 'side-cart-woocommerce' ) );
        }

        $validated = apply_filters('lii_ajaxcart_update_quantity', true, $cart_key, $new_qty);

        if ($validated && !empty(WC()->cart->get_cart_item($cart_key))) {

            $updated = $new_qty == 0 ? WC()->cart->remove_cart_item($cart_key) : WC()->cart->set_quantity($cart_key, $new_qty);

            if ($updated) {

                if ($new_qty == 0) {

                    $notice = __('Item removed', 'side-cart-woocommerce');

                    $notice .= '<span class="xoo-wsc-undo-item" data-key="' . $cart_key . '">' . __('Undo?', 'side-cart-woocommerce') . '</span>';
                } else {
                    $notice = __('Item updated', 'side-cart-woocommerce');
                }

                //$this->set_notice( $notice, 'success' );

            }
        }

        \WC_AJAX::get_refreshed_fragments();
        die();
    }
}

/**
 * Initializes the class
 *
 * @return \Side_Cart
 */

function lii_ajaxcart_side_cart()
{
    return Side_Cart::init();
}

/**
 * Let's Go
 */
lii_ajaxcart_side_cart();
