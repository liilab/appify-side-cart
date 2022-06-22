<?php global $woocommerce;
?>

<div class="lii-set-coupon">
     <!-- <form method="post" class="lii-apply-coupon">
            <input type="text" class="lii-input-text" name="lii-coupon-input" placeholder="Enter Promo Code">
            <button class="lii-button" type="submit" name="apply_coupon" value="<?php //esc_attr_e('Apply coupon', 'woocommerce'); 
                                                                                ?>">Submit</button>
                                                                                </form> -->
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