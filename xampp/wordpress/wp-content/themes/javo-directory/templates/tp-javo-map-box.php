<?php
/* Template Name: Map (Box Style) */

$javo_query						= new javo_Array( $_POST );
$javo_map_query					= new javo_Array( $javo_query->get('filter', Array()));

$javo_this_map_label			= Array(
	'category'					=> $javo_map_query->get('item_category', null) != null ? get_term( $javo_map_query->get('item_category'), 'item_category' )->name: __('All Category', 'javo_fr')
	, 'location'				=> $javo_map_query->get('item_location', null) != null ? get_term( $javo_map_query->get('item_location'), 'item_location' )->name: __('All Location', 'javo_fr')
);









$mail_alert_msg = Array(
	'to_null_msg'=> __('Please, to email adress.', 'javo_fr')
	, 'from_null_msg'=> __('Please, from email adress.', 'javo_fr')
	, 'subject_null_msg'=> __('Please, insert name.', 'javo_fr')
	, 'content_null_msg'=> __('Please, insert content', 'javo_fr')
	, 'failMsg'=> __('Sorry, mail send failed.', 'javo_fr')
	, 'successMsg'=> __('Successfully !', 'javo_fr')
	, 'confirmMsg'=> __('Send this email ?', 'javo_fr')
);

get_header();?>
<script type="text/template" id="javo_map_this_loading">
	<h2 class="text-center">
		<img src="<?php echo JAVO_IMG_DIR.'/loading_6.gif';?>" width='50%'>
	</h2>
</script>
<div class="javo_mhome_wrap">
	<div class="javo_mhome_sidebar_wrap">
		<div class="javo-mhome-sidebar-onoff"></div>
		<div class="javo_mhome_sidebar">
			<?php
			if( is_user_logged_in() ){
				_e('Please Login', 'javo_fr');			
			}else{
				_e('Please Login....', 'javo_fr');
			};?>

		</div>
	</div>
	<!-- MAP Area -->
	<div class="javo_mhome_map_area"></div>
	<div class="category-menu-bar"></div>
	
	<!-- Right Sidebar Content -->
	<div class="javo_mhome_map_lists">
		<!-- Right Sidebar Inner -->
		<!-- Control & Filter Area -->
		<div class="main-map-search-wrap">
			<div class="row">
			<div class="col-md-3">

				<div class="sel-box">
					<div class="sel-container">
						<i class="sel-arraow"></i>
						<input type="text" readonly value="<?php echo $javo_this_map_label['category']; ?>">
						<input type="hidden" name="type" value="<?php echo $javo_map_query->get('item_category', null); ?>" data-filter data-category="item_category">
					</div><!-- /.sel-container -->
					<div class="sel-content">
						<ul>
							<li value="" data-filter><?php _e('All Category', 'javo_fr');?></li>
							<?php
							$javo_get_this_terms = get_terms('item_category', Array('hide_empty'=>0));
							foreach($javo_get_this_terms as $term){
								printf('<li data-filter value="%s">%s</li>', $term->term_id, $term->name);
							}; ?>
						</ul>
					</div><!-- /.sel-content -->
				</div><!-- /.sel-box -->

			</div>
			<div class="col-md-3">

				<div class="sel-box">
					<div class="sel-container">
						<i class="sel-arraow"></i>
						<input type="text" readonly value="<?php echo $javo_this_map_label['location']; ?>">
						<input type="hidden" name="type" value="<?php echo $javo_map_query->get('item_location', null); ?>" data-filter data-category="item_location">
					</div><!-- /.sel-container -->
					<div class="sel-content">
						<ul>
							<li value="" data-filter><?php _e('All Location', 'javo_fr');?></li>
							<?php
							$javo_get_this_terms = get_terms('item_location', Array('hide_empty'=>0));
							foreach($javo_get_this_terms as $term){
								printf('<li value="%s" data-filter>%s</li>', $term->term_id, $term->name);
							}; ?>
						</ul>
					</div><!-- /.sel-content -->
				</div><!-- /.sel-box -->

			</div>
			<div class="col-md-3">
				<div class="sel-box">
					<div class="sel-container">
						<i class="sel-arraow"></i>
						<input type="text" readonly value="<?php _e("Views","javo_fr"); ?>">
						<input type="hidden" name="type">
					</div><!-- /.sel-container -->
					<div class="sel-content">
						<ul>
							<li data-javo-hmap-ppp data-value='' value=''><?php _e('Views' ,'javo_fr');?></li>
							<li data-javo-hmap-ppp data-value='5' value='5'><?php _e('5 views' ,'javo_fr');?></li>
							<li data-javo-hmap-ppp data-value='10' value='10'><?php _e('10 views' ,'javo_fr');?></li>
							<li data-javo-hmap-ppp data-value='15' value='15'><?php _e('15 views' ,'javo_fr');?></li>
							<li data-javo-hmap-ppp data-value='30' value='30'><?php _e('30 views' ,'javo_fr');?></li>
							<li data-javo-hmap-ppp data-value='60' value='60'><?php _e('60 views' ,'javo_fr');?></li>
							<li data-javo-hmap-ppp data-value='100' value='100'><?php _e('100 views' ,'javo_fr');?></li>
						</ul>
					</div><!-- /.sel-content -->
				</div><!-- /.sel-box -->
			</div>
			<div class="col-md-3">
				<div class="row">
					<div class="col-md-8">
						<div class="btn-group btn-group-justified" data-toggle="buttons">
							<label class="btn btn-default btn-sm active" id="grid">
								<input type="radio" name="btn_viewtype_switch" checked>
								<i class="glyphicon glyphicon-th-list"></i>
							</label>
							<label class="btn btn-default btn-sm" id="list">
								<input type="radio" name="btn_viewtype_switch">
								<i class="fa fa-list-ul"></i>
							</label>						
						</div>
						
					</div>
					<div class="col-md-4">
						<div class="btn btn-default btn-sm" data-javo-hmap-sort><span class="glyphicon glyphicon-open"></span></div>							
					</div>
				</div>
			</div>		





			</div><!-- row-->
		</div> <!-- main-map-search-wrap -->
		<!-- Control & Filter Area Close -->



		<input type="hidden" name="javo_is_search" value="<?php echo isset( $_POST['filter'] );?>">





		<!-- Ajax Results Output Element-->
		<div class="javo_mhome_map_output item-list-page-wrap"></div>

	</div><!-- Right Sidebar Content Close -->

