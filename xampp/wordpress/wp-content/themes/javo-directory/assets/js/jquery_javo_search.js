/*
* jQuery javo Search Plugin; v0.7.1
* Copyright (C) 2014 javo
*/

/* How to use (Examps) :
$(".javo_item_output").javo_search({
	url: "<?php echo admin_url('admin_ajax.php');?>",
	loading: "<?php echo JAVO_THEME_DIR;?>/images/loading.gif",
	selFilter:$(".javo_sel_filter"),
	btnSubmit:$(".javo_search_field_submit"),
	txtKeyword:$("input[name='s']"),
	param:{
		type:11,
		post_type:"item"
	}
});
*/
(function($){
	$.fn.javo_search = function(d){
		var a = $(this);
		var o = {}, p = {}, data={};
		// Ajax Initialize
		o.type = "post";
		o.dataType = "json";
		o.url = d.url;
		o.success = function(data){
			var bound = new google.maps.LatLngBounds();
			var markers = new Array();
			if(data.result == "success"){
				a.fadeOut('fast', function(){
					$(this).html(data.html).fadeIn('fast');
					if( d.success_callback != null && typeof( d.success_callback) != 'undefined' ){
						d.success_callback();
					}
				});
			}else{
				a.html("Fail to load posts!");	
			};
			if(typeof(d.map) != "undefined"){
				var tar = d.map.val();
				if(tar != ""){
					if( typeof($(tar).get(0)) != "undefined" ){
						var t = $(tar);
						if( typeof(jQuery.fn.gmap3) != "undefined"){
							$.each(data.markers, function(i, v){
								if(v.lat != "", v.lng != ""){
									markers.push({latLng:[v.lat, v.lng], data:v.info, options:{icon:v.icon}});
									bound.extend( new google.maps.LatLng(v.lat, v.lng));
								}
							});
							var m_options = { map:{ options:{ 
								/*center: bound.getCenter(), */
								zoom:6,
								mapTypeId: google.maps.MapTypeId.ROADMAP,
								mapTypeControl: false,
								navigationControl: true,
								scrollwheel: false,
								streetViewControl: true								
							} },marker:{} };
							m_options.marker = { 
								values: markers,
								events:{
									click:
										function(m, e, c){
											var map = $(this).gmap3("get"), infoBox = $(this).gmap3({get:{name:"infowindow"}});
											if(infoBox){
												infoBox.open(map, m);
												infoBox.setContent(c.data);
											}else{
												$(this).gmap3({ infowindow:{ anchor:m, options:{content: c.data, maxWidth:500} } });
											};
										}
								}
							};
							$( d.map.val() )
								.height(350)
								.gmap3({ clear:{ name:"marker" }})
								.gmap3(m_options);
							var _m = $( d.map.val() ).gmap3("get");
							_m.fitBounds(bound);
						}else{
							t.html("<h1>Please, install to jQuery gmap3.</h1>");
						};
					};
				};
			};
		};

		o.error = function(e){ alert("Error : " + e.state()); console.log( e.responseText ); };

		// Ajax Parametter Initialize
		p = $.extend({
			type:1,
			ppp:10,
			featured:"image",
			page: "widget",
			post_type:"item",
			meta_term: false,
			success_callback: null,
			before_callback:null
		}, d.param);

		if(!d.noStart) rsearch(p);
		// Buttons Functions
		$(document).find(d.btnView).off().on("change", function(){
			if(typeof(d.btnView) != "undefined"){
				p.type = $(this).val();
				rsearch(p);
			};
		});
		$(document).find(a).off().on("click", ".page-numbers", function(e){
			e.preventDefault();
			var pn = $(this).attr("href").split("=");
			p.page = (typeof(pn[1]) != "undefined")? pn[1] : 1;
			rsearch(p);
		});
		$(d.btnSubmit).on("click", function(e){
			e.preventDefault();
			if(typeof(d.btnSubmit) != "undefined"){
				rsearch(p);
			};
		});
		$(d.txtKeyword).on("keyup", d.txtKeyword, function(e){
			if(e.keyCode == 13){
				p.page = 1;
				rsearch(p);
			};
		});
		function rsearch(p){

			if(typeof(d.selFilter) != "undefined"){
				$.each(d.selFilter, function(){
					if( this.value != "" && this.value > 0){
						var n = this.name.replace("]", "").split("[")[1];
						data[n] = this.value;
					};
				});
				p.tax = data;
			};
			if(typeof(d.txtKeyword) != "undefined"){
				p.keyword = d.txtKeyword.val();
			};
			if( typeof(d.post_id) != "undefined" ){
				p.post_id = d.post_id;			
			}
			if( d.meta_term != false && typeof(d.meta_term) != "undefined"){
				data = {};
				$.each(d.meta_term, function(i, v){
					var n = this.name.replace("]", "").split("[")[1];
					data[n] = this.value;
				});
				p.term_meta = data;
			};
			if( d.price_term != false && typeof(d.price_term) != "undefined"){
				data = {};
				$.each(d.price_term, function(i, v){
					var n = this.name.replace("]", "").split("[")[1];
					data[n] = this.value;
				});
				p.price_term = data;
			};
			if( d.area_term != false && typeof(d.area_term) != "undefined"){
				data = {};
				$.each(d.area_term, function(i, v){
					var n = this.name.replace("]", "").split("[")[1];
					data[n] = this.value;
				});
				p.area_term = data;
			};
			p.action = "post_list";
			o.data = p;
			if( d.before_callback != null && typeof( d.before_callback) != 'undefined' ){
				d.before_callback();
			}
			$.ajax(o);	
		};
	};
})(jQuery);