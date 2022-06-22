<?php global $woocommerce;
?>
<div class="lii-coupon-body">
    <!-- <form method="post" class="lii-apply-coupon">
            <input type="text" class="lii-input-text" name="lii-coupon-input" placeholder="Enter Promo Code">
            <button class="lii-button" type="submit" name="apply_coupon" value="<?php //esc_attr_e('Apply coupon', 'woocommerce'); 
                                                                                ?>">Submit</button>
        </form> -->
    <div class="lii-set-coupon">
        <?php
        echo do_shortcode("[coupon_field]");
        $coupons = WC()->cart->get_coupons();
        if (!empty($coupons)) : ?>

            <ul class="lii-applied-coupons mb-4">
                <?php foreach ($coupons as $code => $coupon) : ?>
                    <li class="lii-remove-coupon" data-coupon="<?php echo $code; ?>"><?php echo $code; ?></li>
                <?php endforeach; ?>
            </ul>

        <?php endif; ?>
    </div>

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
            <span class="lii-coupon-label">Unavailable Coupons</span>


            <div class="lii-coupon-row">
                <span class="lii-cr-code">off10</span>
                <span class="lii-cr-off">Get 10% off</span>
                <span class="lii-cr-desc">Use code OFF10 &amp; get 10% discount on orders above $50</span>
            </div>



            <div class="lii-coupon-row">
                <span class="lii-cr-code">off20</span>
                <span class="lii-cr-off">Get 20% off</span>
                <span class="lii-cr-desc">Use code OFF20 &amp; get 20% discount on orders above $100</span>
            </div>



            <div class="lii-coupon-row">
                <span class="lii-cr-code">off25</span>
                <span class="lii-cr-off">Get 25% off</span>
                <span class="lii-cr-desc">Use code OFF25 &amp; get 25% discount on orders above $500</span>
            </div>



            <div class="lii-coupon-row">
                <span class="lii-cr-code">off30</span>
                <span class="lii-cr-off">Get 30% off</span>
                <span class="lii-cr-desc">Use code OFF30 &amp; get 30% discount on orders above $600</span>
            </div>


        </div>
    </div>
</div>