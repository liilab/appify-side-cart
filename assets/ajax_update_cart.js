jQuery(document).ready(function ($) {

    var timeout;
    jQuery('.botiga-quantity-plus').on('click',  function () {
    //    if (timeout != undefined) clearTimeout(timeout);
    //     timeout = setTimeout(function () {
    //    jQuery(jQuery('body').find('[name="update_cart"]')).prop('disabled',false);
       jQuery(jQuery('body').find('[name="update_cart"]')).trigger('click');
    //    }, 1000);
    });
});



