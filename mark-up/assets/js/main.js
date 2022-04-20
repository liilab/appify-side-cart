jQuery(document).ready(function ($) {
    $("#lii-shipping-area").style.display="none";
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

$(document).mouseup(function(e){
    var container = $("#lii-ajax-cart");
    if(!container.is(e.target) && container.has(e.target).length === 0){
        $(".lii-content-start").removeClass("lii-show-cart");
    }
});
