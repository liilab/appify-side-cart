 <pre>
 <?php
    $coupon_count=0;
    $coupon_posts = get_posts( array(
        'posts_per_page'   => -1,
        'orderby'          => 'name',
        'order'            => 'asc',
        'post_type'        => 'shop_coupon',
        'post_status'      => 'publish',
    ) );
    //print_r($coupon_posts);
?>
 </pre>
<div class="lii-coupon-items">

    <div class="lii-avail-coupons lii-coupons">

        <span class="lii-coupon-label">Available Coupons</span>
        <?php foreach($coupon_posts as $coupon_post): 
              $coupon_code=$coupon_post->post_title;
              $coupon_amount=$coupon_post->coupon_amount;
        ?>
        <div class="lii-coupon-row">
            <span class="lii-cr-code"><?php echo $coupon_code; ?></span>
            <span class="lii-cr-off">Get <?php echo $coupon_amount;  ?> off</span>
            <span class="lii-cr-desc">Use code <?php echo $coupon_code; ?> &amp; get <?php echo $coupon_amount; ?> discount on orders above <?php echo 'minimum amount'; ?></span>
            <button class="lii-button liiApplyCouponBtn" id="liiApplyCouponBtn<?php echo $coupon_count; ?>" value="<?php echo $coupon_code; ?>">Apply Coupon</button>
        </div>
        <?php $coupon_count++; endforeach; ?>

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