/*!
 * jQuery Panoramic Plugin v1.0
 * Date: 04/29/2014
 * Autor: G_4 | http://codecanyon.net/user/G_4/portfolio
 */

(function() {
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame'] 
        || window[vendors[x]+'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); }, 
                timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };

    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
}());

(function($){
    
    $.panoramic = function(el, options){
        
        var base = this, _base = {p:{}}, image;
        
        // Access to jQuery and DOM versions of element
        base.$el = $(el);
        base.el = el;
        
        // Add a reverse reference to the DOM object
        base.$el.data("panoramic", base);
        
        base.options = $.extend({}, $.panoramic.defaultOptions, options);
        
        _base.init = function(){

            $(base.el).addClass('panoramic').css({
                'height': base.options.height,
                'width': base.options.width
            });
               
            _base.p = new google.maps.StreetViewPanorama(base.el, {
                pano: $(base.el).attr('data-panoid') || base.options.panoid,
                mode: _base.isCanvas(),
                pov:{
                    heading: base.options.heading,
                    pitch: base.options.pitch,
                    zoom: base.options.zoom
                },
                panControl: base.options.panControl,
                panControlOptions:{
                    position: base.position(base.options.panPosition)
                },
                zoomControl: base.options.zoomControl,
                zoomControlOptions: {
                    style: _base.style(base.options.zoomStyle),
                    position: base.position(base.options.zoomPosition)
                  },
                addressControl: base.options.addressControl,
                addressControlOptions:{
                    position: base.position(base.options.addressPosition)
                },
                linksControl: base.options.linksControl,
                enableCloseButton: false,
                clickToGo: base.options.clickToGo,
                scrollwheel: base.options.scrollwheel,
                interval: base.way(base.options.way),
                panoProvider: _base.isCustom() ? _base.custom : null
            });


            if(base.options.speed != 0 && base.options.play){
                _base.animLoop();
            }

            if(base.options.active){
                $(base.el).on( 'mouseover', function() {
                    base.rotateStop();
                });
                $(base.el).on( 'mouseout', function() {
                    base.rotateStart();
                });
            }
            
            base.menu();

            base.options.events(base);
        };
        
        // Functions
        _base.animLoop = function () {
            if(!_base.isVisible(base.el)){
                _base.p.setPov({
                    heading: _base.p.getPov().heading + _base.p.interval,
                    pitch: _base.p.getPov().pitch,
                    zoom: _base.p.getPov().zoom
                });
            }
            base.timer = requestAnimationFrame(function(){
                _base.animLoop();
            });
        };

        base.way = function (w){
            if(w == 'l' || w == 'left') {
                return _base.p.interval = base.options.speed/10;
            }else{
                return _base.p.interval = -base.options.speed/10;
            }
        };

        base.rotateStart = function(){
            cancelAnimationFrame(base.timer);
            _base.animLoop();
        };

        base.rotateStop = function(){
            cancelAnimationFrame(base.timer);
        };


        base.setPano = function(i){
            _base.p.setPano(i);
        };
        
        base.setOptions = function(i){
            _base.p.setOptions(i);
        };

        base.menu = function(){
            if(_base.menuSet && _base.menuSet.length != 0){
                _base.menuSet.pop();
                $(base.el).off('click.menu');
            }
            
            if(base.options.menu){
                _base.menuSet = _base.p.controls[base.position(base.options.menuPosition)];
                _base.menuSet.push($('<div/>', {
                    'class': $.inArray(base.position(base.options.menuPosition), [4,5,6,7,8,9]) != -1 ? 'vert':''
                }).append(base.options.menuTemp(base) || _base.menuTemp())[0]);

                $(base.el).on('click.menu', '.l', function(){
                    base.way('l');
                    return false;
                });

                $(base.el).on('click.menu', '.r', function(){
                    base.way('r');
                    return false;
                });

                $(base.el).on('click.menu', '.p', function(){
                    if($(this).hasClass('pause')){
                        base.rotateStop();
                    }else{
                        base.rotateStart();
                    }
                    $(this).toggleClass('play pause');
                    return false;
                });

                $(base.el).on('click.menu', '.f', function(){
                    $(base.el).toggleClass('full');
                    google.maps.event.trigger(_base.p, 'resize');
                    return false;
                });
            }
        };

        /* Identifiers used to specify the placement of controls
        +----------------+
        | TL    TC    TR |
        | LT          RT |
        |                |
        | LC          RC |
        |                |
        | LB          RB |
        | BL    BC    BR |
        +----------------+ 
        */
        base.position = function(a){
            var p = google.maps.ControlPosition;
            switch (a) {
                case 'BC': return p.BOTTOM_CENTER; 
                    break
                case 'BL': return p.BOTTOM_LEFT; 
                    break
                case 'BR': return p.BOTTOM_RIGHT; 
                    break
                case 'LB': return p.LEFT_BOTTOM; 
                    break
                case 'LC': return p.LEFT_CENTER; 
                    break
                case 'LT': return p.LEFT_TOP; 
                    break
                case 'RB': return p.RIGHT_BOTTOM; 
                    break
                case 'RC': return p.RIGHT_CENTER; 
                    break
                case 'RT': return p.RIGHT_TOP; 
                    break
                case 'TC': return p.TOP_CENTER; 
                    break
                case 'TL': return p.TOP_LEFT; 
                    break
                case 'TR': return p.TOP_RIGHT; 
                    break
                default:   return p.TOP_LEFT;
            }
        };

        _base.isVisible = function (e) {
            var bc = e.getBoundingClientRect();
            if(bc.bottom < 50 || window.innerHeight < bc.top + 50)
                return true;
        };

        _base.isCanvas = function (){
            var elem = document.createElement('canvas');
            if(!!(elem.getContext && elem.getContext('2d'))){
                return 'html5';
            }
        };

        _base.custom = function (pano,zoom,tileX,tileY){    
            return {
                copyright:base.options.customCopyright,
                location: {
                    pano:'panoramc',
                    description: base.options.customDesc
                },
                tiles: {
                    tileSize: image.pTitle,
                    worldSize: image.pWorld,
                    getTileUrl: function() {
                        return image.src;
                    }
                }
            };
        };

        _base.menuTemp = function(){
            var s = base.options.play ? 'pause' : 'play';
            return '<div class="pctrl">'+
                (base.options.menuBtnWay ? '<a href="#" class="icon l" title="Left"></a>' : '')+
                (base.options.menuBtnPlay ? '<a href="#" class="icon p ' + s + '" title="Play"></a>' : '')+
                (base.options.menuBtnWay ? '<a href="#" class="icon r" title="Right"></a>' : '')+
                (base.options.menuBtnFull ? '<a href="#" class="icon f" title="Full Screen"></a>' : '')+
            '</div>';
        };

        _base.isCustom = function(){
            if($(base.el).attr('data-panoid') || base.options.panoid !== 'panoramic' || $(base.el).attr('data-url') || base.options.customUrl){
                return $(base.el).attr('data-url') || base.options.customUrl;
            }else {
                return 'empty';
            }
        };

        _base.imageLoad = function(i){
            image = new Image();
            if(_base.isCustom() == 'empty'){
                var cap = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFsAAAApAQAAAAEFoFhoAAAACXBIWXMAAAsSAAALEgHS3X78AAAACXRFWHRDb21tZW50AACJKo0GAAAA8ElEQVR4nGP4/4Hh/gcGIHkXTILQA4b2ByByP5gEoo+a+xj+//8HxqXf3sDZWXPqGOpfIeRAePfPMIa9/1NQxNqBxP8/DG2xd94Bqf8ggIWqB1Lv8/9X796CU8n//z8Y+iHUlzcvxef/YOgrr6yu/8Hwv7wUTEHkiKPeA6nVu/+/W7eCYff+/7/evWCwXv7/x8sPpJkCAw8Y7u9H5phv3r5575y3e8Gcz9u3b5+79+1+MOfH9h3lR/e+PQzioBhAHuc9kGaEcGQl3sn//1/38OLDywwMvO9zQTIf7t2738Bw9n0uUF39nXv37lHFUgQHAJ7rxQ4TW2bgAAAAAElFTkSuQmCC';
                image.pTitle = new google.maps.Size(89, 38);
                image.pWorld = new google.maps.Size(2500, 1000);
            }
            image.onload = function(i){
                image.pTitle = image.pTitle || new google.maps.Size(image.width, image.height);
                image.pWorld = image.pWorld || new google.maps.Size(image.width, image.height);
                _base.init();
            };
            image.src = cap || _base.isCustom();
        };



        _base.style = function(a){
            var s = google.maps.ZoomControlStyle;
            switch (a) {
                case 'LARGE': return s.LARGE; 
                    break
                case 'SMALL': return s.SMALL; 
                    break
                default:      return s.DEFAULT;
            }
        };


        // Run initializer
        _base.isCustom() ? _base.imageLoad() : _base.init();
        
    };
    
    $.panoramic.defaultOptions = {
        panoid: 'panoramic',
        heading: 0,
        pitch: -7,
        speed: 3,
        zoom: 1,
        way: 'l',
        width: '640px',
        height: '480px',
        linksControl: false,
        panControl: false,
        panPosition: 'TL',
        zoomControl: false,
        zoomPosition: 'TL',
        zoomStyle: 'DEFAULT',
        addressControl: false,
        addressPosition: 'TL',
        clickToGo: false,
        scrollwheel: false,
        active: false,
        menu: false,
        menuTemp:function(i){return false},
        menuPosition: 'BC',
        menuBtnWay: true,
        menuBtnPlay: true,
        menuBtnFull:true,
        play: true,
        customUrl: null,
        customCopyright: null,
        customDesc: null,
        events:function(i){return false}
        
    };
    
    $.fn.panoramic = function(options){
        return this.each(function(){
            (new $.panoramic(this, options));
        }).data("panoramic");
    };
    
})(jQuery);