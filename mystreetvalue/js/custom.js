


(function($) {

		
	$(window).load(function () {
		$('.loader').remove();
	});
	
	/*Function calls*/
	function ajaxAction(form, button) {
		
		$.ajax({
			beforeSend:function(){
				$(button).attr( 'data-loading','' );
			},
			complete:function(){
				$(button).removeAttr( 'data-loading' );
			},	
			success: function (data) {
				
				if (data == 0) {
					var lable;
					$(button + ' .butlabel').html(function(i,v){
						lable = v;
						return '<span class="success icon-checkmark"></span>';
					})
					setTimeout(function () {
						$(button + ' .butlabel').html(lable);
					}, 2000)
				} else if (data == 1) {
					$(form).validate().showErrors({
						subscribe: setting.message.valid
					});
				} else if (data == 2) {
					$(form).validate().showErrors({
						subscribe: setting.message.exist
					});
				} else {
					$(form).validate().showErrors({
						subscribe: setting.message.error
					});
				}
			},
			statusCode: {
				404: function () {
					alert('Not%20found%20actions.html');
				}
			},
			type: 'POST',
			url: 'php/actions.php',
			cache: false,
			data: $(form).serialize()
		});
	}

})(jQuery);
	
function vCenter(){
	$('.vcenter').each(function(i) {
		var m = Math.round(($(this).parent().height() - $(this).height()) / 2);
		$(this).css('margin-top', m > 0 ? m : 0);
	});
}

function aHeight(){
	if(window.innerWidth < 979){
		$('.alink').removeAttr('data-menu-top');
		$('.step-1').css('height', $(window).height());
		$('fieldset').css('min-height', function(){
			return $(window).height() - ($(this)
				.parent()
				.css('padding-top')
				.replace('px','')) * 2;
		});
	}else{
		$('.step-1').css('height', '');
		$('fieldset').css('min-height', '');
		$('.alink').each(function(i){
			$(this).attr('data-menu-top',$(this).attr('data-menu'));
		});
	}
}

function pulsate(element) {
	$(element || this).animate({ opacity: 0.3}, 1000, function() {
	    if(window.pageYOffset == 0){
	    	$(this).animate({ opacity: 1}, 1000,  pulsate(this));
	    }
	});
}

function mapLayer() {
	var myLatlng = new google.maps.LatLng(setting.map.lat,setting.map.lng);
		var mapOptions = {
		    zoom: 16,
		    center: myLatlng,
		    disableDefaultUI: true,
		    mapTypeControlOptions: {
     		mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'greyscale']
		}
	};
	var styles=[{
	    featureType: "all",
	    elementType: "all",
	    stylers: [
	    	{ saturation: -100 }
	    ]
	}];
	
	var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	
	var styledMapType = new google.maps.StyledMapType(styles, {name: 'grey'});
	map.mapTypes.set('greyscale', styledMapType);
	map.setMapTypeId('greyscale');
	
   	var marker = new google.maps.Marker({
	    position: myLatlng,
	    map: map,
	    title: setting.map.markerTitle,
		icon: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAlCAYAAAAjt+tHAAACXklEQVRYhe2X36raQBCHv4gRDYeDhFJv9BFKKb069HZ9DR/A99BH8GXc2+LVofQZzI1QJRSJkkjshTue9U800ZyWggPDSFz392V2dt1xttstAN1utwpUgJqJVcq1DZACMZCOx+MNgLPdbkW8BtSN1wxApSTx1ADEwNp4PB6PN45SSsQ94NnEOu+TgTUQAb9NjOUt60b8o9Z6UrLwgSmlXszHFNjYqfe01hPf93FdF9d1SxVOkoQkSdBaT5RSnzDLUOGt8OrAzeLL5fIgHtvRvFJnFal28ZvfPAxDer0eYRhmjrHm3mtKoWVWexAEuSEGgwHD4fDkN+12+9zwipBcNTkrbhnrOM7F8WXt85vt/wKQdOaNpQP0+/1CMY85Sikf+AD4WuvJccUGQVCoCE8EHOdgFwRBIKfhAvj1WILHEjyW4K5bj53qWyHvPooz/un+HsC99s8BztZAkUvIfD6/OubSfAKQ2g/b7TbT6fTqxP1+n2azefEaZhdnp9OxYVIB2FhOkiTMZrPch0mj0WC1WjEajXKNN7bXrPLWLq0FoNVqvdu1fLFYYLRiIK1a4pFS6iWrMfF9H8/zcolFUSRCJ2YOoUggJANrdu0SpmmwW7MKgNb6O3AVQsSVUt/MI6mv49ZsDaR5mtP9HV5r/XopE5b4Vw5rK7s5vdKeS7Tbtx/nICzxL3aKjwDOt+eXzIDVgSfjntb6pw1hiX824kvjaxHKsqsAGRBPkgnAfvMlBcRzA5yBeDYQr4Cs+ZJdceUWLwRwBOEZr5mvYnapj4qIFwawIKQoZavKFouLiAP8AcM+d5+Y7wPPAAAAAElFTkSuQmCC'
  	});
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
 	});
}

function mobileCheck(){
    if((/Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera)){
			return true;
    }else{
		return false;
	}   
}

function setAnimationFrame(){
	$('#count').attr({'data-0':'opacity:1','data-1500':'opacity:0'});
	$('.step-2').attr({'data-500':'top:100%','data-1500':'top:0%','data-2500':'display:block','data-3500':'top:-100%;display:none'});
	$('.step-3').attr({'data-0':'display:none','data-3200':'display:block;opacity:0;top:0px','data-3500':'opacity:1;top:0px','data-4500':'opacity:1','data-5500':'opacity:0'});
	$('.step-4').attr({'data-4500':'top:100%','data-5500':'display:block;top:0%'});
	$('.panel-top').attr({'data-0':'opacity:1;top:0%','data-500':'opacity:0;top:-10%'});
	$('.panel-bottom').attr({'data-0':'opacity:1;bottom:0%','data-500':'opacity:0;bottom:-10%'});
	$('.soon').attr({'data-0':'opacity:1;margin-bottom:0%','data-1500':'opacity:0;margin-bottom:-10%'});
	$('.subsoon').attr({'data-0':'opacity:1;top:0%','data-1500':'opacity:0;top:-10%'});
}