<?php
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    $opt_name = 'redux_demo';

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        'display_name'         => $theme->get( 'Name' ),
        'display_version'      => $theme->get( 'Version' ),
        'menu_title'           => esc_html__( 'Ajax Cart', 'lii-ajaxcart' ),
        'customizer'           => true,
    );

    Redux::setArgs( $opt_name, $args );

    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Ajax Load Enable?', 'lii-ajaxcart' ),
        'id'     => 'ajax-load',
        'icon'   => 'el el-home',
        'fields' => array(
            array(
                'id'       => 'shoppage-load',
                'type'     => 'switch', 
                'title'    => esc_html__('Shop Page Ajax Load', 'lii-ajaxcart'),
                'default'  => true,
            ),
            array(
                'id'       => 'singlepage-load',
                'type'     => 'switch', 
                'title'    => esc_html__('Single Product Page Ajax Load', 'lii-ajaxcart'),
                'default'  => true,
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Feature Add', 'lii-ajaxcart' ),
        'id'     => 'features',
        'icon'   => 'el el-home',
        'fields' => array(
            array(
                'id'       => 'product-quantity-box',
                'type'     => 'switch', 
                'title'    => esc_html__('Product Quantity Box Show?', 'lii-ajaxcart'),
                'default'  => true,
            ),
        )
    ) );
