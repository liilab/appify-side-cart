$=jQuery;
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

jQuery(document).mouseup(function(e){
    var container = jQuery("#lii-ajax-cart");
    if(!container.is(e.target) && container.has(e.target).length === 0){
        jQuery(".lii-content-start").removeClass("lii-show-cart");
    }
});



var get_wcurl = function (endpoint_var) {
    return script_handle.wc_ajax_url.toString().replace('endpoint_variable', endpoint_var);
};

function update_data($thisbutton, data){
    $.ajax({
        type: 'POST',
        url: get_wcurl('lii_ajaxcart_update_item_quantity'),
        //url: get_wcurl('add_to_cart'),
        data: data,
        beforeSend: function (response) {
            $thisbutton.removeClass('added').addClass('loading');
        },
        complete: function (response) {
            $thisbutton.addClass('added').removeClass('loading');
        },
        success: function (response) {
            $("footer").html(response);
        },
    });
}


jQuery(document).ready(function ($) {

    $('.single_add_to_cart_button').on('click', function (e) {
        e.preventDefault();

        $thisbutton = $(this),
            $form = $thisbutton.closest('form.cart'),
            id = $thisbutton.val(),
            product_qty = $form.find('input[name=quantity]').val() || 1,
            product_id = $form.find('input[name=product_id]').val() || id,
            variation_id = $form.find('input[name=variation_id]').val() || 0;
        var data = {
            action: 'update_item_quantity',
            product_id: product_id,
            product_sku: '',
            quantity: product_qty,
            variation_id: variation_id,
        };
        update_data($thisbutton, data);
    });
});





