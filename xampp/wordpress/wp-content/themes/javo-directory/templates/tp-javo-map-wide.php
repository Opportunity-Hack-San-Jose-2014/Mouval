<?php
/* Template Name: Map (Wide Style) */

global $javo_tso;
$javo_this_tax_common_args = Array( 'hide_empty'=> 0);
$javo_this_filter_taxoomies = Array( 'item_category', 'item_location' );
$mail_alert_msg = Array(
	'to_null_msg'=> __('Please, to email adress.', 'javo_fr')
	, 'from_null_msg'=> __('Please, from email adress.', 'javo_fr')
	, 'subject_null_msg'=> __('Please, insert name.', 'javo_fr')
	, 'content_null_msg'=> __('Please, insert content', 'javo_fr')
	, 'failMsg'=> __('Sorry, mail send failed.', 'javo_fr')
	, 'successMsg'=> __('Successfully !', 'javo_fr')
	, 'confirmMsg'=> __('Send this email ?', 'javo_fr')
);
get_header(); ?>

<div id="javo-map-wide-wrapper">
	<div class="javo_somw_panel row">
		<div class="col-md-12">
			
			<div class="row map-top-btns">
				<div class="col-md-12">				
					<div class="btn-group btn-group-justified" data-toggle="buttons">
						<a class="btn btn-dark active" data-javo-map-mode="list"><?php _e('Total');?></a>
						<a class="btn btn-dark" data-javo-map-mode="featured"><?php _e('Features');?></a>
						<a class="btn btn-dark" data-javo-map-mode="favorite"><?php _e('Favorite');?></a>
					</div><!-- /.btn-Grouop -->
				</div><!-- /.col-md-12 -->
			</div> <!-- map-top-btns -->

			<div class="row category-btns-wrap">
				<div class="col-md-12">
					<?php
					foreach($javo_this_filter_taxoomies as $tax){
						?>
						<div class="newrow">
							<h4 class="title"><?php echo get_taxonomy($tax)->label;?></h4>
							<?php $javo_this_terms = get_terms($tax, $javo_this_tax_common_args);?>
							<button data-filter="<?php echo $tax;?>" class="btn-map-panel active"><?php _e('All', 'javo_fr');?></button>
							<?php
							if( !empty( $javo_this_terms ) ){
								foreach( $javo_this_terms as $term){
									printf('<button data-filter="%s" class="btn-map-panel" data-value="%s">%s</button>', $tax, $term->term_id, $term->name);
								};// End Foreach
							}; // End If ?>
						</div>
						<?php
					}; // End Foreach
					if( $javo_tso->get('map_keyword', '') == 'on'): ?>
						<div class="newrow">
							<h4 class="title"><?php _e('Keyword', 'javo_fr');?></h4>
							<input id="javo_keyword" type="text" class="fullcolumn">
						</div>
					<?php endif;?>
					<div class="newrow">
						<button class="btn-map-panel active javo-tooltip javo-map-wide-goto-my-position" title="<?php _e('Please accept to access your location.', 'javo_fr');?>"><?php _e('My Position', 'javo_fr');?></button>
					</div>
				</div> <!-- col-md-12 -->
			</div><!-- /.category-btns-wrap -->

			<section class="newrow">
			<article class="javo_somw_list_content"></article>
		</section>

				


		</div> <!-- col-md-12 -->
		<span class="javo_somw_opener active"><?php _e('Hide', 'javo_fr');?></span>

	</div> <!-- javo_somw_panel row -->
	<div class="map_area"></div> <!-- map_area : it shows map part -->
</div><!-- Gmap -->

<script type="text/template" id="javo-map-wide-content-loading">
<div class="text-center">
	<img src="<?php echo JAVO_THEME_DIR;?>/assets/images/loading.gif" width="64">
	<span><?php _e('Loading', 'javo_fr');?></span>
