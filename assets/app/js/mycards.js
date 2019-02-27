$(document).ready(function(){
    $('.card-list').on('click mousedown', '.edit', function(e){
        var url = '/'+window.page_type+'-edit/'+$(this).data('id');
        if(e.type == 'click')
            window.location = url;
        if(e.type=='mousedown' && e.originalEvent.which==2)
        {
            var win = window.open(url, '_blank');
            if (win) {
                win.focus();
            }
        }
    });

    $('.card-list').on('click', '.status', function(e){
        var $card = $(this).parents('.card');
        if(confirm('Удалить '+(window.page_type=='object'?'объект':'потребность')+'?'))
        {
            var url = '/'+window.page_type+'-hide/'+$(this).data('id');
            $.get(url, function(ans){
                if(ans=='restricted')
                {
                    alert('По '+(window.page_type=='object'?'этому объекту':'этой потребности')+' есть переговоры в активной фазе. Чтобы удалить '+(window.page_type=='object'?'объект':'потребность')+' необходимо сначала их завершить или отменить');
                }
                if(ans=='ok')
                {
                    $card.remove();
                }
            })
        }
    })

    $('#filter-top').on('click', function(){
        $(this).toggleClass('opened');
    })
    $('#filter-dd').on('click', 'li', function(){
        $(this).siblings().removeClass('active');
        $('.filter').find('a').addClass('hidden');
        $('.filter').find('a[data-type="'+$(this).data('id')+'"]').removeClass('hidden');
        $(this).addClass('active');
        $('#filter-top').toggleClass('opened');
    })
    $('.filter').on('click', 'a', function(event){
        $(this).siblings().filter('[data-type="'+$(this).data('type')+'"]').removeClass('active');
        $(this).addClass('active');
    })
    $(document).on('pjax:success', function(event, data, status, xhr, options) {
        var type = $('#filter-dd .active').data('id');
        $('.filter').find('a').addClass('hidden');
        $('.filter').find('a[data-type="'+type+'"]').removeClass('hidden');
    });
});