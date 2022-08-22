<?php
$var1        = 1;
$var2        = 1;
$var3        = 1;
$inlineStyle = '';
if (class_exists('Redux')) :
    $var1        = \Redux::get_option('redux_demo', 'shoppage-load');
    $var2        = \Redux::get_option('redux_demo', 'singlepage-load');
    $var3        = \Redux::get_option('redux_demo', 'product-quantity-box');
    $hidden      = ' ';
    $inlineStyle = ' ';
    if (!$var3) {
        $hidden      = 'd-none';
        $inlineStyle = 'style="margin-left:0; padding: 0;"';
    }
endif;
?>
<div class="lii-main-contents <?php if ($var1) {
                                    echo 'shoppage-load';
                                }
                                if ($var2) {
                                    echo ' singlepage-load';
                                } ?>">
    <!--Cart Products-->
    <?php
    global $woocommerce;
    $items = $woocommerce->cart;
    $ii = 0;

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
        $product           = $cart_item['data'];
        $thumbnail         = $product->get_image();
        $product_permalink = $product->get_permalink($cart_item);
        $sub_total         = WC()->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']);

        require LII_AJAXCART_DIR_PATH . 'templates/products.php';
        $ii++;
    endforeach;
    if ($ii == 0) {
        $shop_url = get_permalink( wc_get_page_id( 'shop' ));
    ?>
        <!--Suggested Items-->
        <!-- <div class="lii-suggested-items">
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
    </div> -->
        <div>
            <img src="<?php echo LII_AJAXCART_ASSETS . '/img/empty_cart1.png' ?>" alt="" style="
            width: 250px;
            height: auto;
            margin-left: 65px;
    ">
    <div class="text-center">
            <h3 class="fw-bold"><?php _e('Your cart is empty!','lii-ajax-cart'); ?></h3>
            <button onclick="window.location.href='<?php echo $shop_url; ?>';" class="mt-2" style="    margin-left: 5px;
    background-color: black;
    color: white;
    padding: 10px 42px;
    border: none;
    font-weight: 600;"><?php _e('Go to Shop','lii-ajax-cart'); ?></button>
        </div>
        </div>
    <?php } ?>
</div>