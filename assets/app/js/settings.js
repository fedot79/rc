$(document).ready(function(){
    var $panels = $('.panel');
    var $panelsEdit = $panels.find('.panel-edit');
    var $panelsEditSwitcher = $panelsEdit.find('.edit');
    var $nameInput = $('#profile-name');
    var $p_name = $panelsEdit.find('.name-string');
    var $phone = $('#username');
    // var $avatarInput =
    var $form = $('#settings-form');
    var $menuAvaDiv = $('.menu').find('.user');

    $('#rating-form').prependTo('.wrap');
    $('.rating-success').prependTo('.wrap');

    $panelsEditSwitcher.on('click', function(event){
        if($(this).parent().hasClass('edit-on'))
        {
            $(this).parent().removeClass('edit-on');
        }
        else
        {
            $(this).parent().addClass('edit-on');
        }
    });

    $nameInput.on('change', function(event){
        console.log('change');
        sendJax($(this));
        var n = $(this).val().trim().split(' ');
        var strong = n.shift();
        $p_name.html('<strong>'+strong+'</strong>'+' '+n.join(' '));
        $p_name.parents('.panel-edit').removeClass('edit-on');
        $menuAvaDiv.find('.full').html('<strong>'+strong+'</strong>'+' '+n.join(' '));
    });

    $('.contacts-panel').find('input').on('change', function(){
        sendJax($(this));
        var n = $(this).val().trim();
        $(this).siblings('label').html($(this).val());
    });

    $('#old_pass').on('change', function(event){
        $('#pass-error').remove();
        var $that = $(this);
        sendJax($(this), function(ans){
            if(ans==true)
            {
                var $col = $that.parents('.panel-col');
                $col.addClass('pass-ok');
                $col.next().removeClass('input-disabled').find('input[type="password"]').prop('disabled', false);

            }
        }, {'name':'action', 'value':'check'});
    });

    $('#new_pass2, #new_pass').on('keyup change paste', function(){
        $('#pass-error').remove();
    });
    $('#new_pass').on('change', function(){
        checkPass();
    });
    $('#new_pass2').on('change', function(){
        checkPass();
    });

    function checkPass()
    {
        if($('#new_pass').val().length < 5)
        {
            addPassError('Пароль должен быть не менее 5 символов');
            return false;
        }
        if($('#new_pass').val() != $('#new_pass2').val())
        {
            addPassError('Пароли должны совпадать');
            return false;
        }

        $('#save-pass').prop('disabled', false);
        $('#save-pass').parents('.panel-col').addClass('pass2-ok');
    }

    function addPassError(text)
    {
        $('.password-panel').append('<div id="pass-error" class="error">'+text+'</div>');
        $('#save-pass').prop('disabled', true);
        $('#save-pass').parents('.panel-col').removeClass('pass2-ok');
    }

    $('#save-pass').on('click', function(){
        if($(this).prop('disabled')){
            return false
        }
        var fd = new FormData($form[0]);
        fd.append('UserPassForm[new_pass]', $('#new_pass').val());
        fd.append('UserPassForm[new_pass2]', $('#new_pass2').val());
        fd.append('action', 'update');
        $.ajax({
            url: $form.attr('action'),
            data: fd,
            type: $form.attr('method'),
            contentType: false,
            processData: false,
            success: function(ans){
                if(ans)
                {
                    $('#old_pass').val('');
                    $('#new_pass').val('');
                    $('#new_pass2').val('');
                    $('#save-pass').prop('disabled', true);
                    $('#save-pass').parents('.panel-col').removeClass('pass2-ok');
                    $('.panel-col').removeClass('pass-ok').eq(1).addClass('input-disabled').find('input[type="password"]').prop('disabled', true);
                }
            }
        });
    });


    var input_settings = {
        mask:'+7 999 999-99-99',
        // jitMasking:true,
    };
    $phone.inputmask(input_settings);

    function sendJax($input, success, moreData)
    {
        if(typeof success == 'undefined')
            success = null;
        if(typeof moreData == 'undefined')
            moreData = null;
        var fd = new FormData($form[0]);
        fd.append($input.attr('name'), $input.val());
        if(moreData)
            fd.append(moreData.name, moreData.value);
        $.ajax({
            url: $form.attr('action'),
            data: fd,
            type: $form.attr('method'),
            contentType: false,
            processData: false,
            success: function(ans){
                if(typeof success == 'function')
                {
                    success(ans);
                }
                // window.location.reload();
            }
        });
    }

    $('#avatar').on('change', function(){
        $('#ava-error').remove();
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

    $('#del_ava').on('click', function(){
        $('#ava-error').remove();
        $('.avatar-inner').css('background-image', 'url(/img/default_userpic.svg)');
        $menuAvaDiv.find('svg,img,a[href="/settings"]').remove();
        $menuAvaDiv.prepend('<a href="/settings"><svg><use xlink:href="/img/add_avatar.svg#add_avatar.svg"></use></svg></a>');
        var fd = new FormData($form[0]);
        fd.append('action', 'del_ava');
        $('#del_ava').removeClass('hidden');
        $.ajax({
            url: $form.attr('action'),
            data: fd,
            type: $form.attr('method'),
            contentType: false,
            processData: false,
            success: function(ans){
            }
        });
        $('#del_ava').addClass('hidden');
    });

    function processFile(file) {
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
        $('.avatar-inner').css('background-image', 'url('+preview+')');
        $menuAvaDiv.find('svg,img,a[href="/settings"]').remove();
        $menuAvaDiv.prepend('<img src="'+preview+'">');
        var fd = new FormData($form[0]);
        fd.append($('#avatar').attr('name'), file);
        $('#del_ava').removeClass('hidden');
        $.ajax({
            url: $form.attr('action'),
            data: fd,
            type: $form.attr('method'),
            contentType: false,
            processData: false,
            success: function(ans){
            }
        });
    }

    function showFileError(msg)
    {
        $('.user-panel').append('<div id="ava-error" class="error">'+msg+'</div>');
    }

    $('#tg, #wa, #vb').inputmask(input_settings);
});