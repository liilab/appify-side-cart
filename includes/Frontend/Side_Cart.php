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
        add_action('wc_ajax_lii_ajaxcart_add_to_cart', [$this, 'add_to_cart']);
        add_filter('woocommerce_add_to_cart_fragments', [$this, 'set_ajax_fragments']);
    }
    public function set_ajax_fragments($fragments)
    {

        WC()->cart->calculate_totals();

        ob_start();
        require LII_AJAXCART_DIR_PATH . 'templates/main-contents.php';
        $container = ob_get_clean();
        $fragments['hlww']=$container;

        return $fragments;

    }


    public function add_to_cart()
    {

        // if (!isset($_POST['product_id'])) return;

        // if (empty(wc_get_notices('error'))) {
        //     // trigger action for added to cart in ajax
        //     do_action('woocommerce_ajax_added_to_cart', intval($_POST['product_id']));
        // }
        \WC_AJAX::get_refreshed_fragments();
        // $hi=$_POST['product_id'];
        // echo $hi;

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
