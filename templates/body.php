<section id="lii-ajax-cart">
    <div class="lii-content-start">
        <!--Cart Icon-->
        <div class="lii-cart-icon">
            <span class="lii-cart-count"><?php echo count(WC()->cart->get_cart()); ?></span>
            <i class="bi bi-cart"></i>
        </div>


        <!--Header-->
        <div class="lii-header">
            <div class="d-flex justify-content-center">
                <i class="bi bi-cart me-2"></i><span class="lii-cart-count"><?php echo count(WC()->cart->get_cart()); ?></span>
                <p class="lii-title">Your Cart</p>
                <i class="bi bi-x lii-cross"></i>
            </div>
        </div>

        <?php require_once LII_AJAXCART_DIR_PATH . 'templates/main-contents.php'; ?>
        <?php require_once LII_AJAXCART_DIR_PATH . 'templates/footer.php'; ?>
        <div id="lii-shipping-area" class="lii-shipping-area">
            <div class="lii-ship-header">
                <i class="bx bx-arrow-back lii-left-arrow"></i>
                <div class="lii-ship-title">Calculate Shipping</div>
            </div>
            <div class="lii-ship-body">
                <div class="lii-ship-destination">
                    <span>Shipping to:</span><span>Bangladesh</span>
                </div>
                <form action="" class="lii-ship-form">
                    <!-- <select class="form-select form-select-sm lii-form-select" aria-label=".form-select-sm example">
                        <option selected>Bangladesh</option>
                        <option value="1">India</option>
                        <option value="2">Pakistan</option>
                        <option value="3">England</option>
                    </select> -->
                    <?php global $woocommerce;    
                    woocommerce_form_field( 'billing_country', array( 
                        'type' => 'country',
                        'input_class'=>array('form-select form-select-sm lii-form-select example')
                         ) 
                    );
                    woocommerce_form_field( 'billing_state', array( 
                        'type' => 'state',
                        'placeholder'=>'State/County',
                        'input_class'=>array('form-select form-select-sm lii-form-select example')
                         ) 
                    );

                    ?>
                   
                    <input type="text" class="lii-input-text" value="" placeholder="City" name="calc_shipping_city" id="calc_shipping_city">
                    <input type="text" class="lii-input-text" value="" placeholder="Postcode / ZIP" name="calc_shipping_postcode" id="calc_shipping_postcode">
                    <div class="lii-btn-area"><button type="submit" name="calc_shipping" value="1" class="lii-button">Update</button></div>
                </form>
            </div>
        </div>

    </div>
</section>