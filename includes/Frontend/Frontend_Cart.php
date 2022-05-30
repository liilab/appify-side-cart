<?php
namespace ajax\cart\Frontend;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Frontend_Cart
{

    /**
     * Initializes a singleton instance
     *
     * @return \Frontend_Cart
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
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_styles'] );
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_scripts'] );
        add_action( 'wp_footer', [$this, 'frontend_markup'] );
    }

    /**
     * Enqueue All CSS Stylesheet
     *
     * Action Hook: wp_enqueue_scripts
     */

    public function enqueue_styles()
    {
        wp_enqueue_style( 'bootstrap-css', '//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' );
        wp_enqueue_style( 'main-css', LII_AJAXCART_ASSETS . '/css/style.css' );
        wp_enqueue_style( 'bootstrap-icon-css', '//cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css' );
    }

    /**
     * Enqueue All JS File
     *
     * Action Hook: wp_enqueue_scripts
     */

    public function enqueue_scripts()
    {
        wp_enqueue_script( 'main-js', LII_AJAXCART_ASSETS . '/js/main.js', array( 'jquery' ) );
        wp_enqueue_script( 'bootstrap-js', '//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', true );
        wp_localize_script(
            'main-js',
            'script_handle',
            [
                'wc_ajax_url' => \WC_AJAX::get_endpoint( 'endpoint_variable' ),
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
 * @return \Frontend_Cart
 */
function lii_ajaxcart_frontend()
{
    return Frontend_Cart::init();
}

/**
 * Let's Go
 */
lii_ajaxcart_frontend();
