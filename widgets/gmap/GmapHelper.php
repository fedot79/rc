<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 18.07.2018
 * Time: 18:23
 */

namespace app\widgets\gmap;


class GmapHelper
{
    public static function jsShow($lat, $lng, $distance)
    {
        return <<<JS
$(document).ready(function() {
    // var style = [
    //             {
    //                 "elementType": "geometry",
    //                 "stylers": [
    //                     {
    //                         "color": "#f5f5f5"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "elementType": "labels.icon",
    //                 "stylers": [
    //                     {
    //                         "visibility": "off"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "color": "#616161"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "elementType": "labels.text.stroke",
    //                 "stylers": [
    //                     {
    //                         "color": "#f5f5f5"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "administrative.land_parcel",
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "color": "#bdbdbd"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "poi",
    //                 "elementType": "geometry",
    //                 "stylers": [
    //                     {
    //                         "color": "#eeeeee"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "poi",
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "color": "#757575"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "poi.park",
    //                 "elementType": "geometry",
    //                 "stylers": [
    //                     {
    //                         "color": "#e5e5e5"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "poi.park",
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "color": "#9e9e9e"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "road",
    //                 "elementType": "geometry",
    //                 "stylers": [
    //                     {
    //                         "color": "#ffffff"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "road.arterial",
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "color": "#757575"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "road.highway",
    //                 "elementType": "geometry",
    //                 "stylers": [
    //                     {
    //                         "color": "#dadada"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "road.highway",
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "color": "#616161"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "road.local",
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "color": "#9e9e9e"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "transit.line",
    //                 "elementType": "geometry",
    //                 "stylers": [
    //                     {
    //                         "color": "#e5e5e5"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "transit.station",
    //                 "elementType": "geometry",
    //                 "stylers": [
    //                     {
    //                         "color": "#eeeeee"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "water",
    //                 "elementType": "geometry",
    //                 "stylers": [
    //                     {
    //                         "color": "#c9c9c9"
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "water",
    //                 "elementType": "geometry.fill",
    //                 "stylers": [
    //                     {
    //                         "color": "#0ea3b1"
    //                     },
    //                     {
    //                         "saturation": -80
    //                     },
    //                     {
    //                         "lightness": 70
    //                     }
    //                 ]
    //             },
    //             {
    //                 "featureType": "water",
    //                 "elementType": "labels.text.fill",
    //                 "stylers": [
    //                     {
    //                         "color": "#9e9e9e"
    //                     }
    //                 ]
    //             }
    //         ];
    var mapOptions = {
        center: new google.maps.LatLng({$lat}, {$lng}),
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

    window.map = new google.maps.Map($('#map')[0], mapOptions);
    window.circle = new google.maps.Circle({
      strokeColor: '#0ea3b1',
        strokeOpacity: 0.9,
        strokeWeight: 1,
        fillColor: '#0ea3b1',
        fillOpacity: 0.4,
      map: window.map,
      center: new google.maps.LatLng({$lat}, {$lng}),
      radius: {$distance}
    });
    
    // if (options.onLoadMap) {
    //     options.onLoadMap(map);
    // }
});
JS;

    }

    public static $style_json = '[
    {
        "featureType": "all",
        "elementType": "all",
        "stylers": [
            {
                "hue": "#e7ecf0"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -70
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "labels",
        "stylers": [
            {
                "visibility": "simplified"
            },
            {
                "saturation": "-64"
            },
            {
                "gamma": "0.93"
            },
            {
                "lightness": "20"
            }
        ]
    },
    {
        "featureType": "transit.station.bus",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            },
            {
                "saturation": -60
            }
        ]
    }
]';
}