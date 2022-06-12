<?php global $woocommerce;
?>
<div id="lii-coupon-area" class="lii-coupon-area">
    <div class="lii-coupon-header">
        <i class="bx bx-arrow-back lii-coupon-arrow"></i>
        <div class="lii-coupon-title">Apply Coupon</div>
    </div>
    <div class="lii-coupon-body">
        <form class="lii-apply-coupon">
            <input type="text" class="lii-input-text" name="lii-coupon-input" placeholder="Enter Promo Code">
            <button class="lii-button" type="submit">Submit</button>
        </form>
        <div class="lii-coupon-items">

            <div class="lii-avail-coupons lii-coupons">

                <span class="lii-coupon-label">Available Coupons</span>
                <div class="lii-coupon-row">
                    <span class="lii-cr-code">off5</span>
                    <span class="lii-cr-off">Get 5% off</span>
                    <span class="lii-cr-desc">Use code OFF5 &amp; get 5% discount on orders above $15</span>
                    <button class="lii-button" value="off5">Apply Coupon</button>
                </div>

            </div>
            <div class="lii-unavail-coupons lii-coupons">
                <span class="lii-coupon-label">Unvailable Coupons</span>
            </div>
        </div>
    </div>
</div>