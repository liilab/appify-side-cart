<!--Footer-->
<div class="lii-footer fixed-bottom">
    <div class="lii-promo-code d-flex">
        <a href="#" class="d-flex">
            <i class="bi bi-pen me-2"></i>
            <p>Have you any coupon?</p>
        </a>
    </div>
    <div class="lii-price-summery">
        <div class="lii-subtotal d-flex justify-content-between">
            <p class="lii-title">Subtotal</p>
            <p class="lii-price"><span class="lii-subtotal-price"><?php WC()->cart->get_cart_subtotal(); ?></span></p>
        </div>
        <div class="lii-shipping d-flex justify-content-between">
            <a href="#">
                <p id="lii-shipping" class="lii-title">
                    Shipping <i class="bi bi-pen"></i>
                </p>
            </a>
            <p class="lii-price"><span class="lii-shipping-price"><?php WC()->cart->get_shipping_total(); ?></span></p>
        </div>
        <hr />
        <div class="lii-total d-flex justify-content-between">
            <p class="lii-title">Total</p>
            <p class="lii-price"><span class="lii-total-price"><?php WC()->cart->get_total(); ?></span></p>
        </div>
    </div>
    <div class="lii-checkout d-flex justify-content-between">
        <button class="lii-keepshopping-button">Keep Shopping</button>
        <button class="lii-checkout-button"  onclick="window.location.href = '<?php echo wc_get_checkout_url(); ?>'">Checkout</button>
    </div>
</div>