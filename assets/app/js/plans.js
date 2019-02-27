$(document).ready(function(){
    $tt = $('.tariff-table');
    for(var i = 2; i<21; i++)
    {
        var summ = i*1000;

        $tt.find('tbody').append('<tr><td>'+summ+'&thinsp;₽</td><td>'+i+'%</td><td><strong>'+(summ*i*0.02+summ)+'&thinsp;₽</strong></td><td><strong>'+(summ*i*0.01+summ)+'&thinsp;₽</strong></td></tr>');
    }
    $('#send-notice').on('click', function(event){
        if($('#email-input').val()=='')
        {
            $(this).parent().addClass('error');
            console.log($(this).parent());
            return false;
        }
        else
        {
            $.post('/user/save-email', {'mail':$('#email-input').val()}, function(){
                $('#send-notice').addClass('success').attr('id', '').text('Спасибо, заявка принята')
            })
        }
    });
    $('#email-input').on('keyup', function (event) {
        if($(this).val()!=='')
        {
            $(this).parent().removeClass('error');
        }
    })
});