<div class="lii-cart-products">
    <div class="lii-single-product">
        <div class="lii-main-content d-flex">
            <?php echo $thumbnail; ?>
            <div class="lii-details">
                <div class="lii-title d-flex justify-content-between">
                    <p><?php echo $product->get_name(); ?></p>
                    <i class="bi bi-trash lii-trash" data-key="<?php echo $cart_item_key; ?>"></i>
                </div>
                <div class="lii-per-price">
                    <p>Price: <?php echo $product->get_price(); ?>X<?php echo $cart_item['quantity']; ?></p>
                </div>
                <div class="lii-quantity d-flex">
                    <div class="lii-qty lii-buttons-added me-3">
                        <input type="button" value="-" class="lii-minus" /><input data-key="<?php echo $cart_item_key; ?>" type="number" step="1" min="1" max="" name="quantity" value="<?php echo $cart_item['quantity']; ?>" title="Qty" class="lii-input-text lii-qty lii-text" size="4" pattern="" inputmode="" /><input type="button" value="+" class="lii-plus" />
                    </div>
                    <div class="lii-total-price">
                        <p><?php echo $sub_total; ?></p>
                    </div>
                </div>
            </div>
            <hr />
        </div>
    </div>
</div>
