$(document).ready(function(){
    // console.log('intro loaded');
    $wrapper = $('.full-wrapper').addClass('wrapper-blck');
    $('.wrap').append($wrapper);
    var $slides = $('.intro-frame'); console.log($slides.length);
    var $cur_slide = $slides.eq(0);
    var cur_slide = 1;
    var $next_prev_buttons = $('.intro-click');
    var $pager = $('.intro-pager');
    var $pager_dots = $pager.find('.dot');

    var $button = $('#help-me').clone();
    // window.$button = $button;
    $button.insertBefore($('#help-me')).attr('id', 'intro-button').text('ИНСТРУКЦИЯ');
    $button.on('click', function(){
        $wrapper.removeClass('hidden');
        $wrapper.children('.intro').on('click', function(event){
            event.stopPropagation();
        })
    });

    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
    if(getCookie('intro_shown')!=='1')
    {
        $('body').addClass('intro-here');
        $wrapper.removeClass('hidden');
    }

    $next_prev_buttons.on('click', function(event){
        if($(this).hasClass('done'))
            closeIntro();
        if($(this).hasClass('prev'))
        {
            showSlide(cur_slide-1);
        }
        else
        {
            showSlide(cur_slide+1);
        }
    });

    $('.intro-done').on('click', function(){
        closeIntro();
    });

    $('.intro-next').on('click', function(){
        showSlide(cur_slide+1);
    });

    function showSlide(next_slide)
    {
        if(next_slide<1 || next_slide>$slides.length)
            return false;

        if(next_slide==1)
        {
            $next_prev_buttons.eq(0).addClass('hidden');
            $pager.addClass('hidden')
        }
        else{
            $next_prev_buttons.eq(0).removeClass('hidden');
            $pager.removeClass('hidden')
        }

        if(next_slide==$slides.length)
            $next_prev_buttons.eq(1).addClass('done');
        else
            $next_prev_buttons.eq(1).removeClass('done');


        $pager_dots.eq(cur_slide-2).removeClass('active');
        cur_slide = next_slide;
        $pager_dots.eq(cur_slide-2).addClass('active');

        $cur_slide.removeClass('active');
        $cur_slide = $slides.eq(cur_slide-1);
        $cur_slide.addClass('active');
    }

    function closeIntro(){
        $('.full-wrapper').addClass('hidden');
        $('body').removeClass('intro-here');
        document.cookie = "intro_shown=1; path=/; expires=Tue, 19 Jan 2038 03:14:07 GMT";
        $('#intro_manual').trigger('pause');
    }

    $('.intro-close-top,.intro-close').on('click', function(){
        closeIntro();
    })
    $wrapper.on('click', function(){
        closeIntro();
    })
});