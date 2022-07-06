<?php

namespace ajax\cart\Frontend;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Side_Cart
{
    public $product_key;

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
        $this->shortcodes();
    }

    /**
     * Initialize All Necessary Wordpress Action/Filter Hook
     *
     */

    public function hooks()
    {
        add_filter('woocommerce_add_to_cart_fragments', [$this, 'set_ajax_fragments']);
        add_action('wc_ajax_lii_ajaxcart_apply_coupon', [$this, 'lii_apply_coupon']);
        add_action('wc_ajax_lii_ajaxcart_remove_coupon', [$this, 'lii_remove_coupon']);
        add_action('wc_ajax_lii_ajaxcart_add_to_cart', [$this, 'add_to_cart']);
        add_action('wc_ajax_lii_ajaxcart_update_item_quantity', [$this, 'update_item_quantity']);
    }
    /**
     * Initialize All Necessary Shortcodes
     *
     */
    public function shortcodes()
    {
        add_shortcode('coupon_field', [$this, 'lii_display_coupon_field']);
    }

    /**
     * Create Ajax Add To cart product add
     *
     */

    public function add_to_cart()
    {
        $product_id = apply_filters('lii_ajaxcart_woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
        $variation_id = absint($_POST['variation_id']);
        $passed_validation = apply_filters('lii_ajaxcart_woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $product_status = get_post_status($product_id);
        if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {
            do_action('lii_ajaxcart_woocommerce_ajax_added_to_cart', $product_id);
            if ('yes' === get_option('lii_ajaxcart_woocommerce_cart_redirect_after_add')) {
                wc_add_to_cart_message(array($product_id => $quantity), true);
            }


            \WC_AJAX::get_refreshed_fragments();
        } else {
            $data = array(
                'error' => true,
                'product_url' => apply_filters('lii_ajaxcart_woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
            );
            echo wp_send_json($data);
        }

        wp_die();
    }

    /**
     * Update Item Quantity Action
     */

    public function update_item_quantity()
    {
        $product_key     = sanitize_text_field($_POST['product_key']);
        $new_qty     = (float) $_POST['qty'];

        if (!is_numeric($new_qty) || $new_qty < 0 || !$product_key) {
            //$this->set_notice( __( 'Something went wrong', 'side-cart-woocommerce' ) );
        }

        $validated = apply_filters('lii_ajaxcart_update_quantity', true, $product_key, $new_qty);

        if ($validated && !empty(WC()->cart->get_cart_item($product_key))) {

            $updated = $new_qty == 0 ? WC()->cart->remove_cart_item($product_key) : WC()->cart->set_quantity($product_key, $new_qty);

            if ($updated) {

                if ($new_qty == 0) {

                    $notice = __('Item removed', 'side-cart-woocommerce');

                    $notice .= '<span class="xoo-wsc-undo-item" data-key="' . $product_key . '">' . __('Undo?', 'side-cart-woocommerce') . '</span>';
                } else {
                    $notice = __('Item updated', 'side-cart-woocommerce');
                }

                //$this->set_notice( $notice, 'success' );

            }
        }

        \WC_AJAX::get_refreshed_fragments();
        die();
    }

    /**
     * Display Coupon Field Action
     */

    public function lii_display_coupon_field()
    {
        if (isset($_GET['lii-coupon-code']) && isset($_GET['lii-set-coupon'])) {
            if ($coupon = esc_attr($_GET['lii-coupon-code'])) {
                $applied = WC()->cart->apply_coupon($coupon);
            } else {
                $coupon = false;
            }

            $success = sprintf(__('Coupon "%s" Applied successfully.'), $coupon);
            $error   = __("This Coupon can't be applied");

            $message = isset($applied) && $applied ? $success : $error;
        }

        $output  = '<form id="lii-apply-coupon" class="lii-apply-coupon">
        <input type="text" class="lii-input-text" name="lii-coupon-code" id="liiCouponCode"/>
        <input type="submit" id="liiSetCouponBtn" class="lii-button" name="lii-set-coupon" value="' . __('Submit') . '" />';

        $output .= isset($coupon) ? '<p class="result mt-4">' . $message . '</p>' : '';

        return $output . '</form>';
    }

    public function lii_apply_coupon()
    {
        $coupon = $_POST['coupon'];
        WC()->cart->apply_coupon($coupon);
        \WC_AJAX::get_refreshed_fragments();
        die();
    }
    public function lii_remove_coupon()
    {
        $coupon = $_POST['coupon_key'];
        WC()->cart->remove_coupon($coupon);
        WC()->cart->calculate_totals();
        \WC_AJAX::get_refreshed_fragments();
        die();
    }

    /**
     * Create Fragment
     *
     */

    public function set_ajax_fragments($fragments)
    {
        global $woocommerce;
        $discount_excl_tax_total = WC()->cart->get_cart_discount_total();
        $discount_tax_total = WC()->cart->get_cart_discount_tax_total();
        $discount_total = $discount_excl_tax_total + $discount_tax_total;

        $fragments['span.lii-cart-count']     = '<span class="lii-cart-count">' . count(WC()->cart->get_cart()) . '</span>';
        $fragments['span.lii-subtotal-price'] = '<span class="lii-subtotal-price">' . WC()->cart->get_cart_subtotal() . '</span>';
        $fragments['span.lii-shipping-price'] = '<span class="lii-shipping-price">' . WC()->cart->get_shipping_total() . '</span>';
        $fragments['span.lii-discount-price'] = '<span class="lii-discount-price">' . $discount_total . '</span>';
        $fragments['span.lii-total-price']    = '<span class="lii-total-price">' . WC()->cart->get_total() . '</span>';

        if (!isset($_POST['coupon'])) :
            ob_start();
            require LII_AJAXCART_DIR_PATH . 'templates/main-contents.php';
            $fragments['div.lii-main-contents'] = ob_get_clean();
        endif;
        ob_start();
        require LII_AJAXCART_DIR_PATH . 'templates/coupon/set-coupon.php';
        $fragments['div.lii-set-coupon'] = ob_get_clean();

        return $fragments;
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
