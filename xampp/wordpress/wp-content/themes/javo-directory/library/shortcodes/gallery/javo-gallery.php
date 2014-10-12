<?php
class javo_gallery{
	public function __construct(){
		add_shortcode("javo_gallery", Array($this, "javo_gallery_function"));
	}
	public function javo_gallery_function($atts=Array(), $content=""){
		javo_get_script("jquery.mixitup.min.js", "mixitup", "2.1.4");
		wp_enqueue_style( 'javo-gallery-css', JAVO_THEME_DIR."/library/shortcodes/gallery/javo-gallery.css");
		extract(shortcode_atts(Array(
			'title'=>''
			, 'sub_title'=>''
			, 'title_text_color'=>'#000'
			, 'sub_title_text_color'=>'#000'
			, 'line_color'=> '#fff'
		), $atts));
		$javo_this_gallery_args = Array(
			"post_type"=> 'item'
			, "post_status"=> 'publish'
			, "posts_per_page"=> -1
		);
		$javo_gallery_posts = new WP_Query($javo_this_gallery_args);
		$javo_gallery_terms = get_terms("item_category", Array('hide_empty'=>false));
		wp_enqueue_scripts('jQuery-Rating');
		ob_start();
		echo apply_filters('javo_shortcode_title', $title, $sub_title, Array('title'=>'color:'.$title_text_color.';', 'subtitle'=>'color:'.$sub_title_text_color.';', 'line'=>'border-color:'.$line_color.';'));?>
		<div id="javo-gall">
			<div class="javo-gallery-navi">
				<button class="filter" data-filter="all"><?php _e('ALL', 'javo_fr');?></button>
				<?php
				foreach($javo_gallery_terms as $term){
					printf('<button class="filter gallery-terms-btn" data-filter=".javo-gallery-term-%s">%s</button>'
						, $term->term_id
						, strtoupper($term->name)
					);
				};?>
			</div>
			<div class="javo-gallery">
				<?php
				if( $javo_gallery_posts->have_posts() ){
					while( $javo_gallery_posts->have_posts() ){
						$javo_gallery_posts->the_post();
						$javo_pm = new javo_GET_META( get_the_ID() );
						?>
						<div class="mix javo-gallery-term-<?php echo $javo_pm->cat('item_category', "all", true, true);?>">
						
						<div class="javo-gallery-wrap">
							<a href="<?php the_permalink();?>">
								<div class="javo-gallery-shadow"></div>
								<?php echo get_the_post_thumbnail(get_the_ID(), 'javo-box', Array('class'=> 'img-responsive'));?>
							
								<div class="javo-gallery-term-content-title">
									<?php echo get_the_title(get_the_ID()); ?>
									<!-- <span class="glyphicon glyphicon-th-list"></span> --> 
								</div>
								<div class="javo-gallery-term-content-inform">
									<div class="javo-gallery-term-content-category">
										<?php echo $javo_pm->cat('item_category','No Category');?>
									</div><!-- javo-gallery-term-content-category -->
									<div class="javo-gallery-term-content-rating">
										<?php printf('<div class="javo-gallery-on-hover-rating" data-score="%.1f"></div>', (float) get_post_meta( get_the_ID(), 'rating_average', true));?>
									</div> <!-- javo-gallery-term-content-rating -->
								</div> <!-- javo-gallery-trem-content-inform -->
							</a>			
						</div><!-- wrap -->
						<div class="javo-left-overlay bg-red">
							<div class="javo-txt-meta-area admin-color-setting"><i class="glyphicon glyphicon-map-marker"></i>&nbsp;<?php echo $javo_pm->cat('item_location', "No Location", true);?></div> <!-- javo-txt-meta-area -->
							<div class="corner-wrap">
								<div class="corner admin-color-setting"></div>
								<div class="corner-background admin-color-setting"></div>
							</div> <!-- corner-wrap -->
						</div>
						</div> <!-- javo-gallery-term -->

						<?php
					}; // End While
				}else{
					_e('No Found Items.', 'javo_fr');
				}; // End If
				wp_reset_query(); ?>
			</div>
		</div>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			"use strict";
			$('.javo-gallery').mixItUp();
			jQuery(function($){
				$('.javo-gallery-on-hover-rating').each(function(){
					$(this).raty({
						starOff: '<?php echo JAVO_IMG_DIR?>/star-off-s.png'
						, starOn: '<?php echo JAVO_IMG_DIR?>/star-on-s.png'
						, starHalf: '<?php echo JAVO_IMG_DIR?>/star-half-s.png'
						, half: true
						, readOnly: true
						, score: $(this).data('score')
					}).css('width', '');
				
				});
				$(document).on('click', 'button.filter', function(){
					$(window).trigger('resize');
				
				
				});
			
			});
		});
		</script>
	<?php 
		return ob_get_clean();
	}
}
new javo_gallery;