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
    }
}