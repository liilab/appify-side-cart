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

        <?php // woocommerce_shipping_calculator(); ?>
        <form class="woocommerce-shipping-calculator" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

            <?php  printf('<a href="#" class="shipping-calculator-button">%s</a>', esc_html(!empty($button_text) ? $button_text : __('Calculate shipping', 'woocommerce'))); ?>

            <div class="shipping-calculator-form" style="display:none;">

                <?php if (apply_filters('woocommerce_shipping_calculator_enable_country', true)) : ?>
                    <p class="form-row form-row-wide" id="calc_shipping_country_field">
                        <select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state country_select" rel="calc_shipping_state">
                            <option value="default"><?php esc_html_e('Select a country / region&hellip;', 'woocommerce'); ?></option>
                            <?php
                            foreach (WC()->countries->get_shipping_countries() as $key => $value) {
                                echo '<option value="' . esc_attr($key) . '"' . selected(WC()->customer->get_shipping_country(), esc_attr($key), false) . '>' . esc_html($value) . '</option>';
                            }
                            ?>
                        </select>
                    </p>
                <?php endif; ?>

                <?php if (apply_filters('woocommerce_shipping_calculator_enable_state', true)) : ?>
                    <p class="form-row form-row-wide" id="calc_shipping_state_field">
                        <?php
                        $current_cc = WC()->customer->get_shipping_country();
                        $current_r  = WC()->customer->get_shipping_state();
                        $states     = WC()->countries->get_states($current_cc);

                        if (is_array($states) && empty($states)) {
                        ?>
                            <input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_attr_e('State / County', 'woocommerce'); ?>" />
                        <?php
                        } elseif (is_array($states)) {
                        ?>
                            <span>
                                <select name="calc_shipping_state" class="state_select" id="calc_shipping_state" data-placeholder="<?php esc_attr_e('State / County', 'woocommerce'); ?>">
                                    <option value=""><?php esc_html_e('Select an option&hellip;', 'woocommerce'); ?></option>
                                    <?php
                                    foreach ($states as $ckey => $cvalue) {
                                        echo '<option value="' . esc_attr($ckey) . '" ' . selected($current_r, $ckey, false) . '>' . esc_html($cvalue) . '</option>';
                                    }
                                    ?>
                                </select>
                            </span>
                        <?php
                        } else {
                        ?>
                            <input type="text" class="input-text" value="<?php echo esc_attr($current_r); ?>" placeholder="<?php esc_attr_e('State / County', 'woocommerce'); ?>" name="calc_shipping_state" id="calc_shipping_state" />
                        <?php
                        }
                        ?>
                    </p>
                <?php endif; ?>

                <?php if (apply_filters('woocommerce_shipping_calculator_enable_city', true)) : ?>
                    <p class="form-row form-row-wide" id="calc_shipping_city_field">
                        <input type="text" class="input-text" value="<?php echo esc_attr(WC()->customer->get_shipping_city()); ?>" placeholder="<?php esc_attr_e('City', 'woocommerce'); ?>" name="calc_shipping_city" id="calc_shipping_city" />
                    </p>
                <?php endif; ?>

                <?php if (apply_filters('woocommerce_shipping_calculator_enable_postcode', true)) : ?>
                    <p class="form-row form-row-wide" id="calc_shipping_postcode_field">
                        <input type="text" class="input-text" value="<?php echo esc_attr(WC()->customer->get_shipping_postcode()); ?>" placeholder="<?php esc_attr_e('Postcode / ZIP', 'woocommerce'); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
                    </p>
                <?php endif; ?>

                <p><button type="submit" name="calc_shipping" value="1" class="button"><?php esc_html_e('Update', 'woocommerce'); ?></button></p>
                <?php wp_nonce_field('woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce'); ?>
            </div>
        </form>
    </div>
</div>

<?php /*
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
</form>*/
?>