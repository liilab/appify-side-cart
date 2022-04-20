
jQuery(document).ready(function ($) {

    //Side Cart Showing

    $(".lii-cart-icon").click(function () {
        $(".lii-content-start").toggleClass("lii-show-cart");
    });
    $(".lii-cross").click(function () {
        $(".lii-content-start").removeClass("lii-show-cart");
    });

    //Product Number Increment & Decrement

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


//Click Out Side Div, Sidecart Close

jQuery(document).mouseup(function(e){
    var container = jQuery("#lii-ajax-cart");
    if(!container.is(e.target) && container.has(e.target).length === 0){
        jQuery(".lii-content-start").removeClass("lii-show-cart");
    }
});