</div>

<script type="text/javascript">
jQuery(function($){
	"use strict";
	var javo_map = {
		root:null
		, map:null
		, target:null
		, infoWindo:null
		, sidebar:null
		, remote:{}
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
						, zoomControlOptions: {
							position: google.maps.ControlPosition.RIGHT_BOTTOM
							, style: google.maps.ZoomControlStyle.SMALL

						 }
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
			, ajax_favorite_options:{
				url: null
				, type: 'post'
				, data:{
					filter:{}
				}, dataType: 'json'
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
			var markers = this.target.gmap3({ get:{ name:"marker", all:true } });
			this.infoWindo.close();
			$(markers).each(function(k, v){
				v.setAnimation(null);			
			});

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
		, ajax_favorite:function(){
			var $object = this;

			$object.sidebar = $('.javo_mhome_sidebar');
			$object.sidebar.html( $('#javo_map_this_loading').html() );
			this.options.ajax_favorite_options.url = this.options.ajax_options.url;
			this.options.ajax_favorite_options.data = {};
			this.options.ajax_favorite_options.data.action = 'get_hmap_favorite_lists';
			this.options.ajax_favorite_options.error = function(e){};
			this.options.ajax_favorite_options.success = function(d){
				
				$object.sidebar.html( d.html );
			};
			jQuery.ajax(this.options.ajax_favorite_options);
		
		}
		, marker_clear:function(){
			this.target.gmap3({ clear:{ name:"marker" }});
		
		}
		, resize:function(){
			var winX = $(window).width();
			var winY = $('header.main').outerHeight(true) + $('#wpadminbar').outerHeight(true);

			$('.javo_mhome_map_lists').css( 'top', winY);
			$('.javo_mhome_map_output').css( 'marginTop', $('.main-map-search-wrap').outerHeight(true) );
			// Setup Map Height
			this.target.height( $(window).height() - winY );

			if( winX > 1500 ){
				$('.body-content').find('.item').addClass('col-lg-4');
			}else{
				$('.body-content').find('.item').removeClass('col-lg-4');
			};

		}
		, run:function(){

			var $object = this;
			var markers = new Array();
			var avg = new google.maps.LatLngBounds();

			this.options.ajax_options.success = function(d){

				// Get Contents
				$('.javo_mhome_map_output').html( d.html );

				// Clear Map
				$object.marker_clear();
				$object.infoWindo.close();

				// 
				$.each( d.markers, function(k, v){

					// Create Markers 
					markers.push({
						latLng: new google.maps.LatLng( v.lat, v.lng )
						, options:{ animation:google.maps.Animation.DROP, icon:v.icon }
						, id: 'mid_' + k
						, data: v.content
					});

					// Geo Location
					avg.extend( new google.maps.LatLng(v.lat, v.lng) );
				});

				// Set Marker Values
				$object.target.gmap3({ 
					map:{ events:{ 
						click:function(){ $object.map_clear(); }}
					}, marker:{ 
						values: markers
						, events:{
							click:function(m, e, c){
								$object.map_clear();
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
				}else{			
				
				}
				$object.refresh();
				$object.resize();
			};

			this.options.ajax_options.error = function(e){
				var jv_alert = "<div class='jv_alert'>";
				jv_alert += "Error : ";
				jv_alert += e.state();
				jv_alert += "<br>d</div>";

				$(jv_alert).appendTo( $object.target );

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
			};
			$.ajax( this.options.ajax_options );
		}
		, refresh:function(){
			$('.javo-rating-registed-score').each(function(k,v){
				$(this).raty({					
					starOff: '<?php echo JAVO_IMG_DIR?>/star-off-s.png'
					, starOn: '<?php echo JAVO_IMG_DIR?>/star-on-s.png'
					, starHalf: '<?php echo JAVO_IMG_DIR?>/star-half-s.png'
					, half: true
					, readOnly: true
					, score: $(this).data('score')
				}).css('width', '');
			});		
		
		}
		, events:function(){
			var $object = this;
			$(document).on('change', 'input', function(){
				return false;

				$object.options.ajax_options.data.filter = {};
				$('input[data-filter]').each(function(k, v){
					var $this = $(this);
					$object.options.ajax_options.data.filter[ $this.data('category')] = $this.val();
				});

				if( typeof( $(this).data('filter') ) != 'undefined' ){
					$object.options.ajax_options.data.current = 1;
				};
				$object.run();
			
			}).on('click', 'li[data-filter]', function(){
				$object.options.ajax_options.data.filter = {};
				$('input[data-filter]').each(function(k, v){




					var $this = $(this);
					$object.options.ajax_options.data.filter[ $this.data('category')] = $this.val();
				});

				if( typeof( $(this).data('filter') ) != 'undefined' ){
					$object.options.ajax_options.data.current = 1;
				};
				$object.run();

			
			
			
			}).on('click', 'div[data-javo-hmap-sort]', function(){
				if( $(this).hasClass('asc') ){

					$object.options.ajax_options.data.order = 'desc';
					$(this)
						.removeClass('asc')
						.find('span').attr('class', 'glyphicon glyphicon-open');
				
				}else{

					$object.options.ajax_options.data.order = 'asc';
					$(this)
						.addClass('asc')						
						.find('span').attr('class', 'glyphicon glyphicon-save');
				}
				
				$object.run();

			}).on('click', 'li[data-javo-hmap-ppp]', function(){

				$object.options.ajax_options.data.ppp = $(this).data('value');
				$object.run();
			
			}).on('change', 'select[data-column-remote]', function(){

				$object.options.ajax_options.data.column = $(this).val();
				$object.run();
			
			}).on('click', '.javo-hmap-marker-trigger', function(){
				var $this = $(this);
				$object.target.gmap3({ 
					get:{ 
							  name:"marker"
						,		id: $this.data('id')
						, callback: function(m){
							google.maps.event.trigger(m, 'click');
						}
					}
				});
			}).on('click', '.javo-hmap-marker-trigger', function(){
				/*
				if( !$(this).hasClass('active')){
					$object.ajax_slider(this);
					$(this).addClass('active');
				};
				*/
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
					$object.ajax_favorite();
				}
			}).on('click', '#contact_submit', function(){
				$_this_form =  $(this).closest('form');
				$object.options.javo_mail.to = $_this_form.find('input[name="contact_this_from"]').val();
				$.javo_mail( $object.options.javo_mail );
			
			});
		}
		, side_move: function(){
			var $this = $('.javo_mhome_sidebar');
			$this.clearQueue().animate({ marginLeft: 0 }, 300);

			$('.javo_mhome_wrap').clearQueue().animate({
				paddingLeft: $this.outerWidth() + 'px'
			}, 300);
		}
		, side_out: function(){
			var $this = $('.javo_mhome_sidebar');
			$this.clearQueue().animate({
				marginLeft: ( -$this.outerWidth()) + 'px'
			}, 300);
			$('.javo_mhome_wrap').animate({ paddingLeft: 0 }, 300);		
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
			this.target = $('.javo_mhome_map_area');
			this.target.gmap3( this.options.map_init );

			// Initalize DOC
			$('body').css('overflow', 'hidden');

			// Initialize Variables
			this.map = this.target.gmap3('get');

			// Settings
			this.options.ajax_options.url = "<?php echo admin_url('admin-ajax.php');?>";
			this.options.ajax_options.data.action = "get_hmap";
			this.options.ajax_options.data.post_type = "item";
			this.options.ajax_options.data.ppp = 10;
			this.options.ajax_options.data.listing_type = 'page';

			// Filter Examp
			// this.options.ajax_options.data.filter = { taxomony_name : term_id };

			// Initialize Layout
			this.resize();

			// Event Handlers
			this.events();

			if( parseInt( $('[name="javo_is_search"]').val() ) > 0 ){
				//$('li[data-filter]').trigger('click');




			}else{
				this.run();
			}


			this.remote.buttons = [
				{
					icon:'icon-display'
					, text: 'IT'
					, className: null
				},
				{
					icon:'icon-sound'
					, text: 'Audio'
					, className: null
				},
				{
					icon:'icon-study'
					, text: 'Study'
					, className: null
				},
				{
					icon:'icon-food'
					, text: 'Food'
					, className: null
				},
				{
					icon:'icon-truck'
					, text: 'Post'
					, className: null
				},
						{
					icon:'icon-vynil'
					, text: 'Music'
					, className: null
				},
				{
					icon:'icon-phone'
					, text: 'Telecom'
					, className: null
				},
				{
					icon:'icon-camera'
					, text: 'Pictures'
					, className: null
				},
				{
					icon:'icon-shop'
					, text: 'Shop'
					, className: null
				}
			];


			$(window).load(function(){

				$('.javo_mhome_sidebar')
					.removeClass('hidden')
					.css({
						marginLeft: ( -$('.javo_mhome_sidebar').outerWidth(true)) + 'px'
						, paddingTop: javo_map.variable.top_offset + 'px'
					});
			});
			
			this.infoWindo = new InfoBubble({
				minWidth:362
				, minHeight:225
				, overflow:true
				, shadowStyle: 1
				, padding: 5
				, borderRadius: 10
				, arrowSize: 20
				, borderWidth: 1
				, disableAutoPan: false
				, hideCloseButton: false
				, arrowPosition: 50
				, arrowStyle: 0
			});





















			for( var i in this.remote.buttons ){
				var str = '<div class="javo-map-remote-item">';
				var icon = this.remote.buttons[i].icon;
				var label = this.remote.buttons[i].text;
				str += '<div class="text-center"><span class="' + icon + '"></span></div>';
				str += '<div class="text-center">' + label + '</div>';
				str += '</div>';
				$('.javo-map-remote-panel').append(str);
			};
			$('.javo-map-remote-panel').css('height', $('.javo-map-remote-item').outerHeight() );
			var javo_map_remote_items_w = $('.javo-map-remote-item').length <= 3 ? $('.javo-map-remote-item').length : 3;
			$('.javo-map-remote-panel').hover(function(){
				$(this).animate({
					width: javo_map_remote_items_w * $('.javo-map-remote-item').outerWidth() + 2
				}, 300, function(){
					$(this).css('height', 'auto');
				
				});
			}, function(){
				$(this).animate({
					width: $('.javo-map-remote-item').outerWidth() + 2
					, height: $('.javo-map-remote-item').outerHeight()
				}, 40);

			});
		}
	};
	javo_map.init();
	window.javo_map = javo_map;
	$(window).on('resize', function(){ javo_map.resize(); });

	$('.container.footer-top').remove();

});
</script>


<?php get_footer();