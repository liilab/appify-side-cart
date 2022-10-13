<?php
$inlineStyle = '';

$var1 = get_option( 'Lii-ajax-add-to-cart-option' ); //shop-page-load
$var2 = get_option( 'Lii-ajax-single-product-page-add-to-cart-option' );  //single-product-page-load
$var3 = get_option( 'Lii-showing-product-quantity-box-option' );  //product-quantity-box

$var4 = get_option( 'Lii-cart-order-option' ); //cart-order

$hidden      = ' ';
$inlineStyle = ' ';


if ( $var3 ) {
	$hidden      = 'd-none';
	$inlineStyle = 'style="margin-left:0; padding: 0;"';
}
?>
<div class="lii-main-contents <?php if ( $var1 ) {
	echo 'shoppage-load';
}
if ( $var2 ) {
	echo ' singlepage-load';
} ?>">
    <!--Cart Products-->
	<?php
	$index = 0;

	$items = WC()->cart->get_cart();
	if($var4) {$items = array_reverse( $items, true );}

	foreach ( $items as $cart_item_key => $cart_item ) :
		$product           = $cart_item['data'];
		$thumbnail         = $product->get_image();
		$product_permalink = $product->get_permalink( $cart_item );
		$sub_total         = WC()->cart->get_product_subtotal( $cart_item['data'], $cart_item['quantity'] );

		require LII_AJAXCART_DIR_PATH . 'templates/products.php';

		$index ++;
	endforeach;

	if ( $index == 0 ) {
		$shop_url = get_permalink( wc_get_page_id( 'shop' ) );
		?>
        <div>
            <img src="<?php echo LII_AJAXCART_ASSETS . '/img/empty_cart1.png' ?>" alt="" style="
            width: 250px;
            height: auto;
            margin-left: 65px;
    ">
            <div class="text-center">
                <h3 class="fw-bold"><?php _e( 'Your cart is empty!', 'lii-ajax-cart' ); ?></h3>
                <button onclick="window.location.href='<?php echo $shop_url; ?>';" class="mt-2" style="    margin-left: 5px;
    background-color: black;
    color: white;
    padding: 10px 42px;
    border: none;
    font-weight: 600;"><?php _e( 'Go to Shop', 'lii-ajax-cart' ); ?></button>
            </div>
        </div>
	<?php } ?>
</div>