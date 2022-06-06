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
                <i class="bx bx-arrow-back lii-left-icon"></i>
                <div class="lii-ship-title">Calculate Shipping</div>
            </div>
            <div class="lii-ship-body">
                <div class="lii-ship-destination">
                    <span>Shipping to:</span><span>Bangladesh</span>
                </div>
            </div>
        </div>

    </div>
</section>