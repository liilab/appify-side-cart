$ = jQuery;

//=== Cart Icon Modal Open ===//

jQuery(document).ready(function ($) {

    $(".lii-cart-icon").click(function () {
        $(".lii-content-start").toggleClass("lii-show-cart");
    });

    $(".lii-cross").click(function () {
        $(".lii-content-start").removeClass("lii-show-cart");
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

        //Set fragments

        $.each(response.fragments, function (key, value) {
            $(key).replaceWith(value);
        });

        if (typeof wc_cart_fragments_params !== 'undefined' && ('sessionStorage' in window && window.sessionStorage !== null)) {

            sessionStorage.setItem(wc_cart_fragments_params.fragment_name, JSON.stringify(response.fragments));
            localStorage.setItem(wc_cart_fragments_params.cart_hash_key, response.cart_hash);
            sessionStorage.setItem(wc_cart_fragments_params.cart_hash_key, response.cart_hash);

            if (response.cart_hash) {
                sessionStorage.setItem('wc_cart_created', (new Date()).getTime());
            }

        }

        $(document.body).trigger('wc_fragments_refreshed');
    }

    $(document.body).trigger('wc_fragment_refresh');
}

//=== On change event on product item Input Area ===//

$(document).on('change', 'input.lii-input-text', function (e) {
    e.preventDefault();

    product_key = $(this).attr('data-key');
    quantity = $(this).val();

    console.log(product_key);
    var data = {
        action: 'update_item_quantity',
        product_key: product_key,
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
        product_key: product_key,
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
        product_key: product_key,
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
        product_key: product_key,
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





