<div class="lii-cart-products">
    <div class="lii-single-product">
        <div class="lii-main-content d-flex">
            <?php echo $product->get_image() ?>
            <div class="lii-details">
                <div class="lii-title d-flex justify-content-between">
                    <p><?php echo $product->get_name(); ?></p>
                    <i class="bi bi-trash lii-trash" data-key="<?php echo esc_attr($cart_item_key); ?>"></i>
                </div>
                <div class="lii-per-price">
                    <p><?php esc_html_e('Price: ', 'lii-ajax-cart'); ?><?php echo $product->get_price(); ?>X<?php echo $cart_item['quantity']; ?></p>
                </div>
                <div class="lii-quantity d-flex">
                    <div class="lii-qty lii-buttons-added me-3 <?php echo esc_attr($hidden); ?>">
                        <input type="button" value="-" class="lii-minus" /><input data-key="<?php echo esc_attr($cart_item_key); ?>" type="number" step="1" min="1" max="" name="quantity" value="<?php echo $cart_item['quantity']; ?>" title="Qty" class="lii-input-text lii-qty lii-text" size="4" pattern="" inputmode="" /><input type="button" value="+" class="lii-plus" />
                    </div>
                    <div class="lii-total-price" style="<?php echo esc_attr($inlineStyle); ?>">
                        <p> <?php echo WC()->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <hr />
    </div>
</div>