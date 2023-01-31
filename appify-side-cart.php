<?php

/**
 * Appify Side Cart -  Use Woocommerce based cart without reloading page
 *
 * @since             1.0
 * @package           lii-ajax-cart
 *
 * @wordpress-plugin
 * Plugin Name:       Appify Side Cart
 * Description:       Manage your cart without reloading the page
 * Version:           1.0
 * Author:            LIILab
 * Author URI:        https://liilab.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lii-ajax-cart
 * Domain Path:       /languages
 * Tags:              Woocommerce, Shopping Cart, Ajax, E-commerce, User-friendly
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class Appify_Side_Cart
{

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0';

    /**
     * Class constructor
     */
    private function __construct()
    {
        $this->define_constants();

        register_activation_hook(__FILE__, [$this, 'activate']);

        add_action('plugins_loaded', [$this, 'init_plugin']);
		add_action('admin_init', [$this, 'plugin_redirect']);
	    add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'plugin_action_links']);
    }


	/**
	 * Plugin action links
	 *
	 * @param array $links
	 *
	 * @return array
	 *@since  1.0.0
	 *
	 */
	public function plugin_action_links(array $links): array
	{

		$links[] = '<a href="' . admin_url('admin.php?page=appify-side-cart') . '" class="fw-bold">' . __('Open tools', LII_AJAXCART_TEXT_DOMAIN) . '</a>';
		return $links;
	}

	/**
	 * Plugin redirect
	 *
	 * @return void
	 *@since  1.0.0
	 *
	 */
	
	public function plugin_redirect() {
    if (get_option('lii-ajaxcart_do_activation_redirect', false)) {
        delete_option('lii-ajaxcart_do_activation_redirect');
        if(!isset($_GET['activate-multi']))
        {
            wp_redirect("admin.php?page=appify-side-cart");
        }
    }
}

    /**
     * Initializes a singleton instance
     *
     * @return \ajax-cart
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
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants()
    {
        define('LII_AJAXCART_VERSION', self::version);
        define('LII_AJAXCART_TEXT_DOMAIN', 'lii-ajax-cart');
        define('LII_AJAXCART_FILE', __FILE__);
        define('LII_AJAXCART_DIR', __DIR__);
        define('LII_AJAXCART_URL', plugins_url('', LII_AJAXCART_FILE));
        define('LII_AJAXCART_ASSETS', LII_AJAXCART_URL . '/assets');
        define('LII_AJAXCART_DIR_PATH', plugin_dir_path(__FILE__));
        define( "LII_AJAXCART_PLUGIN_BASENAME", plugin_basename(LII_AJAXCART_FILE));

    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin()
    {
        if (is_admin()) {
            new lii\ajax\cart\Admin();
        } else {
            new lii\ajax\cart\Subscriber();
        }

	    if (!class_exists('WooCommerce')) {
		    add_action('admin_notices', [$this, 'admin_notice'], 100);
	    }
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate()
    {
        $installed = get_option('lii-ajaxcart_installed');

        if (!$installed) {
            update_option('lii-ajaxcart_installed', time());
        }

        update_option('lii-ajaxcart_version', LII_AJAXCART_VERSION);
		add_option('lii-ajaxcart_do_activation_redirect', true);
    }

	/**
	 * Show warning if WooCommerce is not installed
	 * @return void
	 */

	public function admin_notice()
	{
		?>
		<div class="notice notice-error is-dismissible alert alert-danger" role="alert">
			<span class="fw-bold">Appify Side Cart </span><?php _e('requires ',  LII_AJAXCART_TEXT_DOMAIN); ?><span class="fw-bold">WooCommerce </span><?php _e('to be installed and activated!',  LII_AJAXCART_TEXT_DOMAIN); ?>
		</div>
		<?php
	}
}

/**
 * Initializes the main plugin
 *
 * @return \ajax-cart
 */
function Appify_Side_Cart()
{
    return Appify_Side_Cart::init();
}

// kick-off the plugin
Appify_Side_Cart();
