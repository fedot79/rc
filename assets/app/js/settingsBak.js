$(document).ready(function(){
    var $p_name = $('.personal').find('p').eq(0);
    var $p_phone = $('.info-line.mobile span');
    var $p_mail = $('.info-line.email span');
    var $p_skype = $('.info-line.skype span');
    var $p_facebook = $('.info-line.facebook span');
    var $form = $('#settings-form');
    var file;

    $('.personal .edit').on('click', function(){
        var $input = $('#profile-name');
        $input.toggleClass('hidden');
        $p_name.toggleClass('hidden');
        $input.on('change', function(){
            changeName(this);
            canSave();
        })
    });


    $('.contacts .edit').on('click', function(){
        var input_settings = {
            mask:'+7 999 999-99-99',
            // jitMasking:true,
        };
        var $phone = $('#username');
        $phone.toggleClass('hidden');
        $p_phone.toggleClass('hidden');
        if(!$phone.hasClass('hidden'))
        {
            $phone.inputmask(input_settings);
        }
        $phone.on('change', function(){
            changePhone(this);
            canSave();
        });

        var $mail = $('#email_input');
        $mail.toggleClass('hidden');
        $p_mail.toggleClass('hidden');
        $mail.on('change', function(){
            changeMail(this);
            canSave();
        });

        var $skype = $('#skype_input');
        $skype.toggleClass('hidden');
        $p_skype.toggleClass('hidden');
        $skype.on('change', function(){
            changeSkype(this);
            canSave();
        });

        var $facebook = $('#facebook_input');
        $facebook.toggleClass('hidden');
        $p_facebook.toggleClass('hidden');
        $facebook.on('change', function(){
            changeFacebook(this);
            canSave();
        });
    });

    $('#contacts').on('change', function(){
        // var selected = $(this).find(':selected');
        // console.log(selected, $(this).val());
        $('#'+$(this).val()).removeClass('hidden');
        var $input = $('<input>').attr({'type':'text', 'name':'Profile['+$(this).val()+']'}).val(1);
        $('#settings-form').append($input);
        $(this).find(':selected').attr('disabled','disabled');
        canSave();
    });

    $('#avatar').on('change', function(){
        file = this.files[0];
        if(file)
        {
            processFile(file);
        }
        else
        {
            file = false;
        }
    });

    function processFile(file) {
        // $inputRow.addClass('hidden');
        // $selectedRow.removeClass('hidden');
        // $selectedRow.find('.file-name').text(file.name);
        if(file.size>2000000)
        {
            console.log('file size limit');
            showFileError('Файл слишком большой. Выберите файл подходящего размера.');
            return false
        }
        if(['image/jpeg', 'image/png'].indexOf(file.type)<0)
        {
            showFileError('К загрузке допустимы только графические файлы в форматах jpg и png');
            console.log('file type wrong', file.type);
            return false
        }
        var preview = window.URL.createObjectURL(file);
        // var colorThief = new ColorThief();
        $('.av-peregovory').css('background-image', 'url('+preview+')');
        // $logo = $('<div>').addClass('logo').css('background-image', 'url('+preview+')');
        // var $img = $('<img>').css('display', 'none').attr('src', preview);
        // $('body').append($img);
        // $cardType.addClass('with-logo').find('.logo').remove();
        // $cardType.append($logo);
        // $img.on('load', function() {
        //     var palette = colorThief.getPalette($img[0]);
        //     $img.remove();
        //     $palette.children().remove();
        //     $palette.removeClass('disabled');
        //     $.each(palette, function(i,e){
        //         var $span = $('<span>').data('color', rgbToHex(e[0], e[1], e[2])).css('background-color', rgbToHex(e[0], e[1], e[2]));
        //         $palette.append($span);
        //     })
        // });
        // console.log(colorThief.getColor($img[0]));
        // $changedStyle.removeClass('hidden');
        // $currentStyle.addClass('hidden');
        canSave();
    }

    function changeName(that){
        $p_name.html($(that).val());
    }

    function changePhone(that){
        $p_phone.html($(that).val());
    }
    function changeMail(that){
        $p_mail.html($(that).val());
    }
    function changeSkype(that){
        $p_skype.html($(that).val());
    }
    function changeFacebook(that){
        $p_facebook.html($(that).val());
    }


    function canSave()
    {
        $('#save-settings').removeClass('hidden');
    }

    $('#save-settings').on('click', function(){

        var fd = new FormData($form[0]);

        $('.main-info input, .contacts input').serializeArray().map(function(e){
            // var clone = $(e).clone();
            // $('#settings-form').append($(e));
            fd.append(e.name, e.value)
        });
        var csrf = $('[name="_csrf"]').val();
        fd.append('_csrf', csrf);
        if(file)
        {
            fd.append('UserModel[ava_file]', $('#avatar')[0].files[0]);
        }
        for(var pair of fd.entries()) {
            console.log(pair[0]+ ', '+ pair[1]);
        }
        $.ajax({
            url: $form.attr('action'),
            data: fd,
            type: $form.attr('method'),
            contentType: false,
            processData: false,
            success: function(ans){
                window.location.reload();
            }

        });
        // $('#settings-form').submit();
    })


});