$(document).ready(function(){
    var ObjectType = $('#addressform-address_string').data('type');
    var object_type = (ObjectType!='Objects')?'search':'object';
    var $typeInput = $('[name="'+ObjectType+'[type]"]');
    var $squareInput = (object_type=='search')?$('[name="'+ObjectType+'[square_string]"]'):$('[name="'+ObjectType+'[square]"]');
    var $floorInput = $('[name="'+ObjectType+'[floor]"]');
    var $columnInput = $('[name="'+ObjectType+'[column]"]');
    var $ceilInput = $('[name="'+ObjectType+'[ceil]"]');
    var $dealRentInput = $('[name="'+ObjectType+'[deal_rent]"][type=checkbox]');
    var $dealSellInput = $('[name="'+ObjectType+'[deal_sell]"][type=checkbox]');
    var $priceRentInput = $('[name="'+ObjectType+'[price_rent]"]');
    var $priceSellInput = $('[name="'+ObjectType+'[price_sell]"]');
    var $gainPercentCheck = $('[name="'+ObjectType+'[gain_percent_check]"][type=checkbox]');
    var $gainPercentInput = $('[name="'+ObjectType+'[gain_percent]"]');
    var $card = $('#card0');
    var $cardDeals = $card.find('.card-label');
    var $dds = $card.find('.card-info dd');
    var $square = $dds.eq(0).add('.metrik.square');
    var $floor = $dds.eq(1).add('.metrik.floor');
    var $column = $dds.eq(2).add('.metrik.column');
    var $ceil = $dds.eq(3).add('.metrik.height');
    var $zone = $dds.eq(4).add('.metrik.shipping');
    var $entrance = $dds.eq(5).add('.metrik.entrance');
    var $zoneInput = $('[name="'+ObjectType+'[shipping_zone]"][type=radio]');
    var $entranceInput = $('[name="'+ObjectType+'[entrance]"][type=radio]');
    var $mapErrorInfo = $('.map-error');
    var $mapInfo = $('.map-info');
    var $search_siblings = $('#addressform-address_string').siblings();
    var $clear_icon = $search_siblings.filter('.clear-icon');
    var $search_icon = $search_siblings.filter('.search-icon');
    var search_radius=0;

    var gain_percent = 0;
    if($gainPercentInput.val()>0)
        gain_percent = $gainPercentInput.val();

    var priceRent = 0;
    if($priceRentInput.val()>0)
        priceRent = $priceRentInput.val();

    $mapInfo.on('click', function(){
        $(this).toggleClass('open');
    });

    $gainPercentInput.on('keyup change', function(){
        var val = $(this).val();
        if(val>0)
        {
            gain_percent = val;
            $gainPercentCheck.prop('checked', true);
            $dealRentInput.prop('checked', true);
        }
        if(val=='')
        {
            $gainPercentCheck.prop('checked', false);
            gain_percent = 0;
        }
        updateRentPrice();
    });
    $gainPercentCheck.on('change', function(){
        if($(this).prop('checked')==true)
        {
            $dealRentInput.prop('checked', true);
        }
        else
        {
            $gainPercentInput.val('');
            gain_percent = 0;
            updateRentPrice();
        }
    });

    function updateRentPrice()
    {
        $cardDeals.eq(0).removeClass('hidden').removeClass('no-choose').contents().filter(function(){
            return (this.nodeType == 3 && this.textContent.trim()!=='');
        }).each(function(){
            this.textContent = new Intl.NumberFormat('ru-RU').format(priceRent)+' ₽/мес'+(gain_percent>0?('+'+gain_percent+'%'):'');
        });
    }



    $typeInput.on('change', function(){
        var imgs = {'square':'/img/ttse.png', 'street':'/img/separate.svg', 'building':'/img/separate1.svg', 'land':'/img/stead1.svg'};
        var names = {'square':'Площадь в ТЦ', 'street':'Стрит-ритейл', 'building':'Отдельнoе здание', 'land':'Участок'};
        var val = $(this).val();
        // console.log($(this).val());
        console.log($card.find('.card-type').contents().filter(function() {
            return (this.nodeType == 3 && this.textContent.trim()!=='')
        }).each(function(){
            console.log(this);
            this.textContent = names[val];
        }).parent().find('img').attr('src', imgs[val])
        );
        // $card.find('img').attr('src', imgs[val])
    });

    $squareInput.on('keyup change', function(){
        var val = $(this).val();
        $square.text((val!=0 && val!='')?(val+' м²'):'—');
        if(val.indexOf('-')>0)
        {
            val = val.split('-');
            val = (val[0]*1+val[1]*1)/2
        }
        var price = Math.round(getCoeff(val)*100)/100;
        $('#contact_price').text('С вами свяжутся за '+price+' ₽');
        $('#contact_price').parent().removeClass('no-buttons').addClass('price');

    });
    if($squareInput.val()!=='')
    {
        $squareInput.trigger('change');
    }
    $floorInput.on('keyup change', function(){
        var val = $(this).val();
        $floor.text((val!=0 && val!='')?(val):'—');
    });
    if($floorInput.val()!=='')
        $floorInput.trigger('change');
    $columnInput.on('keyup change', function(){
        var val = $(this).val();
        $column.text((val!=0 && val!='')?(val+' м'):'—');
    });
    if($columnInput.val()!=='')
        $columnInput.trigger('change');
    $ceilInput.on('keyup change', function(){
        var val = $(this).val();
        $ceil.text((val!=0 && val!='')?(val+' м'):'—');
    });
    if($ceilInput.val()!=='')
        $ceilInput.trigger('change');

    $dealRentInput.on('change', function(){
        // console.log('change');
        if($(this).prop('checked')==true)
        {
            updateRentPrice();
            clearError($dealRentInput.parent());
            clearError($dealSellInput.parent());
        }
        else
        {
            $cardDeals.eq(0).addClass('hidden').addClass('no-choose');
        }
    });

    $priceRentInput.on('keyup change', function(){
        var val = $(this).val();
        priceRent = val;
        updateRentPrice();
        if(val>0)
        {
            $dealRentInput.prop('checked', true)
        }
    });

    $dealSellInput.on('change', function(){
        // console.log('change');
        if($(this).prop('checked')==true)
        {
            $cardDeals.eq(1).removeClass('hidden').removeClass('no-choose').contents().filter(function(){
                return (this.nodeType == 3 && this.textContent.trim()!=='');
            }).each(function(){
                this.textContent = '0 ₽';
            });
            clearError($dealRentInput.parent());
            clearError($dealSellInput.parent());
        }
        else
        {
            $cardDeals.eq(1).addClass('hidden').addClass('no-choose');
        }
    });

    $priceSellInput.on('keyup change', function(){
        var val = $(this).val();
        $cardDeals.eq(1).removeClass('hidden').removeClass('no-choose').contents().filter(function(){
            return (this.nodeType == 3 && this.textContent.trim()!=='');
        }).each(function(){
            this.textContent = new Intl.NumberFormat('ru-RU').format(val)+' ₽';
        });
        if(val>0)
        {
            $dealSellInput.prop('checked', true)
        }
    });

    $zoneInput.on('change', function(){
        $zone.html('');
        if($(this).val()==-1)
        {
            $zone.html('<span class="par-no"><svg class="not"><use xlink:href="/img/cross-remove-sign-g.svg#cross-remove-sign-g.svg"></svg></span>');
            return false;
        }
        if($(this).val()==1)
        {
            $zone.html('<span class="par-yes"><svg class="ok"><use xlink:href="/img/correct-symbol-g.svg#correct-symbol-g.svg"></svg></span>');
            return false;
        }
        if($(this).val()==0)
        {
            $zone.text('—');
            return false;
        }
    });
    if($zoneInput.filter(':checked').length > 0)
        $zoneInput.filter(':checked').trigger('change');

    $entranceInput.on('change', function(){
        $entrance.html('');
        if($(this).val()==-1)
        {
            $entrance.html('<span class="par-no"><svg class="not"><use xlink:href="/img/cross-remove-sign-g.svg#cross-remove-sign-g.svg"></svg></span>');
            return false;
        }
        if($(this).val()==1)
        {
            $entrance.html('<span class="par-yes"><svg class="ok"><use xlink:href="/img/correct-symbol-g.svg#correct-symbol-g.svg"></svg></span>');
            return false;
        }
        if($(this).val()==0)
        {
            $entrance.text('—');
            return false;
        }
    });

    if($entranceInput.filter(':checked').length>0)
        $entranceInput.filter(':checked').trigger('change');



    $mapContainer = $('.map-container');
    var options ={};
    options.create_marker = false;
    options.manual_geo = false;
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
        // options.manual_geo = true;
        // console.log(options);
        // window.marker = new google.maps.Marker({
        //     position: {lat: options.defaultLatitude, lng: options.defaultLongitude},
        //     // map: window.map,
        // });
    }

    if($('#addressform-address_string').val().length>0)
    {
        options.manual_geo = true;
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

    if($('body').hasClass('mobile'))
    {
        fullOptions.gestureHandling = 'greedy';
    }

    window.map = new google.maps.Map($('.map-container')[0], startOptions);
    // var transitLayer = new google.maps.TransitLayer();
    // transitLayer.setMap(window.map);
    google.maps.event.addListener(window.map, 'click', function(e) {
        options.manual_geo = true;
        geocodePosition(e.latLng);
    });

    $('.zoom-plus').on('click', function(){
        window.map.setZoom(window.map.getZoom()+1);
    });
    $('.zoom-minus').on('click', function(){
        window.map.setZoom(window.map.getZoom()-1);
    });
    $('.zoom, #openMap').on('click', function(event){
        event.stopPropagation();
        clearError($('.card-map'));
        openMap();
    });
    $('.zoom-down').add('svg.close-map').on('click', function(){
        event.stopPropagation();
        window.map.setOptions(miniOptions);
        $('#card0').removeClass('zoom-map');
        $('.map-container').css('height', $('.card-map').outerHeight()+'px');
        $mapErrorInfo.addClass('hidden');
    });

    $('.map-error .close').on('click', function(){
        $mapErrorInfo.addClass('hidden');
    });

    function closeMapHandler() {
        $('body, .card-spine, .mobile-close-map').one('click', function(event){
            // console.log('blody click');
            $('#card0').removeClass('zoom-map');
            $('.map-container').css('height', $('.card-map').outerHeight()+'px');
            $mapErrorInfo.addClass('hidden');
            $('#mobile-menu').removeClass('hidden');
        });
    }
    $('#card0').on('click', function (event) {
        // console.log('card click');
        event.stopPropagation();
    });

    function openMap()
    {
        window.map.setOptions(fullOptions);
        $('#card0').addClass('zoom-map');
        $('#mobile-menu').addClass('hidden');
        if($(document).outerWidth()<666)
        {
            $('#card0').addClass('show-wipe');
        }
        $('.map-container').css('height', $('.card-map').outerHeight()+'px');
        closeMapHandler();
    }


    $('#addressform-address_string').on('focus', function(){
        $mapErrorInfo.addClass('hidden');
    });


    $clear_icon.on('click', function(){
        $('#addressform-address_string').val('');
        $clear_icon.addClass('hidden');
        $search_icon.removeClass('hidden');
    })
    $('#addressform-address_string').on('keyup', function(){
        if($(this).val()!='')
        {
            $search_icon.addClass('hidden');
            $clear_icon.removeClass('hidden');
        }
        else
        {
            $clear_icon.addClass('hidden');
            $search_icon.removeClass('hidden');
        }
    });
    var autocomplete = new google.maps.places.Autocomplete($('#addressform-address_string').get(0), {
        // types:['geocode'],
        componentRestrictions:{country:'ru'}
    });

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        options.manual_geo = false;
        // console.log(autocomplete);
        var place = autocomplete.getPlace();
        var regex = /\d{2}\.\d{2,10}(\s|),(\s|)\d{2,3}\.\d{2,10}/gm;
        if(place.name && place.name.match(regex))
        {
            var geo = place.name.split(',').map(function(e){return parseFloat(e.trim())});
            if(geo.length==2)
            {
                options.manual_geo = true;
                var place = {lat: geo[0], lng: geo[1]};
                // console.log('place', place);
                geocodePosition(place);
                return false;
            }
        }
        if (!place) {
            return;
        }
        fillAddressForm(place.address_components);
        selectLocation(place);
    });

    var geocodePosition = function(latLng, moveMarker) {
        if(typeof moveMarker == 'undefined')
            moveMarker = true;
        // console.log('geocode', latLng, moveMarker);
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode(
            {
                latLng: latLng
            },
            function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    // console.log(results[0]);
                    if(results[0] && results[0].address_components.length>1)
                    {
                        fillAddressForm(results[0].address_components);
                    }
                    selectLocation(results[0], moveMarker);
                }
                return false;
            }
        );
    };

    var selectLocation = function(item, creatMarker) {
        if(typeof creatMarker == 'undefined')
            creatMarker = true;
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

    var bounds_timer;
    var changeBounds = function(radius) {
        if(radius.getRadius()<=300)
            window.map.setZoom(16)
        if(radius.getRadius()<=1000 && radius.getRadius()>300)
            window.map.setZoom(14)
        if(radius.getRadius()>1000 && radius.getRadius()<=2000)
            window.map.setZoom(13)
        if(radius.getRadius()>2000 && radius.getRadius()<=5000)
            window.map.setZoom(12)
        if(radius.getRadius()>5000)
            window.map.setZoom(11)
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

    var createRadius = function(latLng) {
        search_radius = $('#form-distance').val()*1;
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
            radius: search_radius,
            draggable: true
        });

        google.maps.event.addListener(window.radius, 'dragend', function() {
            window.radius.changePosition(window.radius.getCenter(), false);
        });
        // }
        // console.log('createRadius');
        changeBounds(window.radius);

        $('#form-distance, #form_distance_text').on('change', function() {
            search_radius = Math.round($(this).val()*1);
            setRadiusRadius();
        });

        window.radius.remove = function() {
            google.maps.event.clearInstanceListeners(this);
            $('#form-distance').off('change', setRadiusRadius);
            this.setMap(null);
        };

        window.radius.changePosition = geocodePosition;
    };

    if(object_type=='search')
        createRadius(myLatLng);
    else
        createMarker(myLatLng);

    function setRadiusRadius(){
        $('#form-distance').simpleSlider("setValue", search_radius);
        $('#form_distance_text').val(search_radius);
        window.radius.setRadius(search_radius);
        $('#search-distance').val(search_radius);

        changeBounds(window.radius);
    }

    var setLatLngAttributes = function(point) {
        $('#addressform-lat').val(point.lat());
        $('[name="AddressForm[lat]"]').val(point.lat());
        $('#addressform-lng').val(point.lng());
        $('[name="AddressForm[lng]"]').val(point.lng());
    };
    var fillAddressForm = function(address_components){
        $('.card-map.has-error').removeClass('has-error').find('.error-msg').remove();
        var street = house = region = city ='';
        var house = '';
        var region = '';
        var city = '';
        var out = [];
        clearAddressForm();

        $.each(address_components, function(i,e){
            if(e.types.indexOf('street_number')>=0)
            {
                house = e.long_name;
                $('#addressform-house').val(house);
                $('[name="AddressForm[house]"]').val(house);
            }
            if(e.types.indexOf('route')>=0)
            {
                street = e.short_name;
                $('#addressform-street').val(street);
                $('[name="AddressForm[street]"]').val(street);
            }
            if(e.types.indexOf('locality')>=0)
            {
                city = e.long_name;
                $('#addressform-city').val(e.long_name);
                $('[name="AddressForm[city]"]').val(city);
            }
            if(e.types.indexOf('administrative_area_level_1')>=0 || e.types.indexOf('administrative_area_level_2')>=0)
            {
                region = e.long_name;
                $('#addressform-region').val(e.long_name);
                $('[name="AddressForm[region]"]').val(region);
            }

            if(region=='' && city !== '')
            {
                region = city;
                $('#addressform-region').val(city);
                $('[name="AddressForm[region]"]').val(city);
            }
        });
        if(region!='')
            out.push(region);
        if(city!='')
            out.push(city);
        if(street!='')
            out.push(street);
        if(house!='')
            out.push(house);
        out = out.join(', ');

        if(out=='')
            showMapError();

        $('#addressform-address_string').val(out);
        $clear_icon.removeClass('hidden');
        $search_icon.addClass('hidden');

        $('[name="AddressForm[address_string]"]').val(out);

        $('#addressform-address_string').trigger('change');
        $('.map-address').removeClass('hidden').text(out);

    };
    function clearAddressForm()
    {
        $('#addressform-house').val('');
        $('#addressform-street').val('');
        $('#addressform-city').val('');
        $('#addressform-region').val('');
        $('[name="AddressForm[house]"]').val('');
        $('[name="AddressForm[street]"]').val('');
        $('[name="AddressForm[city]"]').val('');
        $('[name="AddressForm[region]"]').val('');
        $('#addressform-address_string').val('');
        $('[name="AddressForm[address_string]"]').val('');
    }
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    var intonly = '.intonly';

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
        clearError($(this).parent());
    });

    $('.positive').on('input paste', function(){
        var val = $(this).val();
        // val = val.replace(',', '.');
        res = val.match(/\d*/g);
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
        clearError($(this).parent());
    });

    var dashed = '.dashed';
    $(dashed).on('input paste', function(){
        var val = $(this).val();
        // val = val.replace(',', '.');
        res = val.match(/^\d+-?\d*$/g);
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
        clearError($(this).parent());
    });

    var floatonly = '.floatonly';
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
        clearError($(this).parent());
    });

    function validate() {
        console.log('validate', options.manual_geo);
        $card.find('.error-msg').remove();
        $card.find('.ierror').removeClass('ierror');
        var valid = true;
        if($squareInput.val()=='')
        {
            addError($squareInput, 'Укажите площадь');
            valid = false;
        }
        if($floorInput.val()>50 || $floorInput.val()<-1 || parseInt($floorInput.val())===0)
        {
            addError($floorInput, 'Не верный этаж');
            valid = false;
        }
        if($dealSellInput.prop('checked')==false && $dealRentInput.prop('checked')==false)
        {
            addError($dealRentInput, 'Укажите тип сделки');
            addError($dealSellInput, '');
            valid = false;
        }

        if($gainPercentInput.val()>100)
        {
            addError($gainPercentInput, 'Процент не может быть больше 100');
            valid = false;
        }

        if($gainPercentInput.val()>0)
        {
            if($priceRentInput.val()=='')
            {
                addError($gainPercentInput, 'Укажите стоимость аренды');
                valid = false;
            }
        }

        if($gainPercentCheck.prop('checked')==true)
        {
            if($gainPercentInput.val()=='' || $gainPercentInput.val()<0)
            {
                addError($gainPercentInput, 'Укажите процент');
                valid = false;
            }
            if($priceRentInput.val()=='')
            {
                addError($gainPercentInput, 'Укажите стоимость аренды');
                valid = false;
            }
        }

        if($priceRentInput.val()>99999999)
        {
            addError($priceSellInput, 'Стоимость аренды не может быть больше 99 999 999р');
            valid = false;
        }
        if($priceSellInput.val()>9999999999)
        {
            addError($priceSellInput, 'Стоимость объекта не может быть больше 9 999 999 999р');
            valid = false;
        }
        if($('#addressform-address_string').val()=='' && !options.manual_geo)
        {
            // addError($('#addressform-address_string'), 'Укажите адрес');
            // console.log($('#addressform-address_string').val(), options.manual_geo);
            showMapError();
            valid = false;
        }
        if($('#addressform-city').val()=='' && !options.manual_geo)
        {
            // addError($('#addressform-address_string'), 'Укажите город');
            // console.log($('#addressform-city').val(), options.manual_geo);
            showMapError();
            valid = false;
        }
        if($('#addressform-region').val()=='' && !options.manual_geo)
        {
            // addError($('#addressform-address_string'), 'Укажите регион');
            // console.log($('#addressform-region').val(), options.manual_geo);
            showMapError();
            valid = false;
        }
        // if($('#addressform-street').val()=='' && object_type=='object' && !options.manual_geo)
        if((object_type=='object') && ($('#addressform-street').val()=='' && !options.manual_geo))
        {
            // addError($('#addressform-address_string'), 'Укажите улицу');
            // console.log($('#addressform-street').val(), options.manual_geo);
            showMapError();
            valid = false;
        }
        // if(object_type=='object' && $('#addressform-house').val()=='' && !options.manual_geo)
        // if(object_type=='object' && !options.manual_geo)
        // {
        //     // addError($('#addressform-address_string'), 'Укажите номер дома');
        //     console.log($('#addressform-address_string').val(), options.manual_geo);
        //     showMapError();
        //     valid = false;
        // }


        // console.log(valid);
        return valid;
    };

    function showMapError(){

        openMap();
        $mapErrorInfo.removeClass('hidden');
    }

    function hideMapError(){
        $mapErrorInfo.addClass('hidden');
    }


    function addError($el, msg){
        console.log('err', $el, msg);
        if(msg!=='')
        {
            if($el.prev().hasClass('error-msg')){
                var $er = $el.prev();
                if($er.html().search(msg)<0)
                {
                    msg = $er.html()+'<br>'+msg;
                    $er.html(msg);
                }
            }
            else
            {
                var $er = $('<div/>').addClass('error-msg').text(msg);
                $el.before($er);
            }
        }
        $el.parent().addClass('ierror');
    }

    function clearError($elem){
        // console.log($elem);
        $elem.removeClass('ierror');
        $elem.find('.error-msg').remove();
    }

    $('#proceed').on('click', function(event){
        event.stopPropagation();
        if(validate())
        {
            var $form = $('#card-form');
            // console.log($form.serialize());
            // $form.attr('method', 'POST');
            // var $inputs = $card.find('input').each(function(i,e){
            //     var clone = $(e).clone();
            //     $form.prepend(clone);
            // });
            // var data = $form.serialize();
            $form.submit();
        }
    });

    $('#card-visibility').on('change', function(){
        if($(this).prop('checked'))
            $('[name="'+ObjectType+'[status]"]').val(0);
        else
            $('[name="'+ObjectType+'[status]"]').val(-1);
    });


    function getCoeff(square)
    {
        if(square<=200)
            return 300;
        if(square<=400)
            return square*1.5;
        if(square<=500)
            return square*1.1;
        if(square<=600)
            return square*0.9;
        if(square<=700)
            return square*0.8;
        if(square<=800)
            return square*0.7;
        if(square<=900)
            return square*0.6;
        if(square<=1100)
            return square*0.5;
        if(square<=1400)
            return square*0.4;
        if(square<=4000)
            return square*0.3;
        if(square>4000)
            return square*0.2;
    }

    function resize(){
        setTimeout(
            function(){
                if($('body').hasClass('mobile'))
                {
                    $('#proceed').insertAfter('#card0');
                }
                else
                {
                    $('#proceed').appendTo('#card-form');
                }
            }
        )
    }
    $(window).on('resize', resize);
    resize();

});