</div><!-- /.text-center -->
</script>
<script type="text/javascript">
jQuery(function($){
	"use strict";
	var javo_map = {
		root:null
		, el			: $('.map_area')
		, map			: null
		, target		: null
		, remote		: {}
		, options:{
			map_init:{
				map:{
					options:{
						mapTypeId: google.maps.MapTypeId.ROADMAP
						, mapTypeControl: false
						, panControl: false
						, scrollwheel: false
						, streetViewControl: true
						, zoomControl: true
						/*, zoomControlOptions: {
							position: google.maps.ControlPosition.RIGHT_BOTTOM
							, style: google.maps.ZoomControlStyle.SMALL

						 }*/
					}
				}
				,panel:{
					options:{
						content:'<div class="javo-map-wide-error-panel hidden">Test</div>'
						, top: true
						, center: true
					
					}
					
				
				
				}
			}
			, ajax_options:{
				url: null
				, type: 'post'
				, data:{
					filter:{}
				}, dataType: 'json'
			}
			, ajax_slider_options:{
				url: null
				, type: 'post'
				, data:{}
				, dataType: 'json'
			}
			, javo_mail:{
				subject: $("input[name='contact_name']")
				, from: $("input[name='contact_email']")
				, content: $("textarea[name='contact_content']")
				, to_null_msg: "<?php echo $mail_alert_msg['to_null_msg'];?>"
				, from_null_msg: "<?php echo $mail_alert_msg['from_null_msg'];?>"
				, subject_null_msg: "<?php echo $mail_alert_msg['subject_null_msg'];?>"
				, content_null_msg: "<?php echo $mail_alert_msg['content_null_msg'];?>"
				, successMsg: "<?php echo $mail_alert_msg['successMsg'];?>"
				, failMsg: "<?php echo $mail_alert_msg['failMsg'];?>"
				, confirmMsg: "<?php echo $mail_alert_msg['confirmMsg'];?>"
				, url:"<?php echo admin_url('admin-ajax.php');?>"			
			}
		}
		,variable:{
			top_offset: $('header > nav').outerHeight() + $('#wpadminbar').outerHeight()
		
		}
		, map_clear:function(){
			this.el.gmap3({clear:{ name:"marker" }});
			this.marker_clear();

		}
		, ajax_slider:function(t){
			var $this = $(t);

			this.options.ajax_slider_options.url = this.options.ajax_options.url;
			this.options.ajax_slider_options.data = {};
			this.options.ajax_slider_options.data.action = 'get_detail_images';
			this.options.ajax_slider_options.data.post_id = $this.data('post-id');
			this.options.ajax_slider_options.error = function(e){};
			this.options.ajax_slider_options.success = function(d){

				$this
					.find('.javo-hmap-flexslider ul')
					.append( d.result );

				$this
					.find('.javo-hmap-flexslider')
					.flexslider({
						animation: "slide"
						, controlNav: false
					});
			};

			jQuery.ajax(this.options.ajax_slider_options);		
		}
		, marker_clear:function(){ this.el.gmap3({ clear:{ name:"marker" }}); }
		, overlay_clear:function(){ this.el.gmap3({ clear:{ name:"overlay" }}); }
		, info_clear:function(){ 
			var markers = this.el.gmap3({ get:{ name:"marker", all:true } });
			this.infoWindo.close(); 
			$(markers).each(function(k, v){
				v.setAnimation(null);
			});
		}
		, resize:function(){
			// Setup Map Height
			this.el.height( $(window).height() );
		}
		, run:function(){

			var $object = this;
			var markers = new Array();
			var avg = new google.maps.LatLngBounds();
			this.options.ajax_options.data.action = "javo_map";
			this.options.ajax_options.data.post_type = "item";
			this.options.ajax_options.success = function(d){

				// Clear Map
				$object.marker_clear();
				$object.info_clear();

				// Get Contents
				$('.javo_somw_list_content').empty().html( d.html );				

				// Define Markers
				$.each( d.markers, function(k, v){

					// Create Markers 
					markers.push({
						latLng: new google.maps.LatLng( v.lat, v.lng )
						, options:{ animation:google.maps.Animation.DROP }
						, id: 'mid_' + k
						, data: v.content
					});

					// Geo Location
					avg.extend( new google.maps.LatLng(v.lat, v.lng) );
				});

				// Set Marker Values
				$object.el.gmap3({ 
					map:{ events:{ 
						click:function(){ $object.info_clear(); }
					}}, marker:{ 
						values: markers
						, events:{
							click:function(m, e, c){
								$object.info_clear();
								$object.infoWindo.close();
								$object.infoWindo.setContent(c.data);
								$object.infoWindo.open( $(this).gmap3('get'), m);

								$object.map.setCenter( m.getPosition() );
								m.setAnimation( google.maps.Animation.BOUNCE );
							}						
						}
					} 
				});

				if( markers.length > 0 ){
					// Bounding
					$object.map.fitBounds(avg);
				};
			};

			this.options.ajax_options.error = function(e){
				var jv_alert = "<div class='jv_alert'>";
				jv_alert += "Error : ";
				jv_alert += e.state();
				jv_alert += "<br>d</div>";

				$(jv_alert).appendTo( $object.el );

				$(".jv_alert")
				.css({
					top:"0px"
					, left:"20%"
					, background:"#f00"
					, color:"#fff"
					, position:"fixed"
					, zIndex: "9999"
					, padding: "15px"
					, opacity: 0
					, marginTop: "-300px"
				}).animate({ marginTop:0, opacity:0.8 }, 500, function(){

					var _this = $(this);
					_this.animate({ opacity:0, marginTop:"-5px" }, 5000, function(){ _this.remove(); });

				});
				console.log( e.responseText );
			};
			$('.javo_somw_list_content').html($('#javo-map-wide-content-loading').html());
			$.ajax( this.options.ajax_options );
		}
		, onError:function(str){
			$('.javo-map-wide-error-panel')
				.html(str)
				.removeClass('hidden')
				.css({
					background		: '#fff'
					, padding		: '5px'
					, width			: '100%'

			
				});
		}
		, events:function(){
			var $object = this;
			$(document).on('keyup', '#javo_keyword', function(e){

				if( e.keyCode == 13 ){
					$object.options.ajax_options.data.keyword = $(this).val();
					$object.run();
				}
			
			}).on('click', 'button[data-filter]', function(){
				var $this_category = $(this).data('filter');

				$('button[data-filter="' + $this_category + '"]').removeClass('active');
				$(this).addClass('active');
				$object.options.ajax_options.data.current					= 1;
				$object.options.ajax_options.data.filter[ $this_category ]	= $(this).data('value');
				$object.run();
			
			
			}).on('change', 'select[data-javo-hmap-sort]', function(){

				$object.options.ajax_options.data.order = $(this).val();
				$object.run();

			}).on('change', 'select[data-javo-hmap-ppp]', function(){

				$object.options.ajax_options.data.ppp = $(this).val();
				$object.run();
			
			}).on('change', 'select[data-column-remote]', function(){

				$object.options.ajax_options.data.column = $(this).val();
				$object.run();
			
			}).on('click', '.javo-hmap-marker-trigger', function(){
				var $this = $(this);
				$object.el.gmap3({ 
					get:{ 
							  name:"marker"
						,		id: $this.data('id')
						, callback: function(m){
							google.maps.event.trigger(m, 'click');
						}
					}
				});
			}).on('click', '.javo-hmap-switch-type', function(){
				$('.javo-hmap-switch-type').removeClass('active');
				$(this).addClass('active');
				$object.options.ajax_options.data.listing_type = $(this).data('value');
				$object.run();			
			}).on('click', '.page-numbers', function(e){
				e.preventDefault();
				var _cur = $(this).prop('href').split('?');
				_cur = parseInt( typeof(_cur[1]) != 'undefined' ? _cur[1] : 1 );
				$object.options.ajax_options.data.current = _cur;
				$object.run();
			}).on('click', '.javo-mhome-sidebar-onoff', function(){
				if( $(this).hasClass('active') ){
					$(this).removeClass('active');
					$object.side_out();
				}else{
					$(this).addClass('active');
					$object.side_move();	
				}
			}).on("click", ".javo_somw_opener", function(){
				var _panel = $(".javo_somw_panel");
				if( $(this).hasClass("active") ){

					//$(this).animate({marginLeft:-(parseInt(_panel.outerWidth())) + "px" }, 500);
					_panel.animate({marginLeft:-(parseInt(_panel.outerWidth())) + "px"}, 500);
					$(".map_area").animate({marginLeft:0}, 500, function(){
						$(".map_area").gmap3({ trigger:"resize" });
					});
					$(this).text("Show").removeClass('active');
				}else{
					//$(this).animate({marginLeft:0}, 500);
					_panel.animate({marginLeft:0}, 500);
					$(".map_area").animate({marginLeft:parseInt(_panel.outerWidth(	)) + "px"}, 500, function(){
						$(".map_area").gmap3({ trigger:"resize" });
					});
					$(this).text("Hide").addClass('active');
				};

			}).on('click', '#contact_submit', function(){
				$_this_form =  $(this).closest('form');
				$object.options.javo_mail.to = $_this_form.find('input[name="contact_this_from"]').val();
				$.javo_mail( $object.options.javo_mail );
			
			}).on('click', 'a[data-javo-map-mode]', function(){
				$(this).parent().find('a').removeClass('active');
				$('.category-btns-wrap').addClass('hidden');

				if( $(this).data('javo-map-mode') == 'list' ){
					$('.category-btns-wrap').removeClass('hidden');
				}else if( $(this).data('javo-map-mode') == 'favorite' ){
					if( !$('body').hasClass('logged-in') ){
						$("#login_panel").modal();
						return false;					
					}
				};

				$object.options.ajax_options.data		= {filter:{}};
				$object.options.ajax_options.data.panel = $(this).data('javo-map-mode');
				$object.run();			
			}).on('click', '.javo-map-wide-goto-my-position', function(){
				$object.el.gmap3({
					getgeoloc:{
						callback : function(latLng){
							if( !latLng ) return false;
							$(this).gmap3({
								map:{
									options:{ center:latLng, zoom:12 }
								}, marker:{
									id:'javo-map-wide-current-my-position'
									, latLng: latLng
									, options:{
									}								
								}, circle:{
									options:{
										center:latLng
										, radius:10000
										, fillColor:'#464646'
										, strockColor:'#000000'									
									}
								
								}
							});
						}
					}
				});			
			});
		}
		, side_move: function(){
			var $this = $('.javo_mhome_sidebar');
			$this.clearQueue().animate({ marginLeft: 0 }, 100);

			$('.javo_mhome_wrap').clearQueue().animate({
				paddingLeft: $this.outerWidth() + 'px'
			}, 100);
		}
		, side_out: function(){
			var $this = $('.javo_mhome_sidebar');
			$this.clearQueue().animate({
				marginLeft: ( -$this.outerWidth()) + 'px'
			}, 100);
			$('.javo_mhome_wrap').animate({ paddingLeft: 0 }, 100);
		}
		, brief_run: function(e){
			var brief_option = {};
			brief_option.type = "post";
			brief_option.dataType = "json";
			brief_option.url = "<?php echo admin_url('admin-ajax.php');?>";
			brief_option.data = { "post_id" : $(e).data('id'), "action" : "javo_map_brief"};
			brief_option.success = function(db){
				$(".javo_map_breif_modal_content").html(db.html);
				$("#map_breif").modal("show");
				$(e).button('reset');
			};
			$(e).button('loading');
			$.ajax(brief_option);
		}
		, contact_run: function(e){
			$('input[name="contact_this_from"]').val( $(e).data('to') );
			$("#author_contact").modal('show');
		}
		, init:function(){

			// Initialize Map
			this.el = $('.map_area');
			this.el.gmap3( this.options.map_init );

			// Initalize DOC
			$('body').css('overflow', 'hidden');

			// Initialize Variables
			this.map = this.el.gmap3('get');

			// Settings
			this.options.ajax_options.url = "<?php echo admin_url('admin-ajax.php');?>";
			this.options.ajax_options.data.ppp = 10;
			this.options.ajax_options.data.listing_type = 'page';

			// Filter Examp
			// this.options.ajax_options.data.filter = { taxomony_name : term_id };

			// Initialize Layout
			this.resize();

			// Process Run
			this.run();

			this.events();

			$(window).load(function(){
				$('.javo_somw_panel')
					.removeClass('hidden')
					.css({
						marginLeft: ( -$('.javo_mhome_sidebar').outerWidth()) + 'px'
					});
				$(".map_area").css({marginLeft:parseInt($('.javo_somw_panel').outerWidth()) + "px"});
				$(".javo_somw_opener").css({
					position			: 'absolute'
					, top				: '50%'
					, left				: parseInt( $('.javo_somw_panel').outerWidth() ) + "px"
				});
			});

			this.infoWindo = new InfoBubble({
				minWidth:362
				, minHeight:180
				, overflow:true
				, shadowStyle: 1
				, padding: 5
				, borderRadius: 10
				, arrowSize: 20
				, borderWidth: 1
				, disableAutoPan: false
				, hideCloseButton: true
				, arrowPosition: 50
				, arrowStyle: 0
			});

		}
	};
	javo_map.init();
	window.javo_map = javo_map;
	$(window).on('resize', function(){ javo_map.resize(); });

	$('.container.footer-top').remove();

});
</script>


<?php
get_footer();