<?php
$inlineStyle = '';

$var1 = get_option('Lii-ajax-add-to-cart-option'); //shop-page-load
$var2 = get_option('Lii-ajax-single-product-page-add-to-cart-option');  //single-product-page-load
$var3 = get_option('Lii-showing-product-quantity-box-option');  //product-quantity-box

$var4 = get_option('Lii-cart-order-option'); //cart-order

$hidden      = ' ';
$inlineStyle = ' ';


if ($var3) {
	$hidden      = 'd-none';
	$inlineStyle = 'margin-left:0; padding: 0;';
}

echo '<div class="lii-main-contents ', esc_attr($var1 ? 'shoppage-load' : ''), ' ', esc_attr($var2 ? 'singlepage-load' : ''), '">';

?>

<!--Cart Products-->
<?php
$index = 0;

$items = WC()->cart->get_cart();
if ($var4) {
	$items = array_reverse($items, true);
}

foreach ($items as $cart_item_key => $cart_item) :
	$product           = $cart_item['data'];
	$thumbnail         = $product->get_image();
	$product_permalink = $product->get_permalink($cart_item);
	$sub_total         = WC()->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']);

	require LII_AJAXCART_DIR_PATH . 'templates/products.php';

	$index++;
endforeach;

if ($index == 0) {
?>
	<div>
		<img src="<?php echo LII_AJAXCART_ASSETS . '/img/empty_cart.png' ?>" alt="empty-cart" style="
            width: 250px;
            height: auto;
            margin-left: 65px;
			">
		<div class="text-center">
			<h3 class="fw-bold"><?php esc_html_e('Your cart is empty!', 'lii-ajax-cart'); ?></h3>
			<button onclick="window.location.href='<?php echo get_permalink(wc_get_page_id('shop')); ?>';" class="mt-2" style="
				margin-left: 5px;
                background-color: black;
                color: white;
                padding: 10px 42px;
                border: none;
                font-weight: 600;
				">
				<?php esc_html_e('Go to Shop', 'lii-ajax-cart'); ?></button>
		</div>
	</div>
<?php } ?>
</div>