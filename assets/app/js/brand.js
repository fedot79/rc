$(document).ready(function() {
    var $card = $('.card-new');
    var id = $card.attr('id');
    var $style = $('#style-for-'+id);
    var $cardType = $card.find('.card-type');
    var colorThief = new ColorThief();
    var $palette = $('#palette');
    var color_empty = true;
    var $reset = $('#clear-form');
    var $logo;
    var $inputRow = $('.row-file-input');
    var $selectedRow = $('.row-file-selected');
    var $deleteFile = $selectedRow.find('.delete-file');
    var $fileError = $selectedRow.find('.file-error');
    var $cardActions = $card.find('.card-actions');
    var $currentStyle = $('<span>').addClass('color-change').text('Это текущее оформление');
    var $changedStyle = $('<span>').addClass('hidden color-change').text('Оформление изменено');
    $cardActions.children().addClass('hidden');
    $cardActions.append($changedStyle).append($currentStyle)//.append('<span class="tooltip" data-toggle="tooltip" data-placement="right" title="Подсказака"></span>');


    function rgbToHex(r, g, b) {
        return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
    }
    function hexToRgb(color, opacity) {
        return 'rgba(' + parseInt(color.slice(-6,-4),16)
        + ',' + parseInt(color.slice(-4,-2),16)
        + ',' + parseInt(color.slice(-2),16)
        +','+opacity+')'
    }
    function rgbStringToArray(rgb)
    {
        rgb = rgb.substring(4, rgb.length-1)
            .replace(/ /g, '')
            .split(',');
        return rgb;
    }

    $reset.on('click', function(){
        $('#brand-form')[0].reset();
        processColor('#434a53');
        $palette.children().remove();
        $palette.addClass('disabled');
        if($logo)
            $logo.remove();
        if($brand_logo)
            $brand_logo.remove();
        $cardType.removeClass('with-logo');
        $('#brand-logo').val('');
        $.ajax('/brand/drop-brand').done(function(){
            window.location = '/branding';
        });

        // canSubmit();
    });

    function processColor(color) {
        console.log(color);
        if(color.search('rgb')!=-1)
        {
            var arr = rgbStringToArray(color);
            var rgbaCol = 'rgba('+arr[0]+','+arr[1]+','+arr[2]+',0.1)';
        }
        else
        {
            var rgbaCol = hexToRgb(color, 0.1);
        }
        $card.addClass('branded');
        $card.css({
            'color':color,
            'border-color':color,
            'background-color':color,
            'fill':color,
            'stroke':color,
            'box-shadow':'0px 10px 21px 0px '+rgbaCol
        });
        $style.html('#'+id+' .card-deal{background-color:'+rgbaCol+'}#'+id+' .button-common:hover{background-color:'+color+'}');
        var circle = $card.data('circle');
        if(typeof circle == 'object')
        {
            circle.setOptions({'strokeColor':color, 'fillColor':color});
        }
        $changedStyle.removeClass('hidden');
        $currentStyle.addClass('hidden');
        canSubmit();
    }

    $('#brand-color').on('change', function(){

        console.log($(this).val());
        processColor($(this).val());
    });
    $('#brand-logo').on('change', function(){
        var file = this.files[0];
        if(file)
        {
            processFile(file);
        }
    })

    $('#brand-name').on('change', function(){
        $('.logo').attr('title', $(this).val());
        $('.card-type').find('img').attr('title', $(this).val());
        canSubmit();
    });

    var $brand_logo = $('.card-header div.logo');
    if($brand_logo.length>0)
    {
        var $img = $('<img>').css('display', 'none').attr('src', $brand_logo.css('background-image').replace('url("', '').replace('")', ''));
        $('body').append($img);
        $img.on('load', function() {
            var palette = colorThief.getPalette($img[0]);
            $img.remove();
            $palette.removeClass('disabled').children().remove();
            $.each(palette, function(i,e){
                var $span = $('<span>').data('color', rgbToHex(e[0], e[1], e[2])).css('background-color', rgbToHex(e[0], e[1], e[2]));
                $palette.append($span);
            })
        });
    }

    function hideFileError() {
        $fileError.addClass('hidden');
    }

    $deleteFile.on('click', function(){
        hideFileError();
        $palette.children().remove();
        $palette.addClass('disabled');
        if($logo)
            $logo.remove();
        if($brand_logo)
            $brand_logo.remove();
        $cardType.removeClass('with-logo');
        if($('#brand-color').val()!='' || $('#brand-name').val()!='')
            canSubmit();
        else
            cantSubmit();
        $inputRow.removeClass('hidden');
        $selectedRow.addClass('hidden');
    });

    function showFileError(error) {
        $fileError.removeClass('hidden').text(error);
    }


    function processFile(file) {
        $inputRow.addClass('hidden');
        $selectedRow.removeClass('hidden');
        $selectedRow.find('.file-name').text(file.name);
        if(file.size>2000000)
        {
            console.log('file size limit');
            showFileError('Файл слишком большой. Выберите файл подходящего размера.');
            cantSubmit();
            return false
        }
        if(['image/jpeg', 'image/png'].indexOf(file.type)<0)
        {
            showFileError('К загрузке допустимы только графические файлы в форматах jpg и png');
            console.log('file type wrong', file.type);
            cantSubmit();
            return false
        }
        var preview = window.URL.createObjectURL(file);
        // var colorThief = new ColorThief();
        $logo = $('<div>').addClass('logo').css('background-image', 'url('+preview+')');
        var $img = $('<img>').css('display', 'none').attr('src', preview);
        $('body').append($img);
        $cardType.addClass('with-logo').find('.logo').remove();
        $cardType.append($logo);
        $img.on('load', function() {
            var palette = colorThief.getPalette($img[0]);
            $img.remove();
            $palette.children().remove();
            $palette.removeClass('disabled');
            $.each(palette, function(i,e){
                var $span = $('<span>').data('color', rgbToHex(e[0], e[1], e[2])).css('background-color', rgbToHex(e[0], e[1], e[2]));
                $palette.append($span);
            })
        });
        // console.log(colorThief.getColor($img[0]));
        $changedStyle.removeClass('hidden');
        $currentStyle.addClass('hidden');
        canSubmit();
    }
    $palette.on('click', 'span', function(){
        $('#brand-color').val($(this).data('color'));
        processColor($(this).css('background-color'));
    });
    $palette.on('mouseenter', 'span', function(){
        var color = hexToRgb($(this).data('color'), 0.1);
        $(this).css('box-shadow', '0px 4px 10px 0px '+color);
    });
    $palette.on('mouseleave', 'span', function(){
        $(this).css('box-shadow', 'none');
    });

    // var dragTimer=null;
    // var dragOn=false;

    $('.content-container').on('dragover', function(event){
        event.preventDefault();
        $('.drop-zone-wrap').removeClass('hidden');
        console.log('drag on', event.relatedTarget);
    });

    $('.content-container').on('dragleave', function(event){
        event.preventDefault();
        if(event.relatedTarget==$('.drop-zone-wrap')[0])
            return false;
        else
        {
            $('.drop-zone-wrap').addClass('hidden');
        }
        console.log('drag off', event.relatedTarget);
    });

    $('.drop-zone-wrap').on('drop', function(event){
        event.preventDefault();
        console.log('drop', event.relatedTarget);
        $('.drop-zone-wrap').addClass('hidden');

        var file = event.originalEvent.dataTransfer.files[0];
        if(file)
        {
            $('#brand-logo')[0].files = event.originalEvent.dataTransfer.files;
            processFile(file);
        }
    });

    function canSubmit(){
        $('input[type=submit]').attr('disabled', false);
    }

    function cantSubmit(){
        $('input[type=submit]').attr('disabled', true);
    }

    $('#brand-form').on('submit', function(event){
        if($(this).data('submit')=='false' ||  $(this).data('submit')==false)
        {
            event.preventDefault();
            return false;
        }
        $('#brand-color').attr('type', 'text');
    })

});