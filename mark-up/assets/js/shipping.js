shippingBtn=document.getElementById('lii-shipping');
shippingArea=document.getElementById('lii-shipping-area');
cartArea=document.getElementById('lii-ajax-cart');
shippingBtn.addEventListener('click',function(){
    shippingArea.style.display="block";
    cartArea.style.display="none";

});