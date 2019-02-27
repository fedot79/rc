(function($) {
    $.fn.cardMap = function(options) {
        var self = this;
        // var self.map;
        console.log(self);
        var myLatLng = {lat: 55.755814, lng: 37.617635};
        var id = $(self).attr('id').replace('card', '')*1;
        var color = '#434a53';
        self.selection = $('#container').hasClass('selection-main');
        mapContainer = self.find('.map-container');
        if(mapContainer.length>0)
        {
            if(mapContainer.data('lat')>0)
                myLatLng = {lat: mapContainer.data('lat'), lng: mapContainer.data('lng')};
        }
        console.log(myLatLng);
        if(self.data('color') && self.data('color')!=='')
            color = self.data('color');
        console.log(color);

        var miniOptions = {
            panControl: false,
            fullscreenControl: false,
            mapTypeControl: false,
            streetViewControl: false,
            disableDoubleClickZoom: true,
            draggable:false,
            gestureHandling: 'none'
        };
        var startOptions = Object.assign({
            scaleControl: false,
            disableDefaultUI: true,
            clickableIcons: false,
            styles: window.gmapstyle ,
            center: myLatLng,
            zoom: 14,
            zoomControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }, miniOptions);
        var fullOptions = {
            panControl: true,
            disableDoubleClickZoom: false,
            draggable:true,
            gestureHandling: 'auto'
        };
        self.map = new google.maps.Map(mapContainer[0], startOptions);
        if(mapContainer.data('radius'))
        {
            var circle = new google.maps.Circle({
                strokeColor: color,
                strokeOpacity: 0.9,
                strokeWeight: 1,
                fillColor: color,
                fillOpacity: 0.4,
                map: self.map,
                center: myLatLng,
                radius: mapContainer.data('radius')
            });
        }
        else
        {
            var marker = new google.maps.Marker({
                position : myLatLng,
                map : self.map
            });
        }

        // self.map.





        self.find('.zoom-plus').on('click', function(){
            self.map.setZoom(self.map.getZoom()+1);
        });
        self.find('.zoom-minus').on('click', function(){
            self.map.setZoom(self.map.getZoom()-1);
        });

        self.closeMap = function(){
            self.removeClass('zoom-map');
            $('.slider-track').removeClass('zoom-inside');
            mapContainer.css('height', mapContainer.parent().outerHeight()+'px');
        };

        self.find('.mobile-close-map').on('click', function(){
            self.closeMap();
        });

        var closeMapHandler = function() {
            console.log('set closeMapHandler');
            $('body').one('click', function(event){
                console.log($(event.target));
                if($(event.target)==self || self.has($(event.target)).length)
                {
                    closeMapHandler();
                    return false;
                }
                console.log('blody click');
                self.closeMap();
            });


        };

        self.find('.card-actions').on('click', function(event){
            event.stopPropagation();
        })

        if(self.data('type')=='search')
        {
            google.maps.event.addListenerOnce(self.map, 'idle', function(){
                console.log('idle', $(self).attr('id'));
                var bounds = self.map.getBounds();
                // console.log('bounds map',bounds);
                // console.log('bounds circle',circle.getBounds());

                bounds.union(circle.getBounds());
                self.map.fitBounds(bounds, {'bottom':0, 'left':0, 'right':0,'top':0});
            });
        }

        self.find('.zoom, #openMap').on('click', function(event){
            event.stopPropagation();
            if(self.selection && !self.hasClass('active')) //prevent click on open map on selection screen
                return false;
            self.map.setOptions(fullOptions);
            self.addClass('zoom-map');
            $('.slider-track').addClass('zoom-inside');
            console.log(mapContainer, $(mapContainer), mapContainer.parent().outerHeight());
            // mapContainer.css('height', mapContainer.parent().outerHeight()+'px');
            // mapContainer.css('opacity', '0.1');
            // $(mapContainer).remove();
            closeMapHandler();
        });
        self.find('.zoom-down').add('svg.close-map').on('click', function(event){
            event.stopPropagation();
            console.log('zoomdown svg');
            self.removeClass('zoom-map');
            mapContainer.css('height', mapContainer.parent().outerHeight()+'px');
        });
        self.data('map', self.map);
        self.data('circle', circle);

        if($('#container').hasClass('open_contact') && self.next().hasClass('card-contacts'))
        {
            $contCard = $(self).next();
            console.log($contCard);
            var $spine = $(self).find('.card-spine').clone();
            $spine.find('.close-map').attr('class', 'close-cont');
            console.log($spine);
            $contCard.prepend($spine);

            self.find('.card-actions').find('.show-contact').on('click', function(event){
                $('#container').addClass('show_contact').removeClass('hide_contact');
                closeContactHandler();
            });
            var closeContactHandler = function() {
                console.log('set closeContactHandler');
                $contCard.on('click', function(event){
                    event.stopPropagation();
                })
                $('body').one('click', function(event){
                    console.log($(event.target));
                    if($(event.target)==self || self.has($(event.target)).length)
                    {
                        closeContactHandler();
                        return false;
                    }
                    $('#container').removeClass('show_contact').addClass('hide_contact');
                });
                $contCard.find('.close-cont').one('click', function(){
                    $('#container').removeClass('show_contact').addClass('hide_contact');
                })
            };
        }
    };

    $.fn.cardCityMap = function(options){
        console.log('cardCityMap');
        var self = this;
        // if($('#container').hasClass('open_contact') && self.next().hasClass('card-contacts'))
        // {
            $contCard = $(self).next();
            // console.log($contCard);
            var $spine = $(self).find('.card-spine').clone();
            $spine.find('.close-map').attr('class', 'close-cont');
            console.log($spine);
            $contCard.prepend($spine);

            self.find('.card-actions').find('.show-contact').on('click', function(event){
                $('.open_contact').addClass('show_contact').removeClass('hide_contact');
                closeContactHandler();
            });
            var closeContactHandler = function() {
                console.log('set closeContactHandler');
                $contCard.on('click', function(event){
                    event.stopPropagation();
                })
                $('body').one('click', function(event){
                    console.log($(event.target));
                    if($(event.target)==self || self.has($(event.target)).length)
                    {
                        closeContactHandler();
                        return false;
                    }
                    $('.open_contact').removeClass('show_contact').addClass('hide_contact');
                });
                $contCard.find('.close-cont').one('click', function(){
                    $('.open_contact').removeClass('show_contact').addClass('hide_contact');
                })
            };
        // }
    }


    // if('selections' in window)
    // {
    //     console.log('run selections');
    //     var selections = window.selections;
    //     console.log(selections);
    //     var count = selections.length;
    //     for (var i=0; i<10 && i<count; i++)
    //     {
    //         // $('.card-new[data-id="'+selections[i]+'"]').eq(0).cardMap();
    //         console.log('.card-new[data-id="'+selections[i]+'"]');
    //     }
    // }
    // else
    // {
    //     console.log('no selections');
    // }

})(jQuery);