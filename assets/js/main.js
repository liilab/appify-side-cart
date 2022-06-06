$ = jQuery;
jQuery(document).ready(function ($) {

    $(".lii-cart-icon").click(function () {
        $(".lii-content-start").toggleClass("lii-show-cart");
    });

    $(".lii-cross").click(function () {
        $(".lii-content-start").removeClass("lii-show-cart");
    });

});


jQuery(document).ready(function ($) {
    // Attach event on plus
    // We delegate the event to document
    // So that even if there are 100 of plus buttons
    // It would not slow down the page
    $(document).on('click', '.lii-plus', function (e) {
        // Get the right element
        var elem = $(this).prev('.lii-qty'),
            // and its value
            val = parseInt(elem.val());
        // Sanitize the value
        if (isNaN(val)) {
            val = 0;
        }
        if (val < 0) {
            val = 0;
        }
        // Now increase it
        elem.val(++val).trigger('change');
    });

    // Similar appraoch for the minus button
    $(document).on('click', '.lii-minus', function (e) {

        // Get the right element
        var elem = $(this).next('.lii-qty'),
            val = parseInt(elem.val());
        // Sanitize the value
        if (isNaN(val)) {
            val = 0;
        }
        // decrease the value
        val = val - 1;
        // but not a negative
        if (val < 0) {
            val = 0;
        }
        // Set it
        elem.val(val).trigger('change');
    });
});

jQuery(document).mouseup(function (e) {
    var container = jQuery("#lii-ajax-cart");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        jQuery(".lii-content-start").removeClass("lii-show-cart");
    }
});



var get_wcurl = function (endpoint_var) {
    return script_handle.wc_ajax_url.toString().replace('endpoint_variable', endpoint_var);
};

$.fn.serializeArrayAll = function () {
    var rCRLF = /\r?\n/g;
    return this.map(function () {
        return this.elements ? jQuery.makeArray(this.elements) : this;
    }).map(function (i, elem) {
        var val = jQuery(this).val();
        if (val == null) {
            return val == null
            //next 2 lines of code look if it is a checkbox and set the value to blank 
            //if it is unchecked
        } else if (this.type == "checkbox" && this.checked === false) {
            return { name: this.name, value: this.checked ? this.value : '' }
            //next lines are kept from default jQuery implementation and 
            //default to all checkboxes = on
        } else {
            return jQuery.isArray(val) ?
                jQuery.map(val, function (val, i) {
                    return { name: elem.name, value: val.replace(rCRLF, "\r\n") };
                }) :
                { name: elem.name, value: val.replace(rCRLF, "\r\n") };
        }
    }).get();
};

var updateFragments = function (response) {

    console.log('lii-updated');

    if (response.fragments) {

        //Set fragments

        $.each(response.fragments, function (key, value) {
            $(key).replaceWith(value);
            //console.log(value);
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



jQuery(document).ready(function ($) {

    $(document).on('click', '.lii-minus', function (e) {
        e.preventDefault();

        var ele = $(this).next('.lii-qty'),
        
        quantity = parseInt(ele.val());

        var el = $(this).prev('input.hhh'),
        // and its value
        product_key = el.val();
        
        console.log( product_key);
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
    $(document).on('click', '.lii-plus', function (e) {
        e.preventDefault();

        var ele = $(this).prev('.lii-qty'),
        
        quantity = parseInt(ele.val());

        var el = $(this).next('input.hhh'),
        // and its value
        product_key = el.val();
        
        console.log( product_key);
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
    $(document).on('click', '.lii-trash', function (e) {
        e.preventDefault();
        
        quantity = 0;

        var el = $(this).prev('input.hhh'),
        // and its value
        product_key = el.val();
        
        console.log( product_key);
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
                //console.log(response);
            },
        });

    });
});





