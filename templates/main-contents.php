<div class="lii-main-contents">
    <!--Cart Products-->
    <?php
        global $woocommerce;
        $items = $woocommerce->cart;
        $cc=0;
    
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
            $cc++;
            $product = $cart_item['data'];
            $thumbnail = $product->get_image();
            $product_permalink 	= $product->get_permalink( $cart_item );
            $sub_total = WC()->cart->get_product_subtotal($cart_item['data'],$cart_item['quantity']);

        require LII_AJAXCART_DIR_PATH . 'templates/products.php';
        endforeach;
    ?>
</div>