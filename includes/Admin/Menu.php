<?php

namespace ajax\cart\Admin;

/**
 * The Menu handler class
 */
class Menu {

    /**
     * Initialize the class
     */
    function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function admin_menu() {
        add_menu_page( __( 'Ajax Cart', 'lii-ajaxcart' ), __( 'Ajax Cart', 'lii-ajaxcart' ), 'manage_options', 'lii-ajaxcart', [ $this, 'plugin_page' ], 'dashicons-cart' );
    }

    /**
     * Render the plugin page
     *
     * @return void
     */
    public function plugin_page() {
        echo 'Hello World';
    }
}