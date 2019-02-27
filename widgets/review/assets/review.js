$.featherlight.autoBind = false;



$(document).ready(function(){


    function validateForm($form) {
        if($form.find('[name="Reviews[rating]"]').val()>0)
        {
            return true;
        }
        $form.find('.stars').addClass('error');
        return false;
    }

    var config = {
        otherClose: '.button-close'
    };



    $('#container').on('click', '.left-review-button', function(){
        configReset();
        if($(this).data('type')=='show')
        {
            var review_id = $(this).data('review');
            config.nego_id = $(this).data('nego');
            config.afterOpen = function(){
                showInit();
            };
            $.post('/review/get', {'id':review_id}, function(data){
                console.log(data, data.length);
                if(data)
                {
                    config.text2 = data.text;
                    config.review_id = review_id;
                    config.rating = data.rating;
                    config.rod = data.rod;
                    config.pred = data.pred;
                    if(data.moderated)
                        $.featherlight($('#review-moderated-box'), config);
                    else
                        $.featherlight($('#review-show-box'), config);
                }
            }, 'json');
        }
        else
        {
            config.afterOpen = function(){
                reviewInit();
            };
            config.pred = $(this).data('pred');
            config.rod = $(this).data('rod');
            config.nego_id = $(this).data('review');
            config.user_id = $(this).data('user');
            console.log(config);
            $.featherlight($('#review-box'), config);
        }
    });

    function showInit(){
        console.log('showInit');
        console.log(config);
        var old_config = config;
        var $lightbox = $('.featherlight-content');
        var $container = $lightbox.find('.stars');
        $lightbox.find('.review-text').text(config.text2);
        $container.removeClass('stars-0').addClass('stars-'+config.rating);
        $('.button-edit').on('click', function(){
            var current = $.featherlight.current();
            current.close();
            configReset();
            config.afterOpen = function(){
                reviewInit();
            };
            config.pred = old_config.pred;
            config.rod = old_config.rod;
            config.text2 = old_config.text2;
            config.rating = old_config.rating;
            config.review_id = old_config.review_id;
            config.nego_id = old_config.nego_id;
            $.featherlight($('#review-box'), config);

        })
    }

    function reviewInit(){
        // console.log('review init');
        // console.log(config);
        // console.log(e);
        var $lightbox = $('.featherlight-content');
        var current_class = 'stars-0';
        var $container = $lightbox.find('.stars');
        if(config.rating)
        {
            $container.removeClass(current_class);
            current_class = 'stars-'+config.rating;
            $container.addClass(current_class);
        }
        if(config.text2)
        {
            $lightbox.find('[name="Reviews[text]"]').val(config.text2);
        }
        if(config.review_id)
        {
            $lightbox.find('[name="Reviews[id]"]').val(config.review_id);
        }
        if(config.nego_id)
        {
            $lightbox.find('[name="Reviews[negotiation_id]"]').val(config.nego_id);
        }
        if(config.user_id)
        {
            $lightbox.find('[name="Reviews[user_id]"]').val(config.user_id);
        }
        var $svgs = $container.find('svg');
        // var pred = $(e.target).data('pred');
        var pred = config.pred;
        var rod = config.rod;

        var $p = $lightbox.find('p');
        var txt = $p.html();
        console.log(txt);
        txt = txt.replace('{pred}', pred);
        txt = txt.replace('{rod}', rod);
        $p.html(txt);
        txt = $('#reviews-text').attr('placeholder');
        txt = txt.replace('{pred}', pred);
        $lightbox.find('textarea').attr('placeholder', txt);
        txt = $lightbox.find('.field-reviews-rating label').text();
        txt = txt.replace('{rod}', rod);
        $lightbox.find('.field-reviews-rating label').text(txt);

        // console.log($svgs);
        var hover_class = current_class;
        $svgs.on('click', function(){
            var rating = $(this).index()+1;
            $container.removeClass(current_class).removeClass('hover').removeClass('error');
            current_class = 'stars-'+rating;
            $container.addClass(current_class);
            $lightbox.find('[name="Reviews[rating]"]').val(rating);
            svg_clicked = true;
        });
        $svgs.on('mouseenter', function(){
            var rating = $(this).index()+1;
            $container.removeClass(current_class);
            hover_class = 'stars-'+rating;
            $container.addClass(hover_class).addClass('hover');
        });
        $svgs.on('mouseleave', function(){
            $container.removeClass('hover').removeClass(hover_class);
            $container.addClass(current_class);
        });

        $lightbox.find('form').on('submit', function(e){
            return false;
        });
        $lightbox.find('.send').on('click', function(e){
            e.preventDefault();
            var $form = $lightbox.find('form');
            if(!validateForm($form))
                return false;
            var data = $form.serialize();
            configReset();
            config.currentClass = current_class;
            config.afterClose = function(){
                location.reload();
            };

            if($lightbox.find('textarea').val()=='')
            {
                var confirm = $('#review-moderated-box');
                config.afterOpen = function(){
                    var $lightbox = $('.featherlight-content');
                    var $container = $lightbox.find('.stars');
                    $container.removeClass('stars-0').addClass(config.currentClass);
                };
            }
            else
            {
                var confirm = $('#thx-box');
            }


            console.log(data);
            $.post('/review-send', data, function(){
                var current = $.featherlight.current();
                current.close();
                $.featherlight(confirm, config);
                return false;
            });
            return false;
        })
    }

    function configReset()
    {
        config = {
            otherClose: '.button-close'
        };
    }

});