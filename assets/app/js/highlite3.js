$(document).ready(function(){
    var $container = $('#container');
    var $expln = $('.explain-trigger');
    // var $start = $expln.find('.next-hint');
    var $start = $expln.find('.trigger');
    var $show_hints = $('#show-hints');
    var $close_hints = $('#close-hints');
    var show_all = false;
    var newbie_counter = 1;
    var current_stage;
    if($expln.length>0)
    {

        var newbie = $('#container').hasClass('first-time');
        if(newbie)
        {
            console.log('newb');
            current_stage = 'hint-stage-1';
            newbie_counter++;
        }

        $show_hints.on('click', function(){
            $container.addClass('hint-stage-all');
            show_all = true;
        });

        $close_hints.on('click', function(){
            $container.removeClass('hint-stage-all');
            show_all = false;
        });

        $start.on('click', function(){
            console.log('start click');
            if(newbie)
            {
                if(typeof current_stage == 'undefined')
                {
                    console.log('no current stage');
                    current_stage = 'hint-stage-1';
                    $container.addClass(current_stage);
                    newbie_counter++;
                }
                else
                {
                    console.log(current_stage);
                    if(newbie_counter>4)
                    {
                        $container.removeClass(current_stage);
                        $container.removeClass('first-time');
                        newbie = false;
                        // $container.addClass('hint-stage-all');
                        show_all = false;
                        return false;
                    }
                    $container.removeClass(current_stage);
                    current_stage = 'hint-stage-'+newbie_counter;
                    $container.addClass(current_stage);
                    newbie_counter++;

                }
            }
            else
            {
                $container.removeClass(current_stage);
                $container.addClass('hint-stage-all');
                show_all = true;
            }
        });

        $('#hint-stage-1').on('click', function(){
            if(current_stage)
                $container.removeClass(current_stage);
            current_stage = 'hint-stage-1';
            $container.addClass(current_stage);
            $container.removeClass('hint-stage-all')
        });

        $('#hint-stage-2').on('click', function(){
            if(current_stage)
                $container.removeClass(current_stage);
            current_stage = 'hint-stage-2';
            $container.addClass(current_stage);
            $container.removeClass('hint-stage-all')
        });

        $('#hint-stage-3').on('click', function(){
            if(current_stage)
                $container.removeClass(current_stage);
            current_stage = 'hint-stage-3';
            $container.addClass(current_stage);
            $container.removeClass('hint-stage-all')
        });

        $('#hint-stage-4').on('click', function(){
            if(current_stage)
                $container.removeClass(current_stage);
            current_stage = 'hint-stage-4';
            $container.addClass(current_stage);
            $container.removeClass('hint-stage-all')
        });

        $('#hint-stage-5').on('click', function(){
            if(current_stage)
                $container.removeClass(current_stage);
            current_stage = 'hint-stage-5';
            $container.addClass(current_stage);
            $container.removeClass('hint-stage-all')
        });
    }
});