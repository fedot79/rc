$(function() {


    //slider
    if(jQuery('.problems__slider').length) {

        $('.problems__slider').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: true,
            // prevArrow: '<i class="fa fa-angle-left feedback-slider-arrows arrow-left_mob"></i>',
            prevArrow: '<svg class="svg-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M238.475 475.535l7.071-7.07c4.686-4.686 4.686-12.284 0-16.971L50.053 256 245.546 60.506c4.686-4.686 4.686-12.284 0-16.971l-7.071-7.07c-4.686-4.686-12.284-4.686-16.97 0L10.454 247.515c-4.686 4.686-4.686 12.284 0 16.971l211.051 211.05c4.686 4.686 12.284 4.686 16.97-.001z"></path></svg>',
            // nextArrow: '<i class="fa fa-angle-right feedback-slider-arrows arrow-right_mob"></i>',
            nextArrow: '<svg class="svg-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z"></path></svg>',
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 1920,
                    settings: {
                        slidesToShow: 2
                    }
                }
            ]
        });
    }

    //go_to
    if(jQuery('.go_to').length) {
        $('.go_to').click( function(){ // ловим клик по ссылке с классом go_to
            var scroll_el = $(this).attr('href'); // возьмем содержимое атрибута href, должен быть селектором, т.е. например начинаться с # или .
            if ($(scroll_el).length != 0) { // проверим существование элемента чтобы избежать ошибки
                $('html, body').animate({ scrollTop: $(scroll_el).offset().top }, 500); // анимируем скроолинг к элементу scroll_el
            }
            return false; // выключаем стандартное действие
        });

    }

    var typed = new Typed(".typed", {'strings':["простым", "быстрым", "эффективным", "доступным"], 'typeSpeed':60, 'loop':true, backDelay:2500, backSpeed:30, cursorChar:'', startDelay: 500});


});