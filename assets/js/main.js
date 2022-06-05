$ = jQuery;
jQuery(document).ready(function ($) {

    $(".lii-cart-icon").click(function () {
        $(".lii-content-start").toggleClass("lii-show-cart");
    });

    $(".lii-cross").click(function () {
        $(".lii-content-start").removeClass("lii-show-cart");
    });

    $(".lii-plus").click(function () {
        $('.lii-qty').val(function (i, oldval) {
            return ++oldval;
        });
    });

    $(".lii-minus").click(function () {
        $('.lii-qty').val(function (i, oldval) {
            if (oldval > 0) {
                return --oldval;
            }
            else {
                return oldval;
            }
        });
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
        });

        $(document.body).trigger('wc_fragments_refreshed');
    }

    $(document.body).trigger('wc_fragment_refresh');
}



jQuery(document).ready(function ($) {

    $('.lii-cart-icon').on('click', function (e) {
        e.preventDefault();
        $thisbutton = $(this);

        $.ajax({
            type: 'POST',
            url: get_wcurl('lii_ajaxcart_add_to_cart'),
            data: '',
            success: function (response) {
                updateFragments(response);
            },
        });

    });
});





