<!DOCTYPE html>

<!--[if IE 8]> 		   <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="UTF-8">
    <meta name="description" content="My Street Value">
    <meta name="keywords" content="My Street Value">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta property="og:image" content="" />
    <meta property="og:title" content="Want to Know the Value of Your Home?" />
    <meta property="og:url" content="http://www.mystreetvalue.com/simplesms" />
    <meta property="og:description" content="Get the instant & accurate valuation of your home, FREE!" />
    <!-- SITE TITLE -->
    <title>My Street Value</title>


    <!--Styles-->
    <link rel="stylesheet" href="mystreetvalue/css/normalize.css" />
    <link rel="stylesheet" href="mystreetvalue/css/foundation.min.css" />
    <link rel="stylesheet" href="mystreetvalue/css/style.css" />



    <link rel="dns-prefetch" href="//maps.googleapis.com">

    <script src="mystreetvalue/js/vendor/custom.modernizr.js"></script>
    <script type="text/javascript">
        var appInsights = window.appInsights || function(config) {
            function r(config) {
                t[config] = function() {
                    var i = arguments;
                    t.queue.push(function() {
                        t[config].apply(t, i)
                    })
                }
            }
            var t = {
                    config: config
                },
                u = document,
                e = window,
                o = "script",
                s = u.createElement(o),
                i, f;
            for (s.src = config.url || "//az416426.vo.msecnd.net/scripts/a/ai.0.js", u.getElementsByTagName(o)[0].parentNode.appendChild(s), t.cookie = u.cookie, t.queue = [], i = ["Event", "Exception", "Metric", "PageView", "Trace"]; i.length;) r("track" + i.pop());
            return r("setAuthenticatedUserContext"), r("clearAuthenticatedUserContext"), config.disableExceptionTracking || (i = "onerror", r("_" + i), f = e[i], e[i] = function(config, r, u, e, o) {
                var s = f && f(config, r, u, e, o);
                return s !== !0 && t["_" + i](config, r, u, e, o), s
            }), t
        }({
            instrumentationKey: "c3b1345a-cacb-47a4-85e0-71e5795b5733"
        });

        window.appInsights = appInsights;
        appInsights.trackPageView();

    </script>
</head>

