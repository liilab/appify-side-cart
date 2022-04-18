<!--==Ajax Cart==-->

    <section id="lii-ajax-cart">
      <div class="lii-content-start">
        <!--Cart Icon-->
        <div class="lii-cart-icon">
          <span class="lii-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
          <i class="bi bi-cart"></i>
        </div>

        <!--Header-->
        <div class="lii-header">
          <div class="d-flex justify-content-center">
            <i class="bi bi-cart me-2"></i><span class="lii-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            <p class="lii-title">Your Cart</p>
            <i class="bi bi-x lii-cross"></i>
          </div>
        </div>

        <!--Cart Products-->
        <div class="lii-cart-products mt-4">
          <div class="lii-single-product">
            <div class="lii-main-content d-flex">
              <img src="http://localhost/wordpress/wp-content/uploads/2021/07/Rectangle-581-1.jpg" alt="" />
              <div class="lii-details">
                <div class="lii-title d-flex justify-content-between">
                  <p>Sample Product</p>
                  <i class="bi bi-trash lii-trash"></i>
                </div>
                <div class="lii-per-price">
                  <p>Price: $10.00</p>
                </div>
                <div class="lii-quantity d-flex">
                  <div class="lii-qty lii-buttons_added me-3">
                    <input type="button" value="-" class="lii-minus" /><input
                      type="number"
                      step="1"
                      min="1"
                      max=""
                      name="quantity"
                      value="1"
                      title="Qty"
                      class="lii-input-text lii-qty lii-text"
                      size="4"
                      pattern=""
                      inputmode=""
                    /><input type="button" value="+" class="lii-plus" />
                  </div>
                  <div class="lii-total-price">
                    <p>$30.00</p>
                  </div>
                </div>
              </div>
            </div>
            <hr />
          </div>

          <div class="lii-single-product">
            <div class="lii-main-content d-flex">
              <img src="http://localhost/wordpress/wp-content/uploads/2021/07/Rectangle-581-1.jpg" alt="" />
              <div class="lii-details">
                <div class="lii-title d-flex justify-content-between">
                  <p>Sample Product</p>
                  <i class="bi bi-trash lii-trash"></i>
                </div>
                <div class="lii-per-price">
                  <p>Price: $10.00</p>
                </div>
                <div class="lii-quantity d-flex">
                  <div class="lii-qty lii-buttons_added me-3">
                    <input type="button" value="-" class="lii-minus" /><input
                      type="number"
                      step="1"
                      min="1"
                      max=""
                      name="quantity"
                      value="1"
                      title="Qty"
                      class="lii-input-text lii-qty lii-text"
                      size="4"
                      pattern=""
                      inputmode=""
                    /><input type="button" value="+" class="lii-plus" />
                  </div>
                  <div class="lii-total-price">
                    <p>$30.00</p>
                  </div>
                </div>
              </div>
            </div>
            <hr />
          </div>
        </div>

        <!--Suggested Items-->
        <div class="lii-suggested-items">
          <p class="text-center fw-bold">Products you might like</p>
          <div class="lii-products">
            <div class="lii-single-product">
              <div class="lii-main-content d-flex">
                <img src="http://localhost/wordpress/wp-content/uploads/2021/07/Rectangle-581-1.jpg" alt="" />
                <div class="lii-details">
                  <p class="lii-title">Variable Product- XXL, RED</p>
                  <div class="lii-lower-data d-flex">
                    <p>$15.00</p>
                    <button>+ ADD</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!--Footer-->
        <div class="lii-footer fixed-bottom">
          <div class="lii-promo-code d-flex">
            <a href="#" class="d-flex">
              <i class="bi bi-pen me-2"></i>
              <p>Have you any coupon?</p>
            </a>
          </div>
          <div class="lii-price-summery">
            <div class="lii-subtotal d-flex justify-content-between">
              <p class="lii-title">Subtotal</p>
              <p class="lii-price"><span class="lii-subtotal-price"><?php echo WC()->cart->get_cart_subtotal(); ?></span></p>
            </div>
            <div class="lii-shipping d-flex justify-content-between">
              <a href="#">
                <p id="lii-shipping" class="lii-title">
                  Shipping <i class="bi bi-pen"></i>
                </p>
              </a>
              <p class="lii-price"><span class="lii-shipping-price"><?php echo WC()->cart->get_cart_shipping_total(); ?></span></p>
            </div>
            <hr />
            <div class="lii-total d-flex justify-content-between">
              <p class="lii-title">Total</p>
              <p class="lii-price"><span class="lii-total-price"><?php echo WC()->cart->get_cart_total(); ?></span></p>
            </div>
          </div>
          <div class="lii-checkout d-flex justify-content-between">
            <button>Keep Shopping</button>
            <button>Checkout</button>
          </div>
        </div>
      </div>
    </section>
