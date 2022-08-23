<?php

namespace lii\ajax\cart\Subscriber;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Frontend
{

    /**
     * Initializes a singleton instance
     *
     * @return \Frontend
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
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_footer', [$this, 'frontend_markup']);
        add_filter('woocommerce_loop_add_to_cart_link', [$this, 'quantity_inputs_for_woocommerce_loop_add_to_cart_link'], 10, 2);
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this,'add_action_links']);
    }

    public function quantity_inputs_for_woocommerce_loop_add_to_cart_link($html, $product)
    {
        global $woocommerce;
        if ($product && $product->is_type('simple') && $product->is_purchasable() && $product->is_in_stock() && !$product->is_sold_individually()) {
            $html = '<form action="' . esc_url($product->add_to_cart_url()) . '" class="cart" method="post" enctype="multipart/form-data">';
            $html .= woocommerce_quantity_input(array(), $product, false);
            $html .= '<button type="submit" class="button alt">' . esc_html($product->add_to_cart_text()) . '</button>';
            $html .= '</form>';
        }
        return $html;
    }

    
    /**
     * Show action links on the plugin screen.
     *
     * @param	mixed $links Plugin Action links
     * @return	array
     */
    public function add_action_links ( $links ) {
        $mylinks = array(
            '<a href="' . admin_url( 'options-general.php?page=mysettings' ) . '">Settings</a>',
        );
        var_dump($mylinks);
        die();
        return array_merge( $links, $mylinks );
    }

    /**
     * Enqueue All CSS Stylesheet
     *
     * Action Hook: wp_enqueue_scripts
     */

    public function enqueue_styles()
    {
        wp_enqueue_style(LII_AJAXCART_TEXT_DOMAIN.'-bootstrap', LII_AJAXCART_ASSETS . '/css/vendor/bootstrap-5.0.2.min.css');
        wp_enqueue_style(LII_AJAXCART_TEXT_DOMAIN.'-bootstrap-icon', '//cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css');
        wp_enqueue_style(LII_AJAXCART_TEXT_DOMAIN.'-main', LII_AJAXCART_ASSETS . '/css/style.css');
    }

    /**
     * Enqueue All JS File
     *
     * Action Hook: wp_enqueue_scripts
     */


    public function enqueue_scripts()
    {
        wp_enqueue_script(LII_AJAXCART_TEXT_DOMAIN.'-notify', LII_AJAXCART_ASSETS . '/js/notify.js', array('jquery'), LII_AJAXCART_VERSION, true);
        wp_enqueue_script(LII_AJAXCART_TEXT_DOMAIN.'-bootstrap', LII_AJAXCART_ASSETS . '/js/vendor/bootstrap-5.0.2.min.js','5.0.2', true);
        wp_enqueue_script(LII_AJAXCART_TEXT_DOMAIN.'-main', LII_AJAXCART_ASSETS . '/js/main.js', array('jquery'),LII_AJAXCART_VERSION, true);
        wp_localize_script(
            LII_AJAXCART_TEXT_DOMAIN.'-main',
            'script_handle',
            [
                'wc_ajax_url' => \WC_AJAX::get_endpoint('endpoint_variable'),
            ]
        );
    }

    public function frontend_markup()
    {
        require_once LII_AJAXCART_DIR_PATH . 'templates/frontend-markup.php';
    }
}



/**
 * Initializes the class
 *
 * @return \Frontend
 */
function lii_ajaxcart_frontend()
{
    return Frontend::init();
}

/**
 * Let's Go
 */
lii_ajaxcart_frontend();
