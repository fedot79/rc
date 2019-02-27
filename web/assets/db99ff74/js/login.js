$('document').ready(function(){

    $('#svgstyle').remove();
    var $phoneInput = $('#phone-input');
    $phoneInput.focus();
    var scenario;
    var phone;
    var showSendNew;
    var phoneSending = false;
    var registerSending = false;
    var name;
    var canProceed = false;
    var $form = $('#form-login');
    var password;
    var send_reg = false;
    var new_user_type = false;

    var $phone = $('label.phone');
    var $phoneErr = $phone.find('.error-msg');
    var $pass = $('label.password');
    var $passInput = $('#password-input');
    var $name = $('label.name');
    var $nameInput = $('#name-input');
    var $sms = $('label.sms');
    var $smsInput = $('#sms-code');
    var $newCode = $('p.new');
    var $newButton = $('#send-new');
    var $type = $('.type-p');
    var $typeInput = $('input[name=type]');
    var $enter = $('#enter');
    var $next = $('#next');
    var $send = $('#send');
    var $confirm = $('#confirm');
    var $newPass = $('p.new-pass');
    var $newPassSend = $('#send-new-pass');
    var $newCodeSended = $('#new-send-success');

    // var nameSend = false;
    // var showName = false;
    $form.on('submit', function(e){
        e.preventDefault();
        return false;
    });

    function showInit() {
        $pass.addClass('hidden');
        $pass.removeClass('error');
        $passInput.off('change keyup blur');
        $name.addClass('hidden');
        $nameInput.off('keyup input paste blur');
        $sms.addClass('hidden');
        $newCode.addClass('hidden');
        $type.addClass('hidden');
        $typeInput.off('change');
        $enter.addClass('hidden');
        $next.addClass('hidden');
        $send.addClass('hidden');
        $confirm.addClass('hidden');
        $newPass.addClass('hidden');
        $phone.removeClass('error');
    }

    function setProceedTrue() {
        canProceed = true;
        $form.removeClass('disable-proceed');
    }

    function setProceedFalse() {
        canProceed = false;
        $form.addClass('disable-proceed');
    }

    function checkPhone() {
        if(phoneSending!==false)
            return false;

        phoneSending = $.post('/user/check', {'phone':phone, 'checkName':true}, function(ans){
            if(ans===false)
                scenario = 'register';

            if(typeof ans === 'object')
            {
                if(ans.confirm)
                    scenario = 'signin';
                else
                    scenario = 'confirm';
                // if(ans.confirm && !ans.name)
                //     scenario = 'setName';
                name = ans.name;
                // console.log(ans);
            }
            phoneSending = false;
            // console.log(scenario);
            stage(scenario);
        })
    }

    function stage(scenario) {
        // console.log('stage1 '+scenario);
        if(phoneSending!==false)
        {
            // console.log('phonesended in progress');
            return false;
        }
        if(scenario=='register')
        {
            register();
            return false;
        }
        if(scenario=='confirm')
        {
            confirmUser();
            return false;
        }
        if(scenario=='setName')
        {
            setUserName();
            return false;
        }
        if(scenario=='signin')
        {
            signIn();
        }
    }
    function resend(event)
    {
        console.log('click resend');
        console.log(event);
        $.post('/user/resend', {'ResendForm[phone]':phone, 'skipAjax':true}, function(ans){
            if(ans==='ok')
            {
                $('.pincode-input-container').removeClass('error');
                $('.pincode-input-error').remove();
                $newCode.addClass('hidden');
                $('.pincode-input-text').val('');
                $smsInput.val('');
            }
            checkFailedSms(ans);
        });
        $newButton.off('click', resend);
    }
    function showResend()
    {
        $newButton.off('click');
        // console.log('show resend call');
        $newCode.removeClass('hidden');
        $newButton.one('click', resend);
    }

    function resendPass()
    {
        $.post('/user/resend', {'ResendForm[phone]':phone, 'skipAjax':true}, function(ans){
            if(ans==='ok')
            {
                // $pass.removeClass('error');
                // $newPass.addClass('hidden');
                // $passInput.val('');
                $pass.addClass('hidden');
                $enter.addClass('hidden');
                $newPass.addClass('hidden');
                showEnterCode();
            }
            checkFailedSms(ans);
        });
        $newPassSend.off('click', resendPass);
    }
    function showResendPass()
    {
        // console.log('resendPass');
        $newPass.removeClass('hidden');
        $newPassSend.one('click', resendPass);
    }

    function showRegister() {
        showInit();
        $name.removeClass('hidden');
        $nameInput.focus();
        $type.removeClass('hidden');
    }

    function showSignIn() {
        showInit();
        $pass.removeClass('hidden');
        $passInput.val('');
        $pass.focus();
    }

    function showGetSms() {
        $send.removeClass('hidden').attr('tabindex', 2);
        $confirm.removeClass('hidden');
    }

    function hideGetSms() {
        $send.addClass('hidden');
        $confirm.addClass('hidden');
    }

    function showEnterCode() {
        $sms.removeClass('hidden');
        $('.pincode-input-text.first').trigger('focus');
        showSendNew = setTimeout(function(){showResend()}, 7000);
    }

    function register() {
        send_reg = true;
        showRegister();
        var has_name=false;
        var has_type=false;
        var user_type;
        if($nameInput.val().length>2)
        {
            has_name = true;
            checkGetCodeButton(has_name, has_type);
        }
        if($('input[name=type]:checked').length>0) //check when return here
        {
            has_type = true;
            checkGetCodeButton(has_name, has_type);
        }

        $nameInput.on('keyup', function(){
            // console.log('name keyup'+$(this).val());
            if($(this).val().length>2)
            {
                has_name = true;
                checkGetCodeButton(has_name, has_type);
            }
            else
            {
                has_name = false;
                checkGetCodeButton(has_name, has_type);
            }
        });
        $typeInput.on('change', function(){
            if($('input[name=type]:checked').length>0)
            {
                user_type = $(this).val();
                has_type = true;
                checkGetCodeButton(has_name, has_type);
            }
            else
            {
                has_type = false;
                checkGetCodeButton(has_name, has_type);
            }
        });



        $send.one('click', function(e){
            $name.addClass('hidden');
            $type.addClass('hidden');
            name = $nameInput.val();
            new_user_type = user_type;
            registerSending = $.post('/user/register', {'user_type':user_type, 'RegistrationForm[phone]':phone, 'RegistrationForm[name]':name, 'skipAjax':true}, function(ans){
                if(ans==='ok')
                {
                    hideGetSms();
                    showEnterCode();
                }
                checkFailedSms(ans);
            })
        });
    }

    function checkFailedSms(ans)
    {

        if(ans=='wrong_number')
        {
            $phoneErr.text('Неверный номер');
            $phone.addClass('error');
            $newCode.addClass('hidden');
        }
        if(ans=='try_later')
        {
            $phoneErr.text('Смс не отправилось, попробуйте позже');
            $phone.addClass('error');
            $newCode.addClass('hidden');
        }
    }

    function checkGetCodeButton(has_name, has_type)
    {
        if(has_name && has_type)
        {
            showGetSms();
        }
        else
        {
            hideGetSms();
        }
    }

    function confirmUser() {
        send_reg = false;
        if(name)
        {
            $nameInput.on('keyup input paste', function(){
                if($(this).val().length>2)
                {
                    $sms.removeClass('hidden');
                }
                else
                {
                    $sms.addClass('hidden');
                }
            });
            $nameInput.on('blur', function(){
                name = $(this).val();
            });
            $name.removeClass('hidden');
            $nameInput.trigger('focus');
        }
        else
        {
            $sms.removeClass('hidden');
            $('.pincode-input-text.first').trigger('focus');
            // console.log('try show resend');
            showSendNew = setTimeout(function(){showResend()}, 7000);
        }
    }

    function setUserName() {
        send_reg = false;

        $nameInput.on('keyup input paste', function(){
            if($(this).val().length>2)
            {
                $pass.removeClass('hidden');
            }
            else
            {
                $pass.addClass('hidden');
            }
        });
        $nameInput.on('blur', function(){
            name = $(this).val();
        });
        $name.removeClass('hidden');
        $nameInput.trigger('focus');

    }


    function showEnter(){
        $enter.removeClass('hidden');
    }
    $enter.on('click', function(e){
        // console.log(e);
        // console.log('click enter');
        $.post('/user/login', {'LoginForm[phone]':phone, 'LoginForm[password]':password, 'skipAjax':true}, function(ans){
            if(ans=='ok')
                window.location = '/choose';
            else
            {
                // console.log('wrong pass');
                $pass.addClass('error');
                showResendPass();
            }
        });
        return false;
    });

    function signIn() {
        send_reg = false;
        showSignIn();
        $passInput.on('keyup', function(){
            // $enter.off('click');
            password = $(this).val();
            $pass.removeClass('error');
            if(password.length>4)
            {
                showEnter();
                $passInput.on('keydown', function(event){
                    if (event.key === "Enter") {
                        $enter.trigger('click');
                    }
                })
            }
            return false;
        })
    }

    var input_settings = {
        mask:'+7 (999) 999-99-99',
        jitMasking:true,
        autoUnmask:true,
        oncomplete: function(){
            // console.log('autocomplete', $(this).val());
            var val = '+7'+$(this).inputmask('unmaskedvalue');
            // console.log('phone entered');
            if(val.length==12)
            {
                phone = val;
                setProceedTrue();
                if(!phoneSending)
                    checkPhone();
            }
            else
            {
                showInit();
                if(phoneSending)
                    phoneSending.abort();
            }
        },
        onKeyDown: function(event, buffer, caretPos, opts){
            // console.log('keydown', $(this).val());
            var val = '+7'+$(this).inputmask('unmaskedvalue');
            if(val.length<12)
            {
                $phone.removeClass('error');
                setProceedFalse();
                showInit();
            }
        },
        onBeforePaste: function (pastedValue, opts){
            if(pastedValue.length>7 && pastedValue.slice(0,2)=='89')
            {
                return pastedValue.slice(1);
            }
            return pastedValue.replace('+7', '');
        }

    };
    $phoneInput.inputmask(input_settings);
    // $phoneInput.on('paste', function(){
    //     console.log('paste', $(this).val());
    // })
    var sms_error=false;
    $smsInput.pincodeInput({
        inputs:5,
        hidedigits:false,
        change:function(e){
            $('.pincode-input-container').removeClass('error');
            clearTimeout(showSendNew);
            if(sms_error && sms_error.length>0)
            {
                sms_error.hide();
            }
        },
        complete:function(val, e, errorElement){
            if(name)
            {
                $.post('/user/confirm', {'ConfirmForm[sms]':val, 'ConfirmForm[phone]':phone, 'ConfirmForm[name]':$nameInput.val(), 'skipAjax':true}, function(ans){
                    if(ans==='ok')
                    {
                        setProceedTrue();
                        window.location = '/choose';
                    }
                    if(ans===false)
                    {
                        setProceedFalse();
                        $('.pincode-input-container').addClass('error');
                        showResend();
                        if(!sms_error)
                        {
                            $(errorElement).html("Неверный код");
                            sms_error = $(errorElement);
                        }
                        else
                        {
                            sms_error.show();
                        }

                    }
                })
            }
            else
            {
                $.post('/user/confirm', {'ConfirmForm[sms]':val, 'ConfirmForm[phone]':phone, 'skipAjax':true}, function(ans){
                    if(ans==='ok')
                    {
                        setProceedTrue();
                        if(typeof yaCounter49149883 == 'object' && send_reg && new_user_type)
                        {
                            // if(new_user_type=='search')
                            //     yaCounter49149883.reachGoal('regonnewret');
                            // if(new_user_type=='object')
                            //     yaCounter49149883.reachGoal('regonnewdev');
                        }
                        window.location = '/choose';
                    }
                    if(ans===false)
                    {
                        setProceedFalse();
                        $('.pincode-input-container').addClass('error');
                        showResend();
                        if(!sms_error)
                        {
                            $(errorElement).html("Неверный код");
                            sms_error = $(errorElement);
                        }
                        else
                        {
                            sms_error.show();
                        }
                    }
                })
            }
        }
    });

    $passwordInput = $('#password-input');
    $passSpan = $passwordInput.siblings('span');
    $passwordInput.on('focus', function(){
        $passSpan.addClass('top');
    });
    $passwordInput.on('blur', function(){
        if($passwordInput.val()=='')
            $passSpan.removeClass('top');
    });

    $nameInput = $('#name-input');
    $nameSpan = $nameInput.siblings('span');
    $nameInput.on('focus', function(){
        $nameSpan.addClass('top');
    });
    $nameInput.on('blur', function(){
        if($nameInput.val()=='')
            $nameSpan.removeClass('top');
    });

    $('button').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
    })
});


Number.prototype.pad = function(size) {
    var s = String(this);
    while (s.length < (size || 2)) {s = "0" + s;}
    return s;
};

function makeError(){
    $('form .main_input').toggleClass('error');
}

function makeSuccess(){
    $('form .main_input').toggleClass('success');
}