$( document).ready(function(){
    $( document ).on('click', 'h4.small-screen', function(event){
       if ($(this).hasClass('active')){
           event.preventDefault()
       } else if ($(this).text() === 'Карта' && !$(this).hasClass('active')) {
           $('div.right').hide();
           $('div.left').show();
           $(this).addClass('active');
           $(this).siblings('h4.small-screen').removeClass('active');
       } else if ($(this).text() === 'Счет' && !$(this).hasClass('active')){
           $('div.left').hide();
           $('div.right').show();
           $(this).addClass('active');
           $(this).siblings('h4.small-screen').removeClass('active');
       }
    });
    $(window).on('resize', function () {
        if ($(this).width() >= '768'){
            $('div.left').show();
            $('div.right').show();
        }
    })
});