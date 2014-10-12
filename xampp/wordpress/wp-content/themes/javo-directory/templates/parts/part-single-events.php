<?php
global $javo_animation_fixed;
$javo_this_event_posts_args = Array(
	'post_type'				=> 'jv_events'
	, 'post_status'			=> 'publish'
	, 'posts_per_page'		=> -1
	, 'meta_query'			=> Array(
		Array(
			'key'			=> 'parent_post_id'
			, 'type'		=> 'NUMBERIC'
			, 'value'		=> get_the_ID()
			, 'compare'		=> '='
		)											
	)
);
$javo_this_event_posts = new WP_Query($javo_this_event_posts_args);

echo apply_filters('javo_shortcode_title', __('Events', 'javo_fr'), get_the_title() ); ?>

<div class="events-wrap">
<div class="row">
<?php
if( $javo_this_event_posts->have_posts() ){
	$i=0;
	while( $javo_this_event_posts->have_posts() ){
		$javo_this_event_posts->the_post();
		?>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6 javo-animation x2 javo-left-to-right-999 <?php echo $javo_animation_fixed;?>">
					<div class="event-img-box">
					<?php 
					if( has_post_thumbnail() ){
						the_post_thumbnail('javo-huge', Array('class'=> 'img-responsive'));
					}else{
						_e('No Found Thumbnail.', 'javo_fr');
					};?>
					<div class="event-tag custom-bg-color-setting"><span><?php echo get_post_meta( get_the_ID(), 'brand', true);?></span></div>
					<div class="event-title"><span><?php the_title();?></span></div>
					</div> <!-- event-img-box -->
				</div>
				<div class="col-md-6 javo-animation x2 javo-right-to-left-999 <?php echo $javo_animation_fixed;?>">
					<div class="row"><div class="col-md-12"><?php echo strip_tags(get_the_content());?></div></div>
				</div>
			</div><!-- Close Row -->
		</div><!-- 3 Columns Close -->
		<?php
		$i++;
	}; // Emd While
}else{
	?>
	<div class="text-center">
		<?php _e('Not Found Events.', 'javo_fr');?>
	</div>
	<?php
};
wp_reset_postdata(); ?>
</div><!-- 1 ROW -->									
</div><!-- event wrap -->									
