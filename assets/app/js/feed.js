$(document).ready(function(){
    var $error =  $('.progress-bar-error');
    var $info = $('.progress-bar-info');
    var $progress = $('.progress-bar-tick');
    var feed_id;
    var xhr_faults = 0;
    function clearError(){
        $error.addClass('hidden');
        $error.text('');
    }

    function setFailed()
    {
        $('.progress-bar').addClass('error');
    }

    function showError(msg)
    {
        if($error.html().length>0)
            msg = $error.html()+'<br>'+msg;
        $error.removeClass('hidden');
        $error.html(msg);
    }

    function setInfo(msg)
    {
        $info.html(msg);
    }

    function setProgress(val)
    {
        $progress.parent().removeClass('hidden');
        $progress.css('width', parseInt(val)+'%');
    }

    function retryAjax()
    {
        xhr_faults++;
        if(xhr_faults>5)
        {
            setFailed();
            showError('Ошибка загрузки');
        }
        else
        {
            setTimeout(function(){
                checkAnswer();
            }, 1000)
        }
    }

    function checkAnswer() {
        $.get('/feeds/status/'+feed_id, function(answer){
            clearError();
            if(answer)
            {
                if(answer.status=='fail')
                {
                    setFailed();
                    if(answer.error)
                    {
                        showError(answer.error);
                    }
                    else
                    {
                        showError('Ошибка загрузки');
                    }
                    return false;
                }
                if(answer.status=='ok')
                {
                    if(answer.error)
                    {
                        setInfo(answer.error)

                    }
                    if(answer.rows && answer.ready)
                    {
                        setInfo('Загружено объектов: '+answer.ready+' из '+answer.rows);
                        setProgress(answer.ready/answer.rows*100);
                    }
                    setTimeout(function(){
                        checkAnswer();
                    }, 1000);
                    return false;
                }
                if(answer.status=='ready')
                {
                    setInfo('Разбор файла закончен, показываем результаты...');
                    setProgress(100);
                    setTimeout(function(){
                        window.location = '/feeds/check';
                    }, 500);
                    return false;
                }
                console.log('false ajax');
                retryAjax();
            }
            else
            {
                retryAjax();
            }
        })
    }

    $('#feeduploadform-file').on('change', function(){
        clearError();
        var file;
        var errors=false;
        console.log(this.files);
        if(this.files && this.files.length == 1)
        {
            file = this.files[0];
            if(['xls', 'xlsx'].indexOf(file.name.split('.').pop())==-1)
            {
                showError('Неверный формат файла. К загрузке принимаются только файлы формата .xlsx или .xls');
                errors = true;
            }
            if(file.size>20000000)
            {
                showError('Загрузка ограничена размером файла в 20Мб. Вы можете разбить таблицу на более мелкие файлы.');
                errors = true;
            }
            if(!errors)
            {
                var form_data = new FormData($('#feed_form')[0]);
                $.ajax({
                    type: 'POST',
                    url: $('#feed_form').attr('action'),
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: function(answer){
                        if(answer && answer.status=='ok')

                            feed_id = parseInt(answer.id);
                            setInfo('Файл загружен');
                            setTimeout(function(){
                                checkAnswer();
                            }, 1000);
                    },
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                console.log(evt.loaded, evt.total);
                                var percentComplete = evt.loaded / evt.total;
                                setInfo('Загрузка:');
                                setProgress(percentComplete*100);
                            }
                        }, false);

                        xhr.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                console.log(evt.loaded, evt.total);
                                var percentComplete = evt.loaded / evt.total;
                                setInfo('Загрузка:');
                                setProgress(percentComplete*100);
                            }
                        }, false);

                        return xhr;
                    },
                });
            }
        }
    });


    $('#feed_form').on('submit', function(event){
        console.log('submit');
        var form = this;
        event.preventDefault();
        var form_data = new FormData($('#feed_form')[0]);
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: form_data,
            processData: false,
            contentType: false,
            success: function(answer){
                console.log(answer);
            }
        });
        return false;
    });
});