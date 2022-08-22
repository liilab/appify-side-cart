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
                <p class="lii-title"><?php _e('Your Cart','lii-ajax-cart'); ?></p>
                <i class="bi bi-x lii-cross"></i>
            </div>
        </div>
        <div class="lii-product-items">
            <?php require_once LII_AJAXCART_DIR_PATH . 'templates/main-contents.php'; ?>
        </div>
        <?php require_once LII_AJAXCART_DIR_PATH . 'templates/footer.php'; ?>

    </div>
</section>