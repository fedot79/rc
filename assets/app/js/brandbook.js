$(document).ready(function(){
    $("#flipbook").css('display', 'block');
    var width = $("#flipbook").outerWidth();
    var height = width*0.35;
    $("#flipbook").turn({
        width: width,
        height: height,
        // acceleration: true,
        autoCenter: true,
        // elevation:50
    });
    $("#flipbook").on('click', '.even', function(){
        $("#flipbook").turn('previous');
    });
    $("#flipbook").on('click', '.odd', function(){
        $("#flipbook").turn('next');
    });
    $(window).bind('keydown', function(e){
            if (e.keyCode==37)
                $("#flipbook").turn('previous');
            else if (e.keyCode==39)
                $("#flipbook").turn('next');
    });
});