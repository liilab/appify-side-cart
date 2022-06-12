<?php global $woocommerce;
?>
<div id="lii-coupon-area" class="lii-coupon-area">
    <div class="lii-coupon-header">
        <i class="bx bx-arrow-back lii-coupon-arrow"></i>
        <div class="lii-coupon-title">Apply Coupon</div>
    </div>
    <div class="lii-coupon-body">
        <div class="lii-coupon-destination">
            <span>Shipping to:</span><span><?php echo WC()->customer->get_shipping_country(); ?></span>
        </div>
    </div>
</div>