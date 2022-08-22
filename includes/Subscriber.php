<?php

namespace lii\ajax\cart;

/**
 * Subscriber handler class
 */
class Subscriber
{

    /**
     * Initialize the class
     */
    function __construct()
    {
        new Subscriber\Frontend();
        new Subscriber\Backend();
    }
}