<body style="min-height:100vh">
    <!--Background-->
    <div class="bground">
        <div id="pano"></div>
        <div class="pattern p-03"></div>
    </div>

    <!--Step 1-->
    <section>

        <div class="vcenter" style="padding-top:100px" id="main">



            <!--Soon text-->
            <div class="large-12 soon text-center">
                Analyze My Property
            </div>

            <!--Subsoon text-->
            <div class="large-12 subsoon text-center" id="change">

                ENTER ADDRESS, GET CURRENT VALUE, & MONTHLY REPORTS
            </div>

            <div class="row">
                <div class="small-12 large-10 large-centered columns">


                    <form id="geoform" role="form" action="index2.php" method="GET">
                        <div class="large-7 columns">
                            <input type="text" name="address" id="geocomplete" placeholder="Enter Your Address">
                        </div>
                        <!--		<div class="large-2 columns">
								    <input type="text" name="unit" id="unit" placeholder="Unit #">
								</div>	-->

                        <div class="large-3 columns">
                            <button type="submit" name="go" id="b1" class="button prefix"><span class="butlabel">GO!</span><span class="spinner"></span></button>
                        </div>

                        <input name="name" type="hidden" value="">



                        <input name="id2" type="hidden" value="1">
                    </form>


                </div>
            </div>





        </div>


        <p class="large-12 large-centered columns" style="bottom:9px;position:absolute;color:white;font-size:11px;text-align:center">

            My Street Value ©2015 , All Rights Reserved.
            <br> You received this by My Street Value.
        </p>
    </section>


    <div class="loader">
        <div id="f">
            <div id="f_1" class="f"></div>
            <div id="f_2" class="f"></div>
            <div id="f_3" class="f"></div>
            <div id="f_4" class="f"></div>
            <div id="f_5" class="f"></div>
            <div id="f_6" class="f"></div>
            <div id="f_7" class="f"></div>
            <div id="f_8" class="f"></div>
        </div>
    </div>

    <!--Bottom scroll progress-->
    <div class="scroll-progress" data-0="width:0%;" data-end="width:100%;"></div>

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false&amp;libraries=places"></script>
    <script src="mystreetvalue/js/vendor/jquery.min.js"></script>
    <script src="mystreetvalue/js/foundation.min.js"></script>
    <script src="mystreetvalue/js/vendor/jquery.validate.min.js"></script>
    <script src="mystreetvalue/js/vendor/jquery.panoramic.js"></script>
    <script src="mystreetvalue/js/custom.js"></script>
    <script src="mystreetvalue/js/jquery.geocomplete.min.js"></script>

    <!--[if lt IE 9]>
			<script type="text/javascript" src="js/skrollr.ie.min.js"></script>
		<![endif]-->

    <script>
        $(function() {
            $("#geocomplete").geocomplete({
                details: "form"
            });

        });


        function load_map_and_street_view_from_address(address) {

            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'address': address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var gps = results[0].geometry.location;
                    create_map_and_streetview(gps.lat(), gps.lng(), 'map_canvas', 'pano');
                }
            });
        }

        var map;
        var myPano;
        var panorama;
        var houseMarker;
        var addLatLng;
        var panoOptions;

        function create_map_and_streetview(lat, lng, map_id, street_view_id) {
            var googlePos = new google.maps.LatLng(lat, lng);

            panorama = new google.maps.StreetViewPanorama(document.getElementById("pano"));
            addLatLng = new google.maps.LatLng(lat, lng);
            var service = new google.maps.StreetViewService();
            service.getPanoramaByLocation(addLatLng, 50, showPanoData);

            var myOptions = {
                zoom: 14,
                center: addLatLng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                backgroundColor: 'transparent',
                streetViewControl: false,
                keyboardShortcuts: false,

            }
            var map = new google.maps.Map(document.getElementById("pano"), myOptions);
            var marker = new google.maps.Marker({
                map: map,
                position: addLatLng
            });
        }

        function showPanoData(panoData, status) {
            if (status != google.maps.StreetViewStatus.OK) {


                $('#pano').panoramic({
                    panoid: '3NBdEhaZ75d8YxkPzZP12Q',
                    width: '100%',
                    height: '100%',
                    active: false,
                    heading: setting.panorama.heading,
                    pitch: setting.panorama.pitch,
                    speed: setting.panorama.speed,
                    zoom: setting.panorama.zoom,
                    customUrl: setting.panorama.customUrl,
                    events: function(b) {
                        setInterval(function() {
                            if (window.pageYOffset != 0) {
                                b.rotateStop();
                            } else {
                                b.rotateStart();
                            }
                        }, 1000)

                    }
                });



                return;
            }

            var panoid = panoData.location.pano;



            $('#pano').panoramic({
                panoid: panoid,
                width: '100%',
                height: '100%',
                active: false,
                heading: setting.panorama.heading,
                pitch: setting.panorama.pitch,
                speed: setting.panorama.speed,
                zoom: setting.panorama.zoom,
                customUrl: setting.panorama.customUrl,
                events: function(b) {
                    setInterval(function() {
                        if (window.pageYOffset != 0) {
                            b.rotateStop();
                        } else {
                            b.rotateStart();
                        }
                    }, 1000)

                }
            });





        }

        function computeAngle(endLatLng, startLatLng) {
            var DEGREE_PER_RADIAN = 57.2957795;
            var RADIAN_PER_DEGREE = 0.017453;

            var dlat = endLatLng.lat() - startLatLng.lat();
            var dlng = endLatLng.lng() - startLatLng.lng();
            // We multiply dlng with cos(endLat), since the two points are very closeby,
            // so we assume their cos values are approximately equal.
            var yaw = Math.atan2(dlng * Math.cos(endLatLng.lat() * RADIAN_PER_DEGREE), dlat) * DEGREE_PER_RADIAN;
            return wrapAngle(yaw);
        }

        function wrapAngle(angle) {
            if (angle >= 360) {
                angle -= 360;
            } else if (angle < 0) {
                angle += 360;
            }
            return angle;
        };


        $(window).load(function() {

            load_map_and_street_view_from_address('Ottawa, ON');




        });



        var setting = {
            counter: { //Setting for timer
                lastDate: '03/15/2015 16:45:00', //Date format: mm/dd/yy hh:mm:ss
                timeZone: null, //GMT +10 or -5
            },
            panorama: { //Setting for panorama
                panoid: '3NBdEhaZ75d8YxkPzZP12Q', //Panorama id
                heading: 0, //The camera heading in degrees relative to true north. True north is 0°, east is 90°, south is 180°, west is 270°
                pitch: -7, //The camera pitch in degrees, relative to the street view vehicle. Ranges from 90° (directly upwards) to -90° (directly downwards)
                speed: 1, //Rotation speed 0 - 10 
                zoom: 1, //Default zoom level. Not recommended at Zoom level 0
                customUrl: '' //Your panoramic image (url or local path)
            },
            map: { //Setting for map
                lat: 46.565883, //Latitude  
                lng: 3.33321, //Longitude
                markerTitle: 'My company', //Title for marker
            },
            message: { //Setting for messages
                required: 'This field is required',
                valid: 'Please enter a valid email address',
                exist: 'This email is already signed',
                error: 'Error request!',
            }
        };

        $(function() { //shorthand document.ready function
            $('#geoform').on('submit', function(e) { //use on if jQuery 1.7+

                if ($('#lat').val() == "") {
                    e.preventDefault();
                    $('#change').html('Please select an address from the dropdown, than hit go');
                    $('#change').css('color', 'red');
                } else {
                    $('#change').html('Working....please wait');
                    $('#change').css('color', 'white');
                    return true;
                }


            });
        });


        function formatPhone(val) {
            var num = val.value;
            var len = num.toString().length;
            for (var i = 0; i < len; i++) {
                var a = num.charAt(i);
                if (isNaN(a)) {
                    num = num.replace(a, '');
                    len--;
                    i--;
                }
                if (a == ' ') {
                    num = num.replace(a, '');
                    len--;
                    i--;
                }
            }
            val.value = num;
            if (val.value.length > 10) val.value = val.value.substring(0, 10);
            var re = /\D/;
            var re2 = /^\d{3}-\d{3}-\d{4}/;
            var num = val.value;
            if (num.length == 10) {
                newNum = num.substring(0, 3) + '-' + num.substring(3, 6) + '-' + num.substring(6, 10);
                val.value = newNum;
                $('#tcpa').show();
            }
        }


        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat_and_long = position.coords.latitude + ", " + position.coords.longitude;
                    $("#geocomplete").geocomplete("find", lat_and_long);
                });
            }
        }





        $(document).foundation();

    </script>
</body>

</html>
