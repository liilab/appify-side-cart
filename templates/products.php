
    <?php
    global $woocommerce;
    $items = $woocommerce->cart;
    $cc=0;

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
        $cc++;
        $product = $cart_item['data'];
        $thumbnail = $product->get_image();
        $product_permalink 	= $product->get_permalink( $cart_item );
        $sub_total = WC()->cart->get_product_subtotal($cart_item['data'],$cart_item['quantity']);
        

echo '
<div class="lii-cart-products" data-key="'.$cart_item_key.'">
    <div class="lii-single-product">
        <div class="lii-main-content d-flex">
            '. $thumbnail.'
            <div class="lii-details">
                <div class="lii-title d-flex justify-content-between">
                    <p>'.$product->get_name().'</p>
                    <i class="bi bi-trash lii-trash"></i>
                </div>
                <div class="lii-per-price">
                    <p>Price: '.$product->get_price().'X'.$cart_item['quantity'].'</p>
                </div>
                <div class="lii-quantity d-flex">
                    <div class="lii-qty lii-buttons-added me-3">
                        <input type="button" value="-" class="lii-minus" /><input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="lii-input-text lii-qty lii-text" size="4" pattern="" inputmode="" /><input type="button" value="+" class="lii-plus" />
                    </div>
                    <div class="lii-total-price">
                        <p>'.$sub_total.'</p>
                    </div>
                </div>
            </div>
        </div>
        <hr />
    </div>
</div>

';
endforeach; ?>