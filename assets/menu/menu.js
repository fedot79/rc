$(document).ready(function(){
    $('#mobile-menu').on('click', function(){
        $('.side-nav').toggleClass('mobile-show');
        $(this).toggleClass('close');
    })
});