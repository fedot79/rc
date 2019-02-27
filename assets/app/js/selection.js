$(document).ready(function(){
    $('#card0').addClass('active');
    var $map = $('#map-container');
    var current_slide = 0;
    var $slides = $('.card-new:not(.card-dummy)');
    var slide_count = $slides.length;
    var $current_slide = $('#card0');
    var $slider_track = $('.slider-track');
    var $container = $('#container');

    console.log($slides, slide_count);

    //set specific card
    if(window.location.hash)
    {
        var current_id = parseInt(window.location.hash.replace('#', ''));
        $slides.each(function(index,element){
            if($(element).data('id')==current_id)
            {
                slideTo(index);
            }
        });
    }

    if($current_slide.find('.map-container').length>0)
        $current_slide.cardMap();
    else
        $current_slide.cardCityMap();
    // console.log($current_slide);
    var type = $current_slide.data('type');
    // console.log(type);
    // if($current_slide.length > 0)
    // {
    // }
    // else
    // {
    //
    // }

    if(!$current_slide.hasClass('seen'))
    {
        $.post('/selection/seen', seenData());
        $current_slide.addClass('seen');
    }

    $slides.find('span.reject').on('click', function(){
        console.log('reject');
        console.log(seenData());
        $.post('/selection/reject', seenData());
        removeCurrent();
    });

    $slides.find('span.cancel').on('click', function(){
        console.log('cancel');
        $this_slide_id = $current_slide.data('id');
        $btn_row = $(this).parent();
        $.post('/selection/cancel', seenData(), function(){
            window.location.reload();
        });
    });

    $slider_track.on('click', '.card-new:not(.active)', function(event){
        console.log('slide click');
        console.log($(this).index('.card-new'));
        event.preventDefault();
        event.stopPropagation();
        slideTo($(this).index('.card-new'));
        return false;
    });
    $slider_track.swipe( {
        //Generic swipe handler for all directions
        swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
            if($slider_track.hasClass('zoom-inside'))
                return;
            console.log(current_slide, slide_count);
            if(direction=='left' && current_slide<slide_count-1)
            {
                slideTo(++current_slide);
            }
            if(direction=='right' && current_slide>0)
                slideTo(--current_slide);
        }
    });



    function slideTo(index){
        console.log('slideTo', index, slide_count);
        if(index>=0 && index<slide_count)
        {
            current_slide = index;
            $('.slider-track').css('transform', 'translate(-'+224*current_slide+'px, 0)');
            $current_slide.removeClass('active');
            $current_slide.removeClass('zoom-map');
            $current_slide = $slides.eq(index);
            if($current_slide.find('.map-container').length>0)
                $current_slide.cardMap();
            else
                $current_slide.cardCityMap();
            $current_slide.addClass('active');

            // if(!$current_slide.hasClass('seen'))
            // {
            //     $.post('/selection/seen', seenData());
            //     $current_slide.addClass('seen');
            // }
        }
    };

    function removeCurrent()
    {
        var _prev_slide = $current_slide;
        _prev_slide.addClass('removing');

        setTimeout(function(){
            _prev_slide.addClass('removed')
        }, 10);
        setTimeout(function(){
            _prev_slide.remove();
            $slides = $('.card-new');
            slide_count = $slides.length;
        }, 500);
        slideTo(++current_slide);
    }

    function seenData()
    {
        return {
            'search_id':((type=='objects')?window.this_card_id:$current_slide.data('id')),
            'object_id':((type=='objects')?$current_slide.data('id'):window.this_card_id),
            'type':((type=='objects')?'buyer':'seller')
        }
    }

    function showScrollBar()
    {
        // console.log($slider_track.outerWidth(), $container.outerWidth());
        if($slider_track.outerWidth()>$container.outerWidth())
        {
            $container.addClass('with-scrollbar');
        }
        else
        {
            $container.removeClass('with-scrollbar');
        }
    }
    $(window).on('resize', function(){
        showScrollBar();
    });
    setTimeout(showScrollBar, 1500);
    // showScrollBar();

    var isInViewport = function (elem) {
        var distance = elem.getBoundingClientRect();
        return (
            distance.top >= 0 &&
            distance.left >= 0 &&
            distance.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            distance.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    };

    var replaceCard = function($card){
        $card.removeClass('wait');
        var params = $card.data('card');
        // console.log(params);
        $.get('/card/get-card-selection?id='+params.id+'&type='+params.t+'&selection_id='+params.s+'&counter_id='+params.c, function(ans){
            if(ans)
            {
                var $ncard = $(ans);
                $ncard.attr('id', 'card'+2*params.c);
                $card.replaceWith($ncard);
                $slides.add($ncard);
                slide_count++;
            }
        })
    }

    var checkCards = function(){
        $('.card-dummy.wait').each(function(index, element){
            // console.log(isInViewport(element), element);
            if(isInViewport(element))
            {
                // console.log($(element));
                replaceCard($(element));
            }
        })
    };
    checkCards();
    $container.on('scroll', function(){
        checkCards();
    });


});