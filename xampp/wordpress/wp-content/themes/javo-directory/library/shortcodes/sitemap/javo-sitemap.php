<?php
add_shortcode('javo_sitemap','sitemap_function');

function sitemap_function($atts, $content=''){
	extract(shortcode_atts(Array(
		'title'					=>''
		, 'sub_title'			=>''
		, 'title_text_color'	=>'#000'
		, 'sub_title_text_color'=>'#000'
		, 'line_color'			=>'#fff'
		, 'category'=>''
		, 'page'=>'4'
		, 'order'=>'DESC'
		, 'title'=>''
		, 'type'=>'single'
	),$atts));

	$args = Array(
		'post_type'=>'jv_sitemap',
		'post_status'=>'publish',
		'posts_per_page'=>$page,
		'order'=>$order,
		'orderby'=>'post_date',
		'tax_query'=> Array()
	);
	/*get categories */
	if($category!=''){
		$args['tax_query'][] = Array(
			'taxonomy'=> 'jv_sitemap_category',
			'field'=> 'tern_id',
			'terms'=> $category
		);
	}
	/*category,type,city check(end) */
	ob_start();?>
	<?php echo apply_filters('javo_shortcode_title', $title, $sub_title, Array('title'=>'color:'.$title_text_color.';', 'subtitle'=>'color:'.$sub_title_text_color.';', 'line'=>'border-color:'.$line_color.';'));?>
	<div class="sitemap-shortcode">
		<div class="container text-center"><a href="#javo-sitemap" class="btn btn-lg btn-primary admin-color-setting">See All Items</a> <!-- btn -->
		</div>
	
	</div><!-- sitemap-shortcode -->

	<?php
	$content = ob_get_clean();
	return $content;
}