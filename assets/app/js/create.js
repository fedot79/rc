$(document).ready(function(){
    $card = $('#card0');
    var object_type = ($('#addressform-address_string').data('type')!='Objects')?'search':'object';

    var $slider = $('.object-slider');
    var slides = $('.slide');
    if($slider.length>0)
    {
        $slider.parent().addClass('slider-inside');
        $slider.slick({
            prevArrow: '<button type="button" class="slick-prev">Previous</button>',
            nextArrow: '<button type="button" class="slick-next">Next</button>',
            vertical:true
        });
        $slider.on('click', function(){
            $slider.slick('next');
        });
        $slider.on('beforeChange', function(e,click, cs, ns){
            ns = slides.eq(ns);
            $('#form_type').val(ns.data('id'))
        });
        if($('#form_type').val()!='')
        {
            var val = $('#form_type').val();
            if(val=='square')
                $('.object-slider').slick('slickGoTo', 0);
            if(val=='street')
                $('.object-slider').slick('slickGoTo', 1);
            if(val=='building')
                $('.object-slider').slick('slickGoTo', 2);
            if(val=='land')
                $('.object-slider').slick('slickGoTo', 3);

        }
    }
    $mapContainer = $('.map-container');
    var options ={};
    options.create_marker = false;
    window.marker = null;
    window.radius = null;
    options.defaultLatitude = 55.755814;
    options.defaultLongitude = 37.617635;
    options.search = (object_type=='search');
    if($mapContainer.length>0 && $mapContainer.data('lat')>0)
    {
        options.defaultLatitude = $mapContainer.data('lat')*1;
        options.defaultLongitude = $mapContainer.data('lng')*1;
        options.create_marker = true;
        // window.marker = new google.maps.Marker({
        //     position: {lat: options.defaultLatitude, lng: options.defaultLongitude},
        //     // map: window.map,
        // });
    }
    var myLatLng = {lat: options.defaultLatitude, lng: options.defaultLongitude};
    var miniOptions = {
        panControl: false,
        fullscreenControl: false,
        mapTypeControl: false,
        streetViewControl: false,
        disableDoubleClickZoom: true,
        draggable:false,
        gestureHandling: 'none',
    };
    var startOptions = Object.assign({
        scaleControl: false,
        disableDefaultUI: true,
        clickableIcons: false,
        styles: window.gmapstyle,
        center: myLatLng,
        zoom: 14,
        zoomControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }, miniOptions);
    var fullOptions = {
        panControl: true,
        disableDoubleClickZoom: false,
        draggable:true,
        gestureHandling: 'auto',
    };

    window.map = new google.maps.Map($('.map-container')[0], startOptions);
    google.maps.event.addListener(window.map, 'click', function(e) {
        geocodePosition(e.latLng);
    });

    $('.zoom-plus').on('click', function(){
        window.map.setZoom(window.map.getZoom()+1);
    });
    $('.zoom-minus').on('click', function(){
        window.map.setZoom(window.map.getZoom()-1);
    });
    $('.zoom').on('click', function(event){
        event.stopPropagation();
        if($('#card0').hasClass('zoom-map'))
        {
            window.map.setOptions(miniOptions);
        }
        else
        {
            window.map.setOptions(fullOptions);

        }
        $('#card0').toggleClass('zoom-map');
        $('.map-container').css('height', $('.card-map').outerHeight()+'px');

    });

    var autocomplete = new google.maps.places.Autocomplete($('#addressform-address_string').get(0), {types:['address'], componentRestrictions:{country:'ru'}});
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var place = autocomplete.getPlace();
        if (!place) {
            return;
        }
        fillAddressForm(place.address_components);
        selectLocation(place);
    });

    var geocodePosition = function(latLng, moveMarker=true) {
        // console.log('geocode', latLng, moveMarker);
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode(
            {
                latLng: latLng
            },
            function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if(results[0] && results[0].address_components.length>3)
                    {
                        fillAddressForm(results[0].address_components);
                    }
                    selectLocation(results[0], moveMarker);
                }
                return false;
            }
        );
    };

    var selectLocation = function(item, creatMarker = true) {
        if (!item.geometry) {
            return;
        }
        var bounds = item.geometry.viewport ? item.geometry.viewport : item.geometry.bounds;
        var center = null;
        if (bounds && !options.search) {
            window.map.fitBounds(new google.maps.LatLngBounds(bounds.getSouthWest(), bounds.getNorthEast()));
        }
        if (item.geometry.location) {
            center = item.geometry.location;
        }
        else if (bounds) {
            var lat = bounds.getSouthWest().lat() + ((bounds.getNorthEast().lat() - bounds.getSouthWest().lat()) / 2);
            var lng = bounds.getSouthWest().lng() + ((bounds.getNorthEast().lng() - bounds.getSouthWest().lng()) / 2);
            center = new google.maps.LatLng(lat, lng);
        }
        if (center) {
            window.map.setCenter(center);
            if(creatMarker)
            {
                if(options.search)
                {
                    createRadius(center);
                }
                else
                    createMarker(center);
            }
            setLatLngAttributes(center);
        }
    };

    // var bounds_timer;
    var changeBounds = function(radius) {
        bounds_timer = setTimeout(function(){
            var bounds = window.map.getBounds();
            // console.log('change bounds', bounds, window.radius.getBounds(), bounds.union(window.radius.getBounds()));
            if(bounds)
            {
                window.map.fitBounds(bounds.union(radius.getBounds()), {bottom:0, left:0, right:0, top:0});
            }
        }, 300);
    };

    var createMarker = function(latLng) {
        // remove older marker
        if (window.marker) {
            window.marker.remove();
        }
        window.marker = new google.maps.Marker({
            'position'          : latLng,
            'map'               : window.map,
            'draggable'         : options.draggable
        });

        google.maps.event.addListener(window.marker, 'dragend', function() {
            window.marker.changePosition(window.marker.getPosition());
        });

        window.marker.remove = function() {
            google.maps.event.clearInstanceListeners(this);
            this.setMap(null);
        };

        window.marker.changePosition = geocodePosition;
    };
    if(options.create_marker)
    {
        createMarker(myLatLng);
    }

    var createRadius = function(latLng) {
        // console.log('createRadius');
        // remove older marker
        if (window.radius) {
            window.radius.remove();
        }
        window.radius = new google.maps.Circle({
            strokeColor: '#0ea3b1',
            strokeOpacity: 0.9,
            strokeWeight: 1,
            fillColor: '#0ea3b1',
            fillOpacity: 0.4,
            map: window.map,
            center: latLng,
            radius: $('#form-distance').val()*1,
            draggable: true
        });

        google.maps.event.addListener(window.radius, 'dragend', function() {
            window.radius.changePosition(window.radius.getCenter(), false);
        });
        // }
        // console.log('createRadius');
        changeBounds(window.radius);

        $('#form-distance').on('change', //function(){
            // $(this).next().text(parseInt($(this).val()))
            setRadiusRadius
        //}
        );

        window.radius.remove = function() {
            google.maps.event.clearInstanceListeners(this);
            $('#form-distance').off('change', setRadiusRadius);
            this.setMap(null);
        };

        window.radius.changePosition = geocodePosition;
    };

    function setRadiusRadius(){
        $(this).next().text(parseInt($(this).val())*2+' м');
        window.radius.setRadius($(this).val()*1);
        // console.log('setRadiusRadius');
        changeBounds(window.radius);
    }

    var setLatLngAttributes = function(point) {
        $('#addressform-lat').val(point.lat());
        $('#addressform-lng').val(point.lng());
    };
    var fillAddressForm = function(address_components){
        $('.card-map.has-error').removeClass('has-error').find('.error-msg').remove();
        var street = house = region = city ='';
        var house = '';
        var region = '';
        var city = '';
        $('#addressform-house').val('');
        $('#addressform-street').val('');
        $('#addressform-city').val('');
        $('#addressform-region').val('');

        $.each(address_components, function(i,e){
            if(e.types.indexOf('street_number')>=0)
            {
                house = e.long_name;
                $('#addressform-house').val(house);
            }
            if(e.types.indexOf('route')>=0)
            {
                street = e.short_name;
                $('#addressform-street').val(street);
            }
            if(e.types.indexOf('locality')>=0)
            {
                city = e.long_name;
                $('#addressform-city').val(e.long_name);
            }
            if(e.types.indexOf('administrative_area_level_1')>=0 || e.types.indexOf('administrative_area_level_2')>=0)
            {
                region = e.long_name;
                $('#addressform-region').val(e.long_name);
            }

            if(region=='' && city !== '')
            {
                region = city;
                $('#addressform-region').val(city);
            }
        });
        $('#addressform-address_string').val(street+', '+house+', '+city+', '+region);
        $('#addressform-address_string').trigger('change');
    };

    var intonly = '#form_price_rent, #form_price_sell, #form_floor';
    if(object_type=='object')
    {
        intonly+=', #form_square';
    }

    $(intonly).on('input paste', function(){
        var val = $(this).val();
        // val = val.replace(',', '.');
        res = val.match(/-?\d*/g);
        if(res == null)
        {
            val = parseInt(val);
            if(typeof val !== "number" || isNaN(val) )
                val = '';
        }
        else
        {
            val = res[0];
        }
        $(this).val(val);
    });

    var floatonly = '#form_ceil,#form_column';
    $(floatonly).on('input paste', function(){
        var val = $(this).val();
        val = val.replace(',', '.');
        res = val.match(/\d+\.?\d*/g);
        if(res == null)
        {
            val = parseFloat(val);
            if(typeof val !== "number" || isNaN(val) )
                val = '';
        }
        else
        {
            val = res[0];
        }
        $(this).val(val);
    });


    function validate() {
        $card.find('.error-msg').remove();
        $card.find('.has-error').removeClass('has-error');
        var valid = true;
        if($('#form_square').val()=='')
        {
            addError($('#form_square'), 'Укажите площадь');
            valid = false;
        }
        if($('#form_floor').val()>50 || $('#form_floor').val()<-1)
        {
            addError($('#form_floor'), 'Не верный этаж');
            valid = false;
        }
        if($('#form_price_rent').val()=='' && $('#form_price_sell').val()=='')
        {
            if(object_type=='object')
            {
                addError($('#form_deal_rent'), 'Укажите стоимость сделки');
                valid = false;
            }
        }
        if($('#form_price_rent').val()>99999999)
        {
            addError($('#form_deal_rent'), 'Стоимость аренды не может быть больше 99 999 999р');
            valid = false;
        }
        if($('#form_price_sell').val()>9999999999)
        {
            addError($('#form_deal_rent'), 'Стоимость аренды не может быть больше 9 999 999 999р');
            valid = false;
        }
        if($('#form_deal_rent').val()!=1 && $('#form_deal_sell').val()!=1)
        {
            addError($('#form_deal_rent'), 'Укажите тип сделки');
            valid = false;
        }
        if($('#addressform-address_string').val()=='')
        {
            addError($('#addressform-address_string'), 'Укажите адрес');
        }
        if($('#addressform-city').val()=='')
        {
            addError($('#addressform-address_string'), 'Укажите город');
        }
        if($('#addressform-region').val()=='')
        {
            addError($('#addressform-address_string'), 'Укажите регион');
        }
        if($('#addressform-street').val()=='')
        {
            addError($('#addressform-address_string'), 'Укажите улицу');
        }
        if(object_type=='object' && $('#addressform-house').val()=='')
        {
            addError($('#addressform-address_string'), 'Укажите номер дома');
        }
        return valid;
    };
    $('#form_square, #addressform-address_string, #form_floor').on('input paste', function(){
        if($(this).next().hasClass('error-msg'))
        {
            $(this).next('.error-msg').remove();
            $(this).parent('.has-error').removeClass('has-error');
        }
    });

    $('#form_price_rent, #form_price_sell').on('input paste', function(){
        $(this).parents('.card-deal').removeClass('has-error');
        $(this).parents('.card-deal').find('.error-msg').remove();
    })

    $('#proceed').on('click', function(){
        if(validate())
        {
            var $form = $('#cardform');
            $form.attr('method', 'POST');
            var $inputs = $card.find('input').each(function(i,e){
                var clone = $(e).clone();
                $form.prepend(clone);
            });
            var data = $form.serialize();
            $form.submit();
        }
    })

    $('#card0').on('click', '.error-msg', function(){
        $(this).parent().removeClass('has-error');
        $(this).remove();
    })

    var deal_rent = parseInt($('#form_deal_rent').val());
    var deal_sell = parseInt($('#form_deal_sell').val());
    var price_rent = $('#form_price_rent').val();
    var price_sell = $('#form_price_sell').val();

    // console.log(deal_rent, deal_sell);
    $('.card-label').on('click', function(event){
        event.preventDefault();

        if($(this).find('#form_price_rent').length>0)
        {
            // console.log(deal_rent);
            deal_rent = +!deal_rent;
            // console.log(deal_rent);
            $('#form_deal_rent').val(deal_rent);
            $(this).toggleClass('no-choose');
            if(deal_rent==1)
                $('#form_price_rent').focus();
            if(deal_rent==0)
                $('#form_price_rent').val('');
        }
        if($(this).find('#form_price_sell').length>0)
        {
            deal_sell = +!deal_sell;
            $('#form_deal_sell').val(deal_rent);
            $(this).toggleClass('no-choose');
            if(deal_sell==1)
                $('#form_price_sell').focus();
            if(deal_sell==0)
                $('#form_price_sell').val('');
        }
        // console.log(deal_rent, deal_sell);
        return false;
    });

    $('#form_price_rent, #form_price_sell').on('blur', function(event){
        if(object_type=='object')
        {
            if($(this).val()<1)
            {
                $(this).parent().trigger('click');
            }
            else
            {
                if($(this).attr('id')=='form_deal_sell')
                {
                    deal_sell=1;
                    $('#form_deal_sell').val(1);
                }
                else
                {
                    deal_rent=1;
                    $('#form_deal_rent').val(1);
                }
            }
        }
        // console.log('label input blur');
    });
    $('#form_price_rent, #form_price_sell').on('click', function(event){
        event.stopPropagation();
        // console.log('label input focus');
        return false;
    });


    function addError($el, msg){
        console.log($el, msg);
        if($el.next().hasClass('error-msg')){
            var $er = $el.next();
            msg = $er.html()+'<br>'+msg;
            $er.html(msg);
        }
        else
        {
            var $er = $('<div/>').addClass('error-msg').text(msg);
            $el.after($er);
        }
        $er.parent().addClass('has-error');
    }

});