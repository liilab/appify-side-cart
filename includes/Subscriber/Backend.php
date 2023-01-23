<?php

namespace lii\ajax\cart\Subscriber;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Backend
{
    public $product_key;

    /**
     * Initializes a singleton instance
     *
     * @return \Backend
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
    public $notice;
    public $response_status;
    public function __construct()
    {
        $notice = $this->notice;
        $status = $this->response_status;
        $this->set_notice($notice, $status);
        $this->hooks();
    }

    /**
     * Initialize All Necessary Wordpress Action/Filter Hook
     *
     */

    public function hooks()
    {
        add_filter('woocommerce_add_to_cart_fragments', [$this, 'set_ajax_fragments']);
        add_action('wc_ajax_lii_ajaxcart_add_to_cart', [$this, 'add_to_cart']);
        add_action('wc_ajax_lii_ajaxcart_update_item_quantity', [$this, 'update_item_quantity']);
    }


    /**
     * Create Ajax Add To cart product add
     *
     */

    public function add_to_cart()
    {
        $nonce = sanitize_text_field($_POST['appify_cart_nonce']);
        if (!wp_verify_nonce($nonce, 'appify-cart-nonce-action')) {
            die('Nonce invalid!');
        }
        $product_id = sanitize_text_field($_POST['product_id']);
		$quantity = sanitize_text_field($_POST['quantity']);
        $quantity = empty($quantity) ? 1 : wc_stock_amount($quantity);
		$variation_id = sanitize_text_field($_POST['variation_id']);
        $variation_id = absint($variation_id);
        $passed_validation = apply_filters('lii_ajaxcart_woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $product_status = get_post_status($product_id);
        if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

            if ('yes' === get_option('lii_ajaxcart_woocommerce_cart_redirect_after_add')) {
                wc_add_to_cart_message(array($product_id => $quantity), true);
            }

            \WC_AJAX::get_refreshed_fragments();
        } else {
            $data = array(
                'error' => true,
                'product_url' => get_permalink($product_id),
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
        $nonce = sanitize_text_field($_POST['appify_cart_nonce']);
        if (!wp_verify_nonce($nonce, 'appify-cart-nonce-action')) {
            die('Nonce invalid!');
        }

        $product_key     = sanitize_text_field($_POST['product_key']);
        $new_qty     = sanitize_text_field($_POST['qty']);


        if (!is_numeric($new_qty) || $new_qty < 0 || !$product_key) {
            $this->set_notice(__('Something went wrong', 'side-cart-woocommerce'), 'error');
        }

        $validated = apply_filters('lii_ajaxcart_update_quantity', true, $product_key, $new_qty);

        if ($validated && !empty(WC()->cart->get_cart_item($product_key))) {

            $updated = $new_qty == 0 ? WC()->cart->remove_cart_item($product_key) : WC()->cart->set_quantity($product_key, $new_qty);

            if ($updated) {

                if ($new_qty == 0) {

                    $notice = __('Cart item removed successfully', 'side-cart-woocommerce');
                    $this->set_notice($notice, 'danger');

                    $notice .= '<span class="xoo-wsc-undo-item" data-key="' . $product_key . '">' . __('Undo?', 'side-cart-woocommerce') . '</span>';
                } else {
                    $notice = __('Cart item updated successfully', 'side-cart-woocommerce');
                    $this->set_notice($notice, 'success');
                }
            } else {
                $notice = __('Sorry, something went wrong!', 'side-cart-woocommerce');
                $this->set_notice($notice, 'danger');
            }
        }


        ob_start();
        woocommerce_mini_cart();

        $mini_cart = ob_get_clean();

        $total_item = count(WC()->cart->get_cart());
        if (!$total_item) {
            $this->response_status = "empty";
        }

        $data = array(
            'notice' => ['name' => $this->notice, 'status' => $this->response_status,],
            'fragments' => apply_filters(
                'woocommerce_add_to_cart_fragments',
                ['div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>']
            ),
            'cart_hash' => WC()->cart->get_cart_hash(),
        );

        wp_send_json($data);
        die();
    }

    //Create Notice

    public function set_notice($notice, $status)
    {
        $this->notice = $notice;
        $this->response_status = $status;
    }



    /**
     * Create Fragment
     *
     */

    public function set_ajax_fragments($fragments)
    {
        $fragments['p.lii-title-header']     = '<p class="lii-title-header"> My Cart ('.WC()->cart->get_cart_contents_count() . ') </p>';
        $fragments['span.lii-cart-count']     = '<span class="lii-cart-count">' . count(WC()->cart->get_cart()) . '</span>';
        $fragments['span.lii-subtotal-price'] = '<span class="lii-subtotal-price">' . WC()->cart->get_cart_subtotal() . '</span>';
        $fragments['span.lii-shipping-price'] = '<span class="lii-shipping-price">' . WC()->cart->get_shipping_total() . '</span>';
        $fragments['span.lii-total-price']    = '<span class="lii-total-price">' . WC()->cart->get_total() . '</span>';

        ob_start();
        require LII_AJAXCART_DIR_PATH . 'templates/main-contents.php';
        $fragments['div.lii-main-contents'] = ob_get_clean();

        return $fragments;
    }
}

/**
 * Initializes the class
 *
 * @return \Backend
 */

function lii_ajaxcart_backend()
{
    return Backend::init();
}

/**
 * Let's Go
 */
lii_ajaxcart_backend();
