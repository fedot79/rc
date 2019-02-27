$(document).ready(function(){
    var md = new MobileDetect(window.navigator.userAgent);
    if(md.phone()!==null)
    {
        // if(window.location.pathname!=='/')
        //     window.location=='/';
        $('body').addClass('mobile');
        $('body').prepend('<div class="popever-mobile"><p>Мобильная версия сервиса будет доступна 21.01.2019' +
            '<br>Приглашаем зайти на сайт с компьютера</p></div>')
    }
    // alert(md.mobile());
});