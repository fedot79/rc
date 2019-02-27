/**
 * Select map location widget.
 * The widget writes the coordinates to hidden inputs when enter address into text input or move marker on the map.
 *
 * @see https://developers.google.com/maps/documentation/javascript/tutorial
 *
 * @param {Object}  options
 * @param {boolean} options.draggable Marker draggable Option
 * @param {Number} options.defaultLatitude Default latitude
 * @param {Number} options.defaultLongitude Default longitude
 * @param {String|jQuery|HTMLInputElement} options.address Address input selector
 * @param {String|jQuery|HTMLInputElement} options.latitude Latitude input selector
 * @param {String|jQuery|HTMLInputElement} options.latitude Longitude input selector
 * @param {Boolean} options.hideMarker Hide\show marker to selected location
 * @param {Function|undefined} options.onLoadMap Callback function to render map
 * @param {String|undefined} options.addressNotFound Description for not found address error
 */
(function($) {
    $.fn.selectLocation = function(options) {
        var self = this;
        var map;

        $(document).ready(function() {
            // if(localStorage.getItem('client_geo_lat'))
            // {
            //     options.defaultLatitude = localStorage.getItem('client_geo_lat');
            //     options.defaultLongitude = localStorage.getItem('client_geo_lng');
            // }
            // else
            // {
            //     $.get('https://ipapi.co/json/', function(data){
            //         if(typeof data == 'object')
            //         {
            //             if(typeof map == 'object')
            //             {
            //                 map.setCenter(new google.maps.LatLng(data.latitude, data.longitude))
            //             }
            //             else
            //             {
            //                 options.defaultLatitude = data.latitude;
            //                 options.defaultLongitude = data.longitude;
            //             }
            //             localStorage.setItem('client_geo_lat', data.latitude);
            //             localStorage.setItem('client_geo_lng', data.longitude);
            //         }
            //     });
            // }
            options.defaultLatitude = 55.755814;
            options.defaultLongitude = 37.617635;

            // if(typeof window.geoplugin_latitude == 'function')
            // {
            //     options.defaultLatitude = window.geoplugin_latitude();
            //     options.defaultLongitude = window.geoplugin_longitude();
            // }
            // var style = [
            //     {
            //         "elementType": "geometry",
            //         "stylers": [
            //             {
            //                 "color": "#f5f5f5"
            //             }
            //         ]
            //     },
            //     {
            //         "elementType": "labels.icon",
            //         "stylers": [
            //             {
            //                 "visibility": "off"
            //             }
            //         ]
            //     },
            //     {
            //         "elementType": "labels.text.fill",
            //         "stylers": [
            //             {
            //                 "color": "#616161"
            //             }
            //         ]
            //     },
            //     {
            //         "elementType": "labels.text.stroke",
            //         "stylers": [
            //             {
            //                 "color": "#f5f5f5"
            //             }
            //         ]
            //     },
            //     {
            //         "featureType": "administrative.land_parcel",
            //         "elementType": "labels.text.fill",
            //         "stylers": [
            //             {
            //                 "color": "#bdbdbd"
            //             }
            //         ]
            //     },
            //     {
            //         "featureType": "poi",
            //         "elementType": "geometry",
            //         "stylers": [
            //             {
            //                 "color": "#eeeeee"
            //             }
            //         ]
            //     },
            //     {
            //         "featureType": "poi",
            //         "elementType": "labels.text.fill",
            //         "stylers": [
            //             {
            //                 "color": "#757575"
            //             }
            //         ]
            //     },
            //     {
            //         "featureType": "poi.park",
            //         "elementType": "geometry",
            //         "stylers": [
            //             {
            //                 "color": "#e5e5e5"
            //             }
            //         ]
            //     },
            //     {
            //         "featureType": "poi.park",
            //         "elementType": "labels.text.fill",
            //         "stylers": [
            //             {
            //                 "color": "#9e9e9e"
            //             }
            //         ]
            //     },
            //     {
            //         "featureType": "road",
            //         "elementType": "geometry",
            //         "stylers": [
            //             {
            //                 "color": "#ffffff"
            //             }
            //         ]
            //     },
            //     {
            //         "featureType": "road.arterial",
            //         "elementType": "labels.text.fill",
            //         "stylers": [
            //             {
            //                 "color": "#757575"
            //             }
            //         ]
            //     },
            //     {
            //         "featureType": "road.highway",
            //         "elementType": "geometry",
            //         "stylers": [
            //             {
            //                 "color": "#dadada"
            //             }
            //         ]
            //     },
            //     {
            //         "featureType": "road.highway",
            //         "elementType": "labels.text.fill",
            //         "stylers": [
            //             {
            //                 "color": "#616161"
            //             }
            //         ]
            //     },
            //     {
            //         "featureType": "road.local",
            //         "elementType": "labels.text.fill",
            //         "stylers": [
            //             {
            //                 "color": "#9e9e9e"
            //             }
            //         ]
            //     },
            //     {
            //         "featureType": "transit.line",
            //         "elementType": "geometry",
            //         "stylers": [
            //             {
            //                 "color": "#e5e5e5"
            //             }
            //         ]
            //     },
            //     {
            //         "featureType": "transit.station",
            //         "elementType": "geometry",
            //         "stylers": [
            //             {
            //                 "color": "#eeeeee"
            //             }
            //         ]
            //     },
            //     {
            //         "featureType": "water",
            //         "elementType": "geometry",
            //         "stylers": [
            //             {
            //                 "color": "#c9c9c9"
            //             }
            //         ]
            //     },
            //     {
            //         "featureType": "water",
            //         "elementType": "geometry.fill",
            //         "stylers": [
            //             {
            //                 "color": "#0ea3b1"
            //             },
            //             {
            //                 "saturation": -80
            //             },
            //             {
            //                 "lightness": 70
            //             }
            //         ]
            //     },
            //     {
            //         "featureType": "water",
            //         "elementType": "labels.text.fill",
            //         "stylers": [
            //             {
            //                 "color": "#9e9e9e"
            //             }
            //         ]
            //     }
            // ];
            var mapOptions = {
                center: new google.maps.LatLng(options.defaultLatitude || 55.755814, options.defaultLongitude || 37.617635),
                zoom: 12,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                panControl: true,
                fullscreenControl: false,
                mapTypeControl: false,
                streetViewControl: false,
                // styles: style,
                zoomControlOptions:{
                    position: google.maps.ControlPosition.RIGHT_BOTTOM
                }
            };

            map = new google.maps.Map($(self).get(0), mapOptions);

            if (options.onLoadMap) {
                options.onLoadMap(map);
            }

            // marker for founded point
            var marker = null;
            var radius = null;

            // create marker when map clicked
            if (options.draggable) {
                google.maps.event.addListener(map, 'click', function(e) {
                    geocodePosition(e.latLng);

                    if(options.search)
                    {
                        createRadius(e.latLng)
                    }
                    else
                    {
                        createMarker(e.latLng);
                    }
                });
            }


            /**
             * Geocode position by selected latitude and longitude
             *
             * @param {Object} latLng google.maps.LatLng
             */
            var geocodePosition = function(latLng) {
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



                            // if (results[0].formatted_address) {
                            //     // revert geocode
                            //
                            //     $(options.address).val(street+', '+city+', '+region);
                            //     // $(options.address).val(results[0].formatted_address);
                            //     $(options.address).trigger('change');
                            // }
                            selectLocation(results[0]);
                        }

                        return false;
                    }
                );
            };

            /**
             * Create marker into map
             *
             * Input object type - google.maps.LatLng
             *
             * @param {Object} latLng
             */
            var createMarker = function(latLng) {
                // remove older marker
                if (marker) {
                    marker.remove();
                }
                if (options.hideMarker) {
                    // do not use marker
                    return;
                }
                marker = new google.maps.Marker({
                    'position'          : latLng,
                    'map'               : map,
                    'draggable'         : options.draggable
                });

                if (options.draggable) {
                    google.maps.event.addListener(marker, 'dragend', function() {
                        marker.changePosition(marker.getPosition());
                    });
                }

                marker.remove = function() {
                    google.maps.event.clearInstanceListeners(this);
                    this.setMap(null);
                };

                marker.changePosition = geocodePosition;
            };

            var changeBounds = function(radius) {
                var bounds = map.getBounds();
                console.log(bounds, radius.getBounds());
                if(bounds)
                {
                    console.log(bounds.union(radius.getBounds()));
                    map.fitBounds(bounds.union(radius.getBounds()), {bottom:50, left:45, right:40, top:50});
                }
                //
                // map.fitBounds(map.getBounds().union(radius.getBounds()));
            };

            var createRadius = function(latLng) {
                // remove older marker
                if (radius) {
                    radius.remove();
                }
                if (options.hideMarker) {
                    // do not use marker
                    return;
                }
                radius = new google.maps.Circle({
                    strokeColor: '#0ea3b1',
                    strokeOpacity: 0.9,
                    strokeWeight: 1,
                    fillColor: '#0ea3b1',
                    fillOpacity: 0.4,
                    map: map,
                    center: latLng,
                    radius: $('#search-distance').val()*1,
                    draggable: true
                });

                // if (options.draggable) {
                    google.maps.event.addListener(radius, 'dragend', function() {
                        radius.changePosition(radius.getCenter());

                    });
                // }

                changeBounds(radius);

                $('#search-distance').on('blur', function(){
                    radius.setRadius($(this).val()*1);
                    changeBounds(radius);
                });

                radius.remove = function() {
                    google.maps.event.clearInstanceListeners(this);
                    this.setMap(null);
                };

                radius.changePosition = geocodePosition;
            };

            /**
             * Touch point coordinates
             *
             * @param {Object} point google.maps.LatLng
             */
            var setLatLngAttributes = function(point) {
                $(options.latitude).val(point.lat());
                $(options.longitude).val(point.lng());
            };

            /**
             * Select location with geometry
             *
             * @param {Object} item
             */
            var selectLocation = function(item) {
                console.log(item);
                if (!item.geometry) {
                    return;
                }
                var bounds = item.geometry.viewport ? item.geometry.viewport : item.geometry.bounds;
                console.log(bounds);
                var center = null;
                if (bounds) {
                    map.fitBounds(new google.maps.LatLngBounds(bounds.getSouthWest(), bounds.getNorthEast()));
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
                    map.setCenter(center);
                    if(options.search)
                        createRadius(center)
                    else
                        createMarker(center);
                    setLatLngAttributes(center);
                }

            };

            // address validation using yii.activeForm.js
            if ($(options.address).parents('form').length) {
                var $form = $(options.address).parents('form');
                $form.on('afterValidateAttribute', function(e, attribute, messages) {
                    if (attribute.input === options.address && !$(options.latitude).val() && !$(options.longitude).val() && !messages.length) {
                        // address not found
                        messages.push(options.addressNotFound);
                        e.preventDefault();
                    }
                });
            }

            // address autocomplete using google autocomplete
            var autocomplete = new google.maps.places.Autocomplete($(options.address).get(0), {types:['address'], componentRestrictions:{country:'ru'}});

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place) {
                    return;
                }

                console.log('place', place);

                // if(place.address_components.length>3)
                // {
                    fillAddressForm(place.address_components);
                // }
                selectLocation(place);
            });

            var defaults = {
                'lat'       : $(options.latitude).val(),
                'lng'       : $(options.longitude).val()
            };
            if (defaults.lat && defaults.lng) {
                var center = new google.maps.LatLng(defaults.lat, defaults.lng);
                map.setCenter(center);
                if(options.search)
                    createRadius(center)
                else
                    createMarker(center);
                setLatLngAttributes(center);
            };

            var fillAddressForm = function(address_components){

                var street = '';
                var house = '';
                var region = '';
                var city = '';
                $(options.house).val('');
                $(options.street).val('');
                $(options.city).val('');
                $(options.region).val('');

                $.each(address_components, function(i,e){
                    if(e.types.indexOf('street_number')>=0)
                    {
                        house = e.long_name;
                        $(options.house).val(house);
                        // street.push(e.long_name);
                    }
                    // else
                    // {
                    //     $(options.house).val('');
                    // }
                    if(e.types.indexOf('route')>=0)
                    {
                        street = e.short_name;
                        $(options.street).val(street);
                    }
                    // else
                    // {
                    //     $(options.street).val('');
                    // }
                    if(e.types.indexOf('locality')>=0)
                    {
                        city = e.long_name;
                        $(options.city).val(e.long_name);
                    }
                    // else
                    // {
                    //     $(options.city).val('');
                    // }
                    if(e.types.indexOf('administrative_area_level_1')>=0 || e.types.indexOf('administrative_area_level_2')>=0)
                    {
                        region = e.long_name;
                        $(options.region).val(e.long_name);
                    }

                    if(region=='' && city !== '')
                    {
                        region = city;
                        $(options.region).val(city);
                    }
                    // else
                    // {
                    //     $(options.region).val('');
                    // }
                });


                $(options.address).val(street+', '+house+', '+city+', '+region);
                $(options.address).trigger('change');
            }

        });
    };
})(jQuery);

