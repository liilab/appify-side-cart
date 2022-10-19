<?php

namespace lii\ajax\cart;

/**
 * The admin class
 */
class Admin
{

    /**
     * Initialize the class
     */
    function __construct()
    {
        new Admin\Assets();
        new Admin\Package();
		new Admin\Submenu_Page();
    }
}
