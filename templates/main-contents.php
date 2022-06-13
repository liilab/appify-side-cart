<?php
   $var1 = \Redux::get_option('redux_demo', 'shoppage-load');
   $var2 = \Redux::get_option('redux_demo', 'singlepage-load');
   $var3 = \Redux::get_option('redux_demo', 'product-quantity-box');
   $hidden = " ";
   $inlineStyle=" ";
   if(!$var3){
    $hidden = "d-none";
    $inlineStyle = 'style="margin-left:0; padding: 0;"' ;
   }
?>
<?php //echo $var1." ".$var2; die();?>
<div class="lii-main-contents <?php if ($var1) { echo 'shoppage-load';}  if ($var2) { echo ' singlepage-load';} ?>">
    <!--Cart Products-->
    <?php
    global $woocommerce;
    $items = $woocommerce->cart;

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
        $product = $cart_item['data'];
        $thumbnail = $product->get_image();
        $product_permalink     = $product->get_permalink($cart_item);
        $sub_total = WC()->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']);

        require LII_AJAXCART_DIR_PATH . 'templates/products.php';
    endforeach;
    ?>
    <!--Suggested Items-->
    <div class="lii-suggested-items">
        <p class="lii-text-center fw-bold">Products you might like</p>
        <div class="lii-products">
            <div class="lii-single-product">
                <div class="lii-main-content d-flex">
                    <img src="/assets/img/product-2.jpg" alt="" />
                    <div class="lii-details">
                        <p class="lii-title">Variable Product- XXL, RED</p>
                        <div class="lii-lower-data d-flex">
                            <p>$15.00</p>
                            <button>+ ADD</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>