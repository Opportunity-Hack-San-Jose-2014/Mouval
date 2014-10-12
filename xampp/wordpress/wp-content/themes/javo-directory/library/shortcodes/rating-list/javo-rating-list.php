<?php
add_shortcode('javo_rating_list','rating_list_function');
function rating_list_function($atts, $content=''){
	wp_enqueue_style( 'javo-rating-list-css', JAVO_THEME_DIR.'/library/shortcodes/rating-list/javo-rating-list.css', '1.0' );
	extract(shortcode_atts(Array(
		'title'					=> ''
		, 'sub_title'			=> ''
		, 'title_text_color'	=> '#000'
		, 'sub_title_text_color'=> '#000'
		, 'line_color'			=> '#fff'
		, 'count'				=> 5
	),$atts));

	$javo_this_ratings_args = Array(
		'post_type'				=> 'item'
		, 'post_status'			=> 'publish'
		, 'posts_per_page'		=> $count
		, 'orderby'				=> 'meta_value'
		, 'meta_key'			=> 'rating_average'
	);
	ob_start();
	echo apply_filters('javo_shortcode_title', $title, $sub_title, Array('title'=>'color:'.$title_text_color.';', 'subtitle'=>'color:'.$sub_title_text_color.';', 'line'=>'border-color:'.$line_color.';'));
	?>
	<div class="javo-rating-list-wrap">
		<?php
		$javo_this_ratings = new WP_Query($javo_this_ratings_args);
		if( $javo_this_ratings->have_posts() ){
			$i = 1;
			while( $javo_this_ratings->have_posts() ){
				$javo_this_ratings->the_post();
				$javo_this_score		= (float) get_post_meta( get_the_ID(), 'rating_average', true);
				$javo_meta_query		= new javo_GET_META( get_the_ID() );
				$rating_raniking_num	= $i++;
				?>
				<div class="row rating_list top-ranker">
					<div class="col-md-3 top-ratings-thumb">
						<a href="<?php the_permalink();?>">
							<?php the_post_thumbnail( 'thumbnail' );?>
						</a>
						<div class="top-ratings-num rating-num-<?php echo $rating_raniking_num; ?>"><?php echo $rating_raniking_num;?></div>
					</div>
					<div class="col-md-6 javo-p-t-20px">
						<a href="<?php the_permalink();?>">
							<h3><?php echo javo_str_cut(get_the_title(), 20);?></h3>
							<p><?php printf('%s / %s', $javo_meta_query->cat('item_category', 'No category'), $javo_meta_query->cat('item_location', 'No Location'));?></p>
						</a>
					</div>
					<div class="col-md-2 javo-p-t-20px">
						<div class="text-center">
							<?php 
							printf('<span class="rating_ave">%s</span> / <span class="rating_amount">%s</span>'
								, $javo_this_score
								, $javo_meta_query->get_child_count('ratings', 'rating_parent_post_id')
							);?>
						</div>
						<div class="javo-rating-registed-score" data-score="<?php echo $javo_this_score;?>" title="gorgeous"></div>
					</div><!-- Col -->
				</div><!-- rating_list-imgs -->
				<?php		
			}; // End While
		}else{
			_e('Not Found Items.', 'javo_fr');
		}; // End If
		?>
	</div>
	<?php
	wp_reset_query();
	$content = ob_get_clean();
	return $content;
}