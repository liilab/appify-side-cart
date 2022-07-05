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

        val = val - 1;
        if (val < 0) {
            val = 0;
        }

        elem.val(val).trigger('change');
    });
});

//=== Click on nonModal Area then Modal off===//

jQuery(document).mouseup(function (e) {
    var container = jQuery("#lii-ajax-cart");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        jQuery(".lii-content-start").removeClass("lii-show-cart");
    }
});


//=== Endpoint Create ===//

var get_wcurl = function (endpoint_var) {
    return script_handle.wc_ajax_url.toString().replace('endpoint_variable', endpoint_var);
};

//=== AJAX Area ===//

//=== Update Fragment By Ajax ===//

var updateFragments = function (response) {

    console.log('lii-updated');

    if (response.fragments) {
        $.each(response.fragments, function (key, value) {
            $(key).replaceWith(value);
        });
    }
}

//=== On change event on product item Input Area ===//

$(document).on('change', 'input.lii-qty', function (e) {
    e.preventDefault();

    product_key = $(this).attr('data-key');
    quantity = $(this).val();

    console.log(product_key);
    var data = {
        action: 'update_item_quantity',
        cart_key: product_key,
        qty: quantity,
    };

    $.ajax({
        type: 'POST',
        url: get_wcurl('lii_ajaxcart_add_to_cart'),
        data: data,
        success: function (response) {
            updateFragments(response);
        },
    });
});

//=== Product Decrement By Ajax ===//

$(document).on('click', '.lii-minus', function (e) {
    e.preventDefault();

    var ele = $(this).next('.lii-qty'),
        quantity = parseInt(ele.val());

    var el = $(this).next('input'),
        product_key = el.attr('data-key');

    var data = {
        action: 'update_item_quantity',
        cart_key: product_key,
        qty: quantity,
    };

    $.ajax({
        type: 'POST',
        url: get_wcurl('lii_ajaxcart_add_to_cart'),
        data: data,
        success: function (response) {
            updateFragments(response);
        },
    });

});

//=== Product Increament By Ajax ===//

$(document).on('click', '.lii-plus', function (e) {
    e.preventDefault();

    var ele = $(this).prev('.lii-qty'),
        quantity = parseInt(ele.val());

    var el = $(this).prev('input'),
        product_key = el.attr('data-key');

    var data = {
        action: 'update_item_quantity',
        cart_key: product_key,
        qty: quantity,
    };

    $.ajax({
        type: 'POST',
        url: get_wcurl('lii_ajaxcart_add_to_cart'),
        data: data,
        success: function (response) {
            updateFragments(response);
        },
    });

});

//=== Product Delete By Ajax ===//

$(document).on('click', '.lii-trash', function (e) {
    e.preventDefault();

    quantity = 0;
    product_key = $(this).attr('data-key');

    var data = {
        action: 'update_item_quantity',
        cart_key: product_key,
        qty: quantity,
    };

    $.ajax({
        type: 'POST',
        url: get_wcurl('lii_ajaxcart_add_to_cart'),
        data: data,
        success: function (response) {
            updateFragments(response);
        },
    });

});

//=== Add coupon By Ajax ===//
$(document).on('click', '#liiSetCouponBtn', function (e) {
     console.log('liiset coupon btn clicked');
    e.preventDefault();
    var coupon = $('#liiCouponCode');
    var coupon_code = (coupon.val()).trim();
    console.log(coupon_code);

    // if (!coupon_code.length) {
    //     return;
    // }
    var data = {
        action: '',
        coupon: coupon_code,
    }
    // console.log(data);
    $.ajax({
        url: get_wcurl('lii_ajaxcart_apply_coupon'),
        type: 'POST',
        data: data,
        success: function(response){
            updateFragments(response);
        }
    })
    //$("#lii-apply-coupon").load(location.href + " .lii-apply-coupon");

});

//=== Remove coupon By Ajax ===//

$(document).on('click','.lii-remove-coupon', function (e) {
    console.log("remove coupon");
    e.preventDefault();
    coupon_key= $(this).attr('data-coupon');
    var data= {
        action: '',
        coupon_key:coupon_key
    }
    $.ajax({
        url: get_wcurl('lii_ajaxcart_remove_coupon'),
        type: 'POST',
        data: data,
        success: function(response){
            updateFragments(response);
        }
    })

});