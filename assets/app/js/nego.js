$(document).ready(function () {
    var $card_popup = $('.card-popup');
    var $current_parent;
    var current_nego;

    function showCard($card, confirmed) {
        $card_popup.appendTo('body');
        $card_popup.removeClass('hidden').append($card);
        $card_popup.one('click', function () {
            closePopup($card);
        });
        $card.cardMap();
        if (confirmed && $card.find('.card-contacts').length > 0) {
            console.log($card);
            $card_popup.addClass('open_contact');
            $cont = $card.find('.card-contacts');
            console.log($cont, $card);
            $cont.insertAfter($card);
            $card.before('<div class="backplate">');
            $card.cardCityMap();
        }
    }

    $('.card-list').on('click', '.showcard', function(){
        $current_parent = $(this).parents('.object');
        var query = {};
        var id = $(this).data('id');
        var confirmed = $current_parent.hasClass('confirmed') || $current_parent.hasClass('archived');
        console.log(confirmed);
        if(id)
            query['id'] = id;
        var type = $(this).data('type');
        if(type)
            query['type'] = type;
        if($(this).data('nego'))
        {
            query['nego'] =$(this).data('nego');
            current_nego = $(this).data('nego');
        }

        $.get('/card/get-card?'+$.param(query), function(ans){

            var $card = $(ans);
            showCard($card, confirmed);

            $card.on('click', function(event){
                event.stopPropagation();
            });
            $card.find('span.cancel').on('click', function(){
                if($current_parent.length>0)
                {
                    if($(this).data('cancel'))
                    {
                        sendCancel($(this).data('cancel'), $current_parent);
                    }
                }
            })
            $card.find('span.reject').on('click', function(){
                if($current_parent.length>0)
                {
                    if($(this).data('reject'))
                    {
                        sendReject($(this).data('reject'), $current_parent);
                    }
                }
            })
            $card.find('a.accept').on('click', function(event){
                event.preventDefault();
                if($current_parent.length>0)
                {
                    if($(this).data('accept'))
                    {
                        sendAccept($(this).data('accept'), $current_parent, query);
                    }
                }
            })
        })
    });
    $('.card-list').on('click mousedown', '.confirmed,.archived img.av', function(e){
        if($(this).data('url'))
        {
            url = $(this).data('url');
            if(e.type == 'click')
                window.location = url;
            if(e.type=='mousedown' && e.originalEvent.which==2)
            {
                var win = window.open(url, '_blank');
                if (win) {
                    win.focus();
                }
            }
        }
    });

    $('.card-list').on('click', 'button.action.closenego', function(){
        if($(this).data('url'))
        {
            $.get($(this).data('url'), function(ans){
                if(ans=='ok')
                {
                    $.pjax.reload('#p0', {timeout: 3000}); //todo remove hardcoded pjax id
                }
            });
        }
    });

    $('.card-list').on('click', 'button.cancel', function(){

        $par = $(this).parents('.object');
        if($(this).data('cancel'))
        {
            sendCancel($(this).data('cancel'), $par);
        }
    });
    // $card_popup.on('click', 'span.cancel', fus

    function removeCard($card)
    {
        $parent = $card.parents('.nego');
        $card.remove();
        if($parent.find('.object').length==0)
        {
            $parent.remove();
        }
    }

    function sendCancel(cancel_data, $parent)
    {
        $.post('/selection/cancel',
            {
                'search_id':cancel_data['s'],
                'object_id':cancel_data['o']
            },
            function(){
                removeCard($parent);
                closePopup();
            }
        );
    }

    function sendReject(reject_data, $parent)
    {
        $.post('/selection/reject',
            {
                'search_id':reject_data['s'],
                'object_id':reject_data['o']
            },
            function(){
                removeCard($parent);
                closePopup();
            }
        );
    }

    function sendAccept(accept_data, $parent, query)
    {
        $.get('/payment/'+accept_data['o']+'/'+accept_data['s']+'/'+accept_data['t'],
            function(ans){
                if(ans=='ok')
                {

                    $.get('/card/get-card?'+$.param(query), function(ans){
                        //through pjax refresh card status waiting=>confirmed
                        $.pjax.reload('#p0', {timeout: 3000}); //todo remove hardcoded pjax id
                        closePopup();
                        var $card = $(ans);
                        showCard($card, true);
                        $card.on('click', function(event){
                            event.stopPropagation();
                        });
                    });
                }
            }
        );
    }

    function closePopup($card)
    {
        if(typeof $card !== 'undefined')
            $card.remove();
        $card_popup.html('');
        $card_popup.attr('class', 'card-popup hidden');
    }
});