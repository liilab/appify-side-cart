<?php

namespace lii\ajax\cart\Admin;

class Assets
{
    /**
     * Initialize the class
     */
    function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
    }

    /**
     * Enqueue admin scripts
     *
     * @return void
     */
    public function admin_scripts()
    {
        wp_enqueue_script(LII_AJAXCART_TEXT_DOMAIN.'-js1', '//code.jquery.com/jquery-3.6.0.js', array('jquery'), LII_AJAXCART_VERSION, false);
        wp_enqueue_script(LII_AJAXCART_TEXT_DOMAIN.'-js2', '//code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), LII_AJAXCART_VERSION, false);
        wp_enqueue_script(LII_AJAXCART_TEXT_DOMAIN.'-main', LII_AJAXCART_ASSETS . '/js/main1.js', array('jquery'),LII_AJAXCART_VERSION, true);
    }
}