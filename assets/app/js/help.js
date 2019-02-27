$(document).ready(function(){
    var $div;
    $('#help-me, .menu .menu-help').on('click', function(event){
        $('#help-form').removeClass('hidden');
        $('.mobile-menu').toggleClass('close');
        $('.menu.mobile-show').toggleClass('mobile-show');
        $div = $('<div>');
        $('body').prepend($div);
        $div.addClass('full-wrapper').on('click', function(){
            console.log('fw click');
            closeHelp();
        });
        console.log('show help');
        closeHandler();
        event.stopPropagation();
    });

    function closeHelp() {
        $('#help-form').addClass('hidden');
        $('body').off('click', closeHelp);
        $div.remove();
    }

    function closeHandler() {
        $('body').on('click', closeHelp)
    }

    $('#help-form').on('click', function(event){
        event.stopPropagation();
    });


    $('#help-close').on('click', function () {
        closeHelp();
    });

    $('#help-form').on('beforeSubmit', function(event, jqXHR, settings) {
        var form = $(this);
        if(form.find('.has-error').length) {
            return false;
        }

        $.ajax({
            url: '/help',
            type: 'post',
            data: form.serialize(),
            success: function(data) {
                $('#help-form').addClass('hidden');
                $('#helpform-email').val('');
                $('#helpform-text').val('');
            }
        });

        return false;
    })
});