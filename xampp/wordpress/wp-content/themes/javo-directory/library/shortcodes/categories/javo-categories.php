<?php
add_shortcode('javo_categories','categories_function');

function categories_function($atts, $content=''){
	global $javo_tso;
	extract(shortcode_atts(Array(
		'title'=>''
		, 'sub_title'=>''
		, 'title_text_color'=>'#000'
		, 'sub_title_text_color'=>'#000'
		, 'line_color'			=>'#fff'
		, 'oneline'=> 6
	),$atts));

	wp_enqueue_style( 'javo-carousel-feedback-css', JAVO_THEME_DIR.'/library/shortcodes/categories/javo-categories.css', '1.0' );	
	ob_start();?>
	<?php echo apply_filters('javo_shortcode_title', $title, $sub_title, Array('title'=>'color:'.$title_text_color.';', 'subtitle'=>'color:'.$sub_title_text_color.';', 'line'=>'border-color:'.$line_color.';'));?>	
	<div class="categories-imgs text-center">
		<div class="inline-block">
			<?php
			$post_type='item';
			$javo_this_categories = get_terms('item_category', Array('hide_empty'=>0));
			if(!empty($javo_this_categories)){
				$i=0;
				foreach($javo_this_categories as $term){
					$i++;
					$featured = get_option( 'javo_item_category_'.$term->term_id.'_featured', '' );
					printf('<a style="color:%s;" data-javo-category="%s"><img src="%s" style="width:300px;height:200px;"><span>%s</span><div class="javo-categories-inner-meta"><b>%s</b></div><div class="categories-wrap-shadow"></div></a>', $title_text_color, $term->term_id, $featured, $term->name, javo_get_count_in_taxonomy( $term->term_id ));
					if( $i % $oneline == 0){ echo "<div class='clearfix'></div>"; };
				};

			};

			
			
			
			?>
		</div>
	</div><!-- categories-imgs -->
	<form method="post" action="<?php echo get_permalink($javo_tso->get('page_item_result'));?>">
		<input type="hidden" id="javo-item-category-filter" name="filter[item_category]" value="">

	</form>
	<script type="text/javascript">
	jQuery(function($){
		"use strict";
		$('body').on('click', 'a[data-javo-category]', function(){

			$('#javo-item-category-filter').val( $(this).data('javo-category') ).closest('form').submit();
		});
	});
	</script>
	<?php
	$content = ob_get_clean();
	return $content;
}