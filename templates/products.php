<?php global $woocommerce;
$items = $woocommerce->cart->get_cart();
//var_dump($items);

?>


<?php foreach ($items as $item) : ?>
    <div class="lii-cart-products mt-4">
        <div class="lii-single-product">
            <div class="lii-main-content d-flex">
                <!-- <img src="" alt="" /> -->
                <?php  echo wc_get_product($item['product_id'])->get_image(); ?>
                <div class="lii-details">
                    <div class="lii-title d-flex justify-content-between">
                        <p><?php echo $item['data']->get_name(); ?></p>
                        <a href="<?php echo esc_url(wc_get_cart_remove_url($item['key'])); ?>" class="bi bi-trash lii-trash"></a>
                    </div>
                    <div class="lii-per-price">
                        <p>Price: $<?php echo get_post_meta($item['product_id'], '_price', true); ?></p>
                    </div>
                    <div class="lii-quantity d-flex">
                        <div class="lii-qty lii-buttons-added me-3">
                            <input type="button" value="-" class="lii-minus" /><input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="lii-input-text lii-qty lii-text" size="4" pattern="" inputmode="" /><input type="button" value="+" class="lii-plus" />
                        </div>
                        <div class="lii-total-price">
                            <p>$30.00</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
        </div>
    </div>
<?php endforeach; ?>