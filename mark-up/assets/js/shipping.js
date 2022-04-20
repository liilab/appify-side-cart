// shippingBtn=document.getElementById('lii-shipping');
// shippingArea=document.getElementById('lii-shipping-area');
// cartArea=document.getElementById('lii-ajax-cart');
// shippingBtn.addEventListener('click',function(){
//     shippingArea.style.display="block";
//     cartArea.style.display="none";

// });
jQuery(document).ready(function ($) {
    $(".lii-ship-cart-icon").click(function () {
        $(".lii-ship-content-start").toggleClass("lii-ship-show-cart");
    });
    $("#lii-shipping").click(function(){
        $("#lii-ajax-cart").style.display="none";
        $(".lii-ship-content-start").addClass("lii-ship-show-cart");
    });
    $(".lii-cross").click(function () {
        $(".lii-ship-content-start").removeClass("lii-ship-show-cart");
    });

});

$(document).mouseup(function(e){
    var container = $("#lii-shipping-area");
    if(!container.is(e.target) && container.has(e.target).length === 0){
        $(".lii-ship-content-start").removeClass("lii-ship-show-cart");
    }
});
