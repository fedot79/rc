$(document).ready(function(){
    $('.rating-start').appendTo('.stadiya-zapuska');

    var select_prompt = $('#rating-regions').find('option').eq(0);
    select_prompt.prop('disabled', true);

    $('#get_start_rating, #close').on('click', function(){
        $('.stadiya-zapuska').toggleClass('hidden');
        $('#rating-form').toggleClass('hidden');
        $('.map-ccreation').addClass('hidden');
        if(!$('#rating-form').hasClass('hidden'))
        {
            $('.scroll-box').css('max-height', ($('#rating-form').height()-307)+'px');
        }
    });

    $('#close').on('click', function(event){
        event.preventDefault();
        event.stopPropagation();
        $('.stadiya-zapuska').removeClass('hidden');
        $('#rating-form').addClass('hidden');
    });

    var irow = $('#rating-form').find('.rating-row');
    $('#rating-regions').on('change', function(){
        var option = $(this).find('option:selected');
        var clone = irow.clone(true);
        clone.find('input').prop('disabled', false);
        clone.children().eq(0).text(option.text());
        clone.insertBefore('.input-row').removeClass('hidden');
        clone.prepend('<input name="Rating[regions][]" value="'+option.val()+'" type="hidden">');
        option.prop('disabled', true).prop('selected', false);
        select_prompt.prop('selected', true);
        $(this).parent().addClass('hidden');
        $('#add_regions').removeClass('hidden');
        $('.scroll-box').scrollTop($('.scroll-box').height());
    });
    $('#rating-form').on('click', '.delete', function(){
        var val = $(this).siblings('input[name="Rating[regions][]"]').val();
        $('#rating-regions').find('option[value="'+val+'"]').prop('disabled', false);
        $(this).parent().remove();
    });
    $('#rating-form').on('keyup', '[name="Rating[obj_counts][]"]', function(){

        var val = $(this).val();
        // val = val.replace(',', '.');
        res = val.match(/\d*/g);
        if(res == null)
        {
            val = parseInt(val);
            if(typeof val !== "number" || isNaN(val) )
                val = '';
        }
        else
        {
            val = res[0];
        }
        $(this).val(val);
        if(val!=='')
        {
            $(this).next().text('').parent().removeClass('has-error');
        }
    })


    $('#add_regions').on('click', function(){
        $(this).addClass('hidden');
        $('.scroll-box').scrollTop($('.scroll-box').height());
        $('#rating-regions').parent().removeClass('hidden');
    })

    $('#rating-form').on('click', 'button[type="submit"]', function(){
        if(form_validate())
        {
            var data = $('#rating-form').serialize();
            $.post('/rating-send', data, function(ans){
                console.log(ans);
                if(ans && ans>0)
                {
                    $('.rating-success').find('.stars').removeClass('stars-1').addClass('stars-'+ans);
                    $('.rating-success').find('.rating-text').find('span').eq(1).text(ans);
                    var $up_stars = $('.user-panel').find('.stars');
                    if($up_stars.length>0)
                    {
                        $up_stars.attr('class').split(' ').some(function(e, i, a){
                            if(e.slice(0,-1)=='stars-')
                            {
                                $up_stars.removeClass(e).addClass('stars-'+ans);
                                $('.rate-line.rate-number').find('span').text(ans);
                                return true;
                            }
                            return false;
                        });

                    }
                    var $cs_stars = $('.card-header').find('.stars')
                    if($cs_stars.length>0)
                    {
                        $cs_stars.attr('class').split(' ').some(function(e, i, a){
                            if(e.slice(0,-1)=='stars-')
                            {
                                $cs_stars.removeClass(e).addClass('stars-'+ans)
                                return true;
                            }
                            return false;
                        });
                    }


                }
                $("#rating-form").remove();
                $('.rating-start').remove();
                $('.rating-success').removeClass('hidden');
            });
        }
        return false;
    });

    $('#close-rating-success').on('click', function(){
        $('.rating-success').remove();
        $('.stadiya-zapuska').removeClass('hidden');
    })

    function form_validate()
    {
        var error = false;
        var inputs = 0;
        $('.rating-row input').not(':disabled').each(function(i,e){
            inputs++;
            // console.log(e);
            if($(e).val()==''){
                $(e).parent().addClass('has-error');
                $(e).next().text('Это поле не может быть пустым');
                error = true;
            }
        });
        if(inputs==0)
        {
            $('.submit-row').find('.help-block').removeClass('hidden');
        }

        if(error || inputs==0)
            return false;
        return true;
    }
});
