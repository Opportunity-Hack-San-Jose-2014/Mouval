<?php
class javo_events_gallery{
	public function __construct(){
		add_shortcode("javo_event_gallery", Array($this, "javo_events_gallery_function"));
	}
	public function javo_events_gallery_function($atts=Array(), $content=""){
		javo_get_script("jquery.mixitup.min.js", "mixitup", "2.1.4");
		wp_enqueue_style( 'javo-events-gallery-css', JAVO_THEME_DIR."/library/shortcodes/events-gallery/events-gallery.css", '1.0' );
		extract(shortcode_atts(Array(
			'title'=>''
			, 'sub_title'=>''
			, 'title_text_color'=>'#000'
			, 'sub_title_text_color'=>'#000'
			, 'line_color'=> '#fff'
		), $atts));
		$javo_this_gallery_args = Array(
			"post_type"=> 'jv_events'
			, "post_status"=> 'publish'
			, "posts_per_page"=> -1
		);
		$javo_events_gallery_posts = new WP_Query($javo_this_gallery_args);
		$javo_events_gallery_terms = get_terms("jv_events_category", Array('hide_empty'=>false));
		ob_start();
		echo apply_filters('javo_shortcode_title', $title, $sub_title, Array('title'=>'color:'.$title_text_color.';', 'subtitle'=>'color:'.$sub_title_text_color.';', 'line'=>'border-color:'.$line_color.';'));?>
		<div id="javo-events-gall">
			<div class="javo-events-gallery-navi">
				<button class="filter" data-filter="all"><?php _e('ALL', 'javo_fr');?></button>
				<?php
				foreach($javo_events_gallery_terms as $term){
					printf('<button class="filter gallery-terms-btn" data-filter=".javo-events-gallery-term-%s">%s</button>'
						, $term->name
						, strtoupper($term->name)
					);
				};?>
			</div>
			<div class="javo-events-gallery row">
				<?php
				if( $javo_events_gallery_posts->have_posts() ){
					while( $javo_events_gallery_posts->have_posts() ){
						$javo_events_gallery_posts->the_post();
						$javo_meta_query				= new javo_GET_META( get_the_ID() );
						$javo_this_parent_permalink		= get_permalink( get_post_meta( get_the_ID(), 'parent_post_id', true ) );
						?>
						<div class="col-md-3 mix javo-events-gallery-term-<?php echo $javo_meta_query->cat('jv_events_category', "all", true);?>">
							<a href="<?php echo $javo_this_parent_permalink;?>">
								<?php
								if( has_post_thumbnail() ){
									echo get_the_post_thumbnail(get_the_ID(), 'javo-box');
								};?>
							</a>
							<div class="javo-events-gallery-term-content"></div>
							<div class="javo-events-gallery-term-content-title"><span><?php echo javo_str_cut( get_the_title(), 25);?></span></div>

							<?php if( get_post_meta( get_the_ID(), 'brand', true) ){ ?>
								<div class="event-tag custom-bg-color-setting">
									<?php echo apply_filters('javo_offer_brand_tag', get_post_meta( get_the_ID(), 'brand', true));?>
								</div>
							<?php }; ?>
						</div>
						<?php
					}; // End While
				}else{
					_e('No Found Items.', 'javo_fr');
				}; // End If
				wp_reset_query(); ?>
				<div class="gap"></div>
				<div class="gap"></div>
			</div>
		</div>
		<script type="text/javascript">
		jQuery(function($){
			"use strict";
			$('.javo-events-gallery').mixItUp();
		});
		</script>
	<?php 
		return ob_get_clean();
	}
}
new javo_events_gallery;