<!--Footer-->
<div class="lii-footer fixed-bottom">
    <div class="lii-price-summery">
        <div class="lii-subtotal d-flex justify-content-between">
            <p class="lii-title"><?php _e('Subtotal','lii-ajax-cart'); ?></p>
            <p class="lii-price"><span class="lii-subtotal-price"><?php WC()->cart->get_cart_subtotal(); ?></span></p>
        </div>
        <div class="lii-shipping d-flex justify-content-between">
            <a href="#">
                <p id="lii-shipping" class="lii-title">
                <?php _e('Shipping','lii-ajax-cart'); ?>
                </p>
            </a>
            <p class="lii-price"><span class="lii-shipping-price"><?php WC()->cart->get_shipping_total(); ?></span></p>
        </div>
        <hr />
        <div class="lii-total d-flex justify-content-between">
            <p class="lii-title"><?php _e('Total','lii-ajax-cart'); ?></p>
            <p class="lii-price"><span class="lii-total-price"><?php WC()->cart->get_total(); ?></span></p>
        </div>
    </div>
    <div class="lii-checkout d-flex justify-content-between">
        <button class="lii-keepshopping-button"><?php _e('Keep Shopping','lii-ajax-cart'); ?></button>
        <button class="lii-checkout-button"  onclick="window.location.href = '<?php echo wc_get_checkout_url(); ?>'"><?php _e('Checkout','lii-ajax-cart'); ?></button>
    </div>
</div>
</div>