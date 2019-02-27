$(document).ready(function(){
    var $expln = $('.expln');
    if($expln.length>0)
    {
        $expln.find('p.object').on('mouseenter', function(){
            $('#card').addClass('haide');
            $('#container-hint').addClass('shaw');
            $('#w0-hint').addClass('shaw');
            $('#w0-hint').find('.par-ccreation-hint').find('.par-ccreation-head.hint').find('.par-ccreation-head-left.hint').addClass('shaw');
            $('#w0-hint').find('.par-ccreation-hint').find('.par-ccreation-head.hint').find('.par-ccreation-head-left.hint').find('.obj-type-hint').addClass('shaw');
            $('#w0-hint').find('.par-ccreation-hint').find('.par-ccreation-head.hint').find('.par-ccreation-head-left.hint').find('.object-type.ttse').addClass('shaw');
            $('#w0-hint').find('.par-ccreation-hint').find('.objects-use_id.hint').addClass('shaw');
            $('#w0-hint').find('.object-type-hint').addClass('shaw');
        })
        $expln.find('p.object').on('mouseleave', function(){
            $('#card').removeClass('haide');
            $('#container-hint').removeClass('shaw');
            $('#w0-hint').removeClass('shaw');
            $('#w0-hint').find('.par-ccreation-hint').find('.par-ccreation-head.hint').find('.par-ccreation-head-left.hint').removeClass('shaw');
            $('#w0-hint').find('.par-ccreation-hint').find('.par-ccreation-head.hint').find('.par-ccreation-head-left.hint').find('.obj-type-hint').removeClass('shaw');
            $('#w0-hint').find('.par-ccreation-hint').find('.par-ccreation-head.hint').find('.par-ccreation-head-left.hint').find('.object-type.ttse').removeClass('shaw');
            $('#w0-hint').find('.par-ccreation-hint').find('.objects-use_id.hint').removeClass('shaw');
            $('#w0-hint').find('.object-type-hint').removeClass('shaw');
        })

        $expln.find('p.deal').on('mouseenter', function(){
            $('.card-head').find('label').find('span').addClass('highlite-background');
        })
        $expln.find('p.deal').on('mouseleave', function(){
            $('.card-head').find('label').find('span').removeClass('highlite-background');
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

        $expln.find('p.adres').on('mouseenter', function(){
            $('#addressform-address_string').addClass('highlite-background');
        })
        $expln.find('p.adres').on('mouseleave', function(){
            $('#addressform-address_string').removeClass('highlite-background');
        })

        $expln.find('p.dop').on('mouseenter', function(){
            $('#objects-floor').addClass('highlite-background');
            $('#objects-column').addClass('highlite-background');
            $('#objects-ceil').addClass('highlite-background');
            $('#search-floor').addClass('highlite-background');
            $('#search-column').addClass('highlite-background');
            $('#search-ceil').addClass('highlite-background');
            $('i').addClass('highlite-background');
        })
        $expln.find('p.dop').on('mouseleave', function(){
            $('#objects-floor').removeClass('highlite-background');
            $('#objects-column').removeClass('highlite-background');
            $('#objects-ceil').removeClass('highlite-background');
            $('#search-floor').removeClass('highlite-background');
            $('#search-column').removeClass('highlite-background');
            $('#search-ceil').removeClass('highlite-background');
            $('i').removeClass('highlite-background');
        })
    }
});