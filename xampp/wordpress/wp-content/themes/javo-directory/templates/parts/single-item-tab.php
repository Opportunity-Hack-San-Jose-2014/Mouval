<?php
global $javo_custom_field
	, $javo_tso
	, $javo_this_single_page_type
	, $javo_animation_fixed;
$javo_animation_fixed = $javo_this_single_page_type == 'item-tab'? 'loaded': '';
get_header();
if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
     $large_image_url				= wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
} 
if(have_posts()): the_post();
	$post_id = get_the_ID();
	$javo_sidebar_option			= get_post_meta($post_id, "javo_sidebar_type", true);
	$javo_this_author				= get_userdata($post->post_author);
	$javo_this_author_avatar_id		= get_user_meta($javo_this_author->ID, 'avatar', true);
	$javo_this_featured_image_id	= get_post_thumbnail_id($post_id);
	$javo_this_featured_image_meta	= wp_get_attachment_image_src($javo_this_featured_image_id, 'thumbnail');
	$javo_this_featured_image_src	= $javo_this_featured_image_meta[0];
?>
<div class="single-item-tab">
	<div class="single-item-tab-feature-bg" style="background:url('<?php echo  $large_image_url[0]; ?>') no-repeat center center fixed;  -webkit-background-size: cover;  -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-attachment: fixed;">
		<div class="javo-single-item-tab-map-area hidden"></div>
		<div class="single-item-tab-bg">
			<div class="container captions">
				<div class="header-inner">
					<div class="item-bg-left pull-left text-left">
						<h1 class="uppercase"><?php the_title();?></h1>
					</div>
					<div class="item-bg-right pull-right text-center">
						<div class="author-info javo-single-itemp-tab-intro-switch" data-featured="<?php echo $javo_this_featured_image_src;?>" data-map="<?php echo JAVO_THEME_DIR;?>/assets/images/icon/icon-location-red.png"><img class="img-circle" src="<?php echo JAVO_THEME_DIR;?>/assets/images/icon/icon-location-red.png" style="cursor:pointer;"></div>

					</div> 
					<div class="clearfix"></div>
				</div> <!-- header-inner -->
			</div> <!-- container -->
		</div> <!-- single-item-tab-bg -->
		<div class="bg-dot-black"></div> <!-- bg-dot-black -->

	</div> <!-- single-item-tab-feature-bg -->

	<?php
	$javo_this_terms = wp_get_post_terms($post_id, 'item_category');
	$javo_this_posts_return = Array();
	if(!empty($javo_this_terms)){
		$javo_this_category_posts_args = Array(
			'post_type'			=> 'item'
			, 'post_status'		=> 'publish'
			, 'posts_per_page'	=> 30
			, 'exclude'			=> Array( get_the_ID() )
			, 'tax_query'		=> Array(
				Array(
					'taxonomy'	=> 'item_category'
					, 'field'	=> 'term_id'
					, 'terms'	=> $javo_this_terms[0]->term_id
				)
			)
		);
		$javo_this_category_posts = new WP_Query( $javo_this_category_posts_args );
		if( $javo_this_category_posts->have_posts() ){
			while( $javo_this_category_posts->have_posts() ){
				$javo_this_category_posts->the_post();
				$javo_this_latlng						= @unserialize( get_post_meta( get_the_ID(), 'latlng', true ) );
				$javo_this_posts_return[get_the_ID()]	= $javo_this_latlng;
				$javo_meta_query						= new javo_get_meta( get_the_ID() );
				?>
				<script type="text/template" id="javo_map_tmp_<?php the_ID();?>">
					<div class="javo_somw_info panel">
						<div class="des">
							<h5><?php echo javo_str_cut( get_the_title(), 30);?></h5>
							<ul class="list-unstyled">
								<li><?php echo $javo_meta_query->get('phone');?></li>
								<li><?php echo $javo_meta_query->get('mobile');?></li>
								<li><?php echo $javo_meta_query->get('website');?></li>
								<li><?php echo $javo_meta_query->get('email');?></li>
							</ul>
							<hr />
							<a class="btn btn-dark javo-this-go-more" href="<?php the_permalink();?>"><?php _e('More', 'javo_fr');?></a>
						</div> <!-- des -->

						<div class="pics">
							<div class="thumb">
								<a href="<?php the_permalink();?>"><?php the_post_thumbnail('javo-map-thumbnail'); ?></a>
							</div> <!-- thumb -->
							<div class="img-in-text"><?php echo $javo_meta_query->cat('item_category', 'No Category');?></div>
							<div class="javo-left-overlay">
								<div class="javo-txt-meta-area"><?php echo $javo_meta_query->cat('item_location', 'No Location');?></div>
								<div class="corner-wrap">
									<div class="corner"></div>
									<div class="corner-background"></div>
								</div> <!-- corner-wrap -->
							</div> <!-- javo-left-overlay -->
						</div> <!-- pic -->
					</div> <!-- javo_somw_info -->
				</script>
				<?php
			};
		};
		wp_reset_query();
		printf("<input type='hidden' name='javo-this-term-posts-latlng' value='%s'>", json_encode($javo_this_posts_return));
	};?>

	<div class="container">
		<?php
		switch($javo_sidebar_option){
		case "left":
			?>
			<div class="row">
				<?php get_sidebar();?>
				<div class="col-md-9 pp-single-content">
					<?php get_template_part('templates/parts/single', 'item-tab-inner'); ?>
				</div>
			</div>
			<?php
		break;
		case "full":
			?>
			<div class="row">
				<div class="col-md-12">
					<?php get_template_part('templates/parts/single', 'item-tab-inner'); ?>
				</div>
			</div>
			<?php
		break;
		case "right":
		default:
			?>
			<div class="row">
				<div class="col-md-9 pp-single-content">
					<?php get_template_part('templates/parts/single', 'item-tab-inner'); ?>
				</div>
				<?php get_sidebar();?>
			</div>
			<?php
		};?>
	</div> <!-- container -->
