<?php global $woocommerce;
?>
<div id="lii-shipping-area" class="lii-shipping-area">
    <div class="lii-ship-header">
        <i class="bx bx-arrow-back lii-left-arrow"></i>
        <div class="lii-ship-title">Calculate Shipping</div>
    </div>
    <div class="lii-ship-body">
        <div class="lii-ship-destination">
            <span>Shipping to:</span><span><?php echo WC()->customer->get_shipping_country(); ?></span>
        </div>
        <form action="" method="post" class="lii-ship-form">
            <!-- <select class="form-select form-select-sm lii-form-select" aria-label=".form-select-sm example">
                        <option selected>Bangladesh</option>
                        <option value="1">India</option>
                        <option value="2">Pakistan</option>
                        <option value="3">England</option>
                    </select> -->
            <!-- Billing Country -->
            <?php
            woocommerce_form_field(
                'shipping_country',
                array(
                    'type' => 'country',
                    'input_class' => array('form-select form-select-sm lii-form-select example')
                )
            );
            // Billing State
            woocommerce_form_field(
                'shipping_state',
                array(
                    'type' => 'state',
                    'placeholder' => 'State/County',
                    'input_class' => array('form-select form-select-sm lii-form-select example')
                )
            );
             // text form
            //  woocommerce_form_field(
            //     'shipping_city',
            //     array(
            //         'type' => 'text',
            //         'placeholder' => 'Others',
            //         'input_class' => array('lii-input-text')
            //     )
            // );

            ?>
            <!-- Shipping City -->
            <input type="text" class="lii-input-text" value="<?php echo $woocommerce->customer->get_shipping_city(); ?>" placeholder="City" name="calc_shipping_city" id="calc_shipping_city">
            <!-- Shipping Post Code -->
            <input type="text" class="lii-input-text" value="<?php echo $woocommerce->customer->get_shipping_postcode(); ?>" placeholder="Postcode / ZIP" name="calc_shipping_postcode" id="calc_shipping_postcode">
            <!-- Shipping Button -->
            <div class="lii-btn-area"><button type="submit" name="calc_shipping" value="1" class="lii-button">Update</button></div>
        </form>
    </div>
</div>