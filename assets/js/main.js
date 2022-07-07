$ = jQuery;

//=== Cart Icon Modal Open ===//

jQuery(document).ready(function ($) {
    function showCartSidebar() {
        $(".lii-header").css("display", "block");
        $(".lii-main-contents").css("display", "block");
        $(".lii-footer").css("display", "block");
    }
    function hideCartSidebar() {
        $(".lii-header").css("display", "none");
        $(".lii-main-contents").css("display", "none");
        $(".lii-footer").css("display", "none");
    }

    $(".lii-cart-icon").click(function () {
        $(".lii-content-start").toggleClass("lii-show-cart");
    });

    $(".lii-cross").click(function () {
        $(".lii-content-start").removeClass("lii-show-cart");
    });

    $(".ajax_add_to_cart, .single_add_to_cart_button").click(function () {
        $(".lii-content-start").addClass("lii-show-cart");
    });

    //Product Number Increment & Decrement

    $("#lii-shipping").click(function () {
        hideCartSidebar();
        $(".lii-shipping-area").css("display", "block");

    });
    $("#lii-coupon").click(function () {
        hideCartSidebar();
        $(".lii-coupon-area").css("display", "block");

    });
    $(".lii-left-arrow").click(function () {
        showCartSidebar();
        $(".lii-shipping-area").css("display", "none");
    });
    $(".lii-coupon-arrow").click(function () {
        showCartSidebar();
        $(".lii-coupon-area").css("display", "none");
    });

    $(".lii-keepshopping-button").click(function () {
        $(".lii-content-start").toggleClass("lii-show-cart");
    });

});

//=== Product Increment & Decrement ===//

jQuery(document).ready(function ($) {

    $(document).on('click', '.lii-plus', function (e) {

        var elem = $(this).prev('.lii-qty'),
            val = parseInt(elem.val());

        // Sanitize the value
        if (isNaN(val)) {
            val = 0;
        }
        if (val < 0) {
            val = 0;
        }
        elem.val(++val).trigger('change');
    });

    $(document).on('click', '.lii-minus', function (e) {

        var elem = $(this).next('.lii-qty'),
            val = parseInt(elem.val());

        // Sanitize the value
        if (isNaN(val)) {
            val = 0;
        }
        if (val == 1) {
            $con = $(this).closest(".lii-details");
            $con.find('.lii-trash').addClass("lii-shake-trash text-danger");
            setTimeout(function () {
                $con.find('.lii-trash').removeClass("lii-shake-trash text-danger");
            }, 500);
        }
        else {
            val = val - 1;
            if (val <= 0) {
                val = 1;
            }
            elem.val(val).trigger('change');
        }
    });
});

//=== Click on nonModal Area then Modal off===//

jQuery(document).mouseup(function (e) {
    var container = jQuery("#lii-ajax-cart");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        jQuery(".lii-content-start").removeClass("lii-show-cart");
    }
});


//=== AJAX Area Start ===//





//=== Endpoint Create Function ===//

var get_wcurl = function (endpoint_var) {
    return script_handle.wc_ajax_url.toString().replace('endpoint_variable', endpoint_var);
};

//===Single product page load off area start===//

$(document).on('click', '.single_add_to_cart_button', function (e) {
    if ($(".singlepage-load")[0]) {
        e.preventDefault();
        $(".lii-content-start").toggleClass("lii-show-cart");

        $thisbutton = $(this),
            $form = $thisbutton.closest('form.cart'),
            id = $thisbutton.val(),
            quantity = $form.find('input[name=quantity]').val() || 1,
            productID = $form.find('input[name=product_id]').val() || id,
            variation_id = $form.find('input[name=variation_id]').val() || 0;
        add_to_cart(productID, quantity, variation_id);
    }
});

//===Shop page load off===//

$(document).on('submit', 'form.cart', function (e) {
    var $form = $(e.currentTarget);
    $thisbutton = $form.find('button[type="submit"]');
    var isAddtocart = $form.find('button[name="add-to-cart"]');
    var addtoCart = isAddtocart[0];
    if (typeof addtoCart === "undefined") {
        if ($(".shoppage-load")[0]) {

            $(".lii-content-start").toggleClass("lii-show-cart");

            if ($form.closest('.product').hasClass('product-type-external')) return;

            e.preventDefault();
            var is_url = $form.attr('action').match(/add-to-cart=([0-9]+)/),
                productID = is_url ? is_url[1] : false;

            quantity = $form.find('input[name=quantity]').val() || 1,
                variation_id = $form.find('input[name=variation_id]').val() || 0;

            add_to_cart(productID, quantity, variation_id);
        }
    }
});

//=== add to cart function ===//

var add_to_cart = function (productID, product_qty, variation_id) {
    var data = {
        action: '',
        product_id: productID,
        product_sku: '',
        quantity: product_qty,
        variation_id: variation_id,
    };
    $.ajax({
        type: 'post',
        url: get_wcurl('lii_ajaxcart_add_to_cart'),
        data: data,
        beforeSend: function (response) {
            $thisbutton.removeClass('added').addClass('loading');
        },
        complete: function (response) {
            $thisbutton.addClass('added').removeClass('loading');
        },
        success: function (response) {
            if (response.error & response.product_url) {
                window.location = response.product_url;
                return;
            } else {
                $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
            }
        },
    });
}
//===Single product page load off area end===//







//===update quantity area Start===//

//=== Product Delete By Ajax ===//

$(document).on('click', '.lii-trash', function (e) {
    e.preventDefault();

    quantity = 0;
    product_key = $(this).attr('data-key');

    update_item_quantity(product_key, quantity);
});

//=== On change event on product item Input Area ===//

$(document).on('change', 'input.lii-input-text', function (e) {
    e.preventDefault();

    product_key = $(this).attr('data-key');
    quantity = $(this).val();

    update_item_quantity(product_key, quantity);

});

//===update quantity function===//

var update_item_quantity = function (product_key, quantity) {
    var data = {
        action: '',
        product_key: product_key,
        qty: quantity,
    };

    $.ajax({
        type: 'POST',
        url: get_wcurl('lii_ajaxcart_update_item_quantity'),
        data: data,
        success: function (response) {
            updateFragments(response);
        },
    });
}

//=== Update Fragment By Ajax ===//

var updateFragments = function (response) {

    console.log('lii-updated');

    if (response.fragments) {

        $.each(response.fragments, function (key, value) {
            $(key).replaceWith(value);
        });
    }
}
//===update quantity area end===//

//=== Add coupon By Ajax ===//

$(document).on('click', '.lii-button', function (e) {
    e.preventDefault();
    let liiClickedBtnId = '#' + this.id;
    console.log(liiClickedBtnId);
    if (liiClickedBtnId == '#liiSetCouponBtn') {
        var coupon = $('#liiCouponCode');
        var coupon_code = (coupon.val()).trim();
    }
    else if ($(this).hasClass('liiApplyCouponBtn')) {
        var coupon_code = $(this).attr("value");
    }
    else {
        return;
    }
    if (!coupon_code.length) {
        return;
    }
    var data = {
        action: '',
        coupon: coupon_code,
    }

    $.ajax({
        url: get_wcurl('lii_ajaxcart_apply_coupon'),
        type: 'POST',
        data: data,
        success: function (response) {
            updateFragments(response);
        }
    })

});
//liiClickedBtn='#liiApplyCouponBtn';

//=== Remove coupon By Ajax ===//

$(document).on('click', '.lii-remove-coupon', function (e) {
    console.log("remove coupon");
    e.preventDefault();
    coupon_key = $(this).attr('data-coupon');
    console.log(coupon_key);
    var data = {
        action: '',
        coupon_key: coupon_key
    }
    console.log(data);
    $.ajax({
        url: get_wcurl('lii_ajaxcart_remove_coupon'),
        type: 'POST',
        data: data,
        success: function (response) {
            updateFragments(response);
        }
    })

});