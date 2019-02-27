$(document).ready(function(){
    var $wrapper = $('<div>').addClass('full-wrapper').addClass('wrapper-blck').addClass('hidden');
    var $pop = $('.popup.wholerf').clone().removeClass('hidden');

    function closeHandler() {
        $('body').one('click', '.full-wrapper', closePopup);
        $pop.one('click', '.close-popup', closePopup);
        $wrapper.one('click', closePopup);

    }

    function closePopup(){
        console.log('close');
        $wrapper.addClass('hidden');
        $('body').off('click', '.full-wrapper', closePopup);
        $wrapper.off('click', closePopup);
        $wrapper.html('');
    }

    $('#wholerf').on('click', function(){
        console.log('click');
        $('body').prepend($wrapper);
        $wrapper.html($pop);
        $pop.on('click', function(event){
            event.stopPropagation();
        });
        $wrapper.removeClass('hidden');
        closeHandler();
    })

    $pop.one('click', '.send-custom-request', function(){
        $('.send-custom-request').text('Отправляем').attr('disabled', true).addClass('sending');
        console.log('send ajax');
        $.get('/custom-request', function(){
            $('.send-custom-request').addClass('success').text('Заявка отправлена!');
        })
    });




});