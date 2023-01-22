<body>
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
                    <p class="lii-title-header"><?php esc_html_e('My Cart (', 'lii-ajax-cart'); echo WC()->cart->get_cart_contents_count(); esc_html_e(')', 'lii-ajax-cart'); ?></p>
                    <i class="bi bi-x lii-cross"></i>
                </div>
            </div>
            <div class="lii-product-items">
                <?php require_once LII_AJAXCART_DIR_PATH . 'templates/main-contents.php'; ?>
            </div>
            <?php require_once LII_AJAXCART_DIR_PATH . 'templates/footer.php'; ?>

        </div>
    </section>
</body>