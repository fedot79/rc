$(document).ready(function(){
    var $expln = $('.expln');
    var newbie_counter = 4;
    if($expln.length>0)
    {
        var newbie = !$('#hints').hasClass('hidden');



        $expln.find('p.object').on('click', function(){
            $('.obj_type_hint').removeClass('hidden');
            $('#hints').removeClass('hidden');
        })

        $expln.find('p.deal').on('click', function(){
            $('.type_hint').removeClass('hidden');
            $('#hints').removeClass('hidden');
        })

        $expln.find('p.neccesr').on('mouseenter', function(){
            $('.card-head').find('label').find('span').addClass('highlite-color');
            $('span.object-type').addClass('highlite-color');
            $('.slide img').addClass('highlite-background');
            $('#objects-square').addClass('highlite-background');
            $('#addressform-address_string').addClass('highlite-background');
            $('#search-square_string').addClass('highlite-background');
            $('#search-distance').addClass('highlite-background');
        })
        $expln.find('p.neccesr').on('mouseleave', function(){
            $('.card-head').find('label').find('span').removeClass('highlite-color');
            $('span.object-type').removeClass('highlite-color');
            $('.slide img').removeClass('highlite-background');
            $('#objects-square').removeClass('highlite-background');
            $('#addressform-address_string').removeClass('highlite-background');
            $('#search-square_string').removeClass('highlite-background');
            $('#search-distance').removeClass('highlite-background');
        })

        $expln.find('p.adres').on('click', function(){
            $('.map_hint').removeClass('hidden');
            $('#hints').removeClass('hidden');
        })

        $expln.find('p.dop').on('click', function(){
            $('.others_hint').removeClass('hidden');
            $('#hints').removeClass('hidden');
        })

        $('#hints').on('click', 'a', function(e){
            e.preventDefault();
            $('#hints').addClass('hidden');
            $(this).parent().addClass('hidden');
            if(newbie && newbie_counter>0)
            {
                show_next();
            }
        })

        if(newbie)
        {
            $('.map_hint').removeClass('hidden');
            $('#hints').removeClass('hidden');
        }

        function show_next(){
            newbie_counter--;
            if(newbie_counter==3)
            {
                $('.obj_type_hint').removeClass('hidden');
                $('#hints').removeClass('hidden');
            }
            if(newbie_counter==2)
            {
                $('.type_hint').removeClass('hidden');
                $('#hints').removeClass('hidden');
            }
            if(newbie_counter==1)
            {
                $('.others_hint').removeClass('hidden');
                $('#hints').removeClass('hidden');
            }
            if(newbie_counter==0)
                newbie = false;
        }
    }
});