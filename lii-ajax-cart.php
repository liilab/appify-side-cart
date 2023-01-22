<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              liilab.com
 * @since             1.0
 * @package           lii-ajaxcart
 *
 * @wordpress-plugin
 * Plugin Name:       E-commerce Ajax Side Cart
 * Plugin URI:        liilab.com/ajax-side-cart
 * Description:       A woocommerce based plugin for ajax side cart.
 * Version:           1.0
 * Author:            LIILab
 * Author URI:        liilab.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lii-ajax-cart
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class Lii_Ajax_Cart
{

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.1';

    /**
     * Class construcotr
     */
    private function __construct()
    {
        $this->define_constants();

        register_activation_hook(__FILE__, [$this, 'activate']);

        add_action('plugins_loaded', [$this, 'init_plugin']);
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
        if (!(class_exists('woocommerce'))) {
            deactivate_plugins(__DIR__ . '/lii-ajax-cart.php', true);
        }

        if (is_admin()) {
            new lii\ajax\cart\Admin();
        } else {
            new lii\ajax\cart\Subscriber();
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
    }
}

/**
 * Initializes the main plugin
 *
 * @return \ajax-cart
 */
function Lii_Ajax_Cart()
{
    return Lii_Ajax_Cart::init();
}

// kick-off the plugin
Lii_Ajax_Cart();