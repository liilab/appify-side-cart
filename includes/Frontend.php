<?php

namespace ajax\cart;

/**
 * Frontend handler class
 */
class Frontend {

    /**
     * Initialize the class
     */
    function __construct() {
        new Frontend\Frontend_Cart();
        new Frontend\Side_Cart();
    }
}