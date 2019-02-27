$(document).ready(function(){
    function resize(){
        if(window.innerWidth<=666)
        {
            $('body').addClass('mobile');
        }
        else
        {
            $('body').removeClass('mobile');
        }
    }

    $(window).on('resize', resize);
    resize();
});