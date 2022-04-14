jQuery(document).ready(function ($) {
    $(".cart-icon").click(function () {
        $(".content-start").toggleClass("show-cart");
    });
    $(".cross").click(function () {
        $(".content-start").removeClass("show-cart");
    });

    $(".plus").click(function () {
        $('.qty').val(function (i, oldval) {
            return ++oldval;
        });
    });

    $(".minus").click(function () {
        $('.qty').val(function (i, oldval) {
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
    var container = $("#ajax-cart");
    if(!container.is(e.target) && container.has(e.target).length === 0){
        $(".content-start").removeClass("show-cart");
    }
});