</div> <!-- single-item-tab -->
<?php
endif;


$javo_this_latlng = (Array)@unserialize( get_post_meta( get_the_ID(), 'latlng', true ) );
$javo_latlng_meta = new javo_ARRAY( $javo_this_latlng );?>








<script type="text/javascript">
jQuery(function($){
	"use strict";
	var javo_stm = {
		latLng: new google.maps.LatLng("<?php echo $javo_latlng_meta->get('lat', 0);?>", "<?php echo $javo_latlng_meta->get('lng', 0);?>")
		, post_id: "<?php the_ID();?>"
		, map_style: null
		, infoBubble: null
		, options:{
			config:{
				location:{
					map_height: 500
				}
				, header:{				
					map_height: $('.single-item-tab-feature-bg').outerHeight()
				}
			}
			, map_container:{
				header:				$('.javo-single-item-tab-map-area')
				, location:			$('.javo-single-map-area')
			}
			, map_init:{
				map:{
					options:{
						zoom:15,
						mapTypeIds: [ google.maps.MapTypeId.ROADMAP, 'map_style' ],
						mapTypeControl: false,
						navigationControl: true,
						scrollwheel: false,
						streetViewControl: true
					}
				}
				, marker:{options:{}, events:{}}
			}
			, streetview:{
				streetviewpanorama:{
					options:{
						container: null
						, opts:{
							position: null
							,pov: { heading: 34, pitch:10, zoom:1 }
						}
					}
				}
			}
			, info:{
				minWidth:362
				, minHeight:170
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
			}
			, map_style:[
				{
					stylers: [
						{ hue: "<?php echo $javo_tso->get('total_button_color', '#f00');?>" },
						{ saturation: -20 }
					]
				},{
					featureType: "road",
					elementType: "geometry",
					stylers: [
						{ lightness: 100 },
						{ visibility: "simplified" }
					]
				},{
					featureType: "road",
					elementType: "labels",
					stylers: [
						{ visibility: "off" }
					]
				}
			]
		}
		, init:function(){
			this.map_style = new google.maps.StyledMapType( this.options.map_style, {name:'Javo Single Item Map'});
			this.infoBubble = new InfoBubble( this.options.info );

			this.location.init();
			this.header.init();
		}
		, location:{
			map: null
			, init:function(){
				javo_stm.options.map_init.map.options.center	= javo_stm.latLng;
				javo_stm.options.map_init.marker.latLng			= javo_stm.latLng;
				javo_stm.options.map_container.location
					.css('minHeight', javo_stm.options.config.location.map_height)
					.gmap3( javo_stm.options.map_init );

				this.map = javo_stm.options.map_container.location.gmap3('get');
				this.map.mapTypes.set('map_style', javo_stm.map_style);
				this.map.setMapTypeId('map_style');
				this.events();
			}
			, events:function(){
				var $this = this;
				$(document)
					.on('click', 'a[href="#single-tab-location"]', function(){
						$this.resize();
						$this.map.setCenter( javo_stm.latLng );
						$('.javo-single-itemp-tab-intro-switch').trigger('click');
					});
			}
			, resize:function(){
				javo_stm.options.map_container.location.gmap3({ trigger:'resize' });
			}
		}
		, header:{
			map: null
			, markers: JSON.parse( $('input[name="javo-this-term-posts-latlng"]').val() )
			, el: null
			, init:function(){
				var bound = new google.maps.LatLngBounds();
				var marker_values = new Array();

				$.each(this.markers, function(i, k){
					marker_values.push({ id: '#javo_map_tmp_' + i, latLng:[k.lat, k.lng], options:{ icon:'<?php echo JAVO_THEME_DIR;?>/assets/images/icon-single-item-other-marker.png' } });	
					bound.extend( new google.maps.LatLng(k.lat, k.lng));
				});
				marker_values.push({ id:'#javo_map_tmp_' + javo_stm.post_id, latLng:javo_stm.latLng, options:{zIndex:9999, icon:'http://javothemes.com/directory/wp-content/uploads/2014/07/map_iconred.png' } });

				javo_stm.options.map_init.map.options.center	= javo_stm.latLng;
				javo_stm.options.map_init.marker.values			= marker_values;
				javo_stm.options.map_init.marker.events.click	= function(m, e, c){
					var $this_map = $(this).gmap3('get');
					javo_stm.infoBubble.setContent( $( c.id ).html() );	
					javo_stm.infoBubble.open($this_map, m);
					$this_map.setCenter( m.getPosition() );
				}
				javo_stm.options.map_container.header.gmap3( javo_stm.options.map_init );
				this.el		= javo_stm.options.map_container.header;
				this.map	= this.el.gmap3('get');

				this.map.mapTypes.set('map_style', javo_stm.map_style);
				this.map.setMapTypeId('map_style');
				this.map.fitBounds(bound);
				
				this.events();
			}
			, events: function(){
				var $this		= this;
				$(document)
					.on('click', '.javo-single-itemp-tab-intro-switch', function(){
						var _this = $(this);
						if( $this.el.hasClass('active') ){
							$this.el
								.clearQueue()
								.animate({ left: -($(window).width()) + 'px' }, 500)					
								.removeClass('active');
							_this.find('img').attr('src', _this.data('map'));
							$('#header-one-line').children('.navbar').css( 'background-color', '');
						}else{					
							$this.el
								.clearQueue()
								.animate({ left: 0 + 'px'}, 500)					
								.addClass('active');
								$this.el.gmap3({trigger:'resize'});
							_this.find('img').attr('src', _this.data('featured'));
							$('#header-one-line').children('.navbar').css( 'background-color', 'rgba(45, 45, 45, .2)');							
						};
					});
				$(window)
					.on('resize', function(){
						$this.el.removeClass('hidden').css('height', javo_stm.options.config.header.map_height);
						if( $this.el.hasClass('active') ){
							$this.el.css('left', 0 + 'px');
						}else{					
							$this.el.css('left', -($(this).width()) + 'px');
						};			
					}).on('scroll', function(){

						if( $this.el.hasClass('active') ){
							if( $('#header-one-line').children('.navbar').hasClass('affix') ){
								$('#header-one-line').children('.navbar').css( 'background-color', '');
							}else{
								$('#header-one-line').children('.navbar').css( 'background-color', 'rgba(45, 45, 45, .2)');							
							};
						}else{							
							$('#header-one-line').children('.navbar').css( 'background-color', '');							
						};					
					});
			}
		}
	};
	javo_stm.init();
	$(window).trigger('resize');
});
</script>

<?php
get_footer();