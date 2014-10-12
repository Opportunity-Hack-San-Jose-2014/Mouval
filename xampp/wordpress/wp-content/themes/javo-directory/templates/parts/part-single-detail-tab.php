<?php

$javo_directory_query			= new javo_get_meta( get_the_ID() );
$javo_rating					= new javo_Rating( get_the_ID() );
global $javo_custom_field, $post, $javo_tso;
$javo_this_author				= get_userdata($post->post_author);
$javo_this_author_avatar_id		= get_user_meta($javo_this_author->ID, 'avatar', true);
$javo_directory_query			= new javo_get_meta( get_the_ID() );
$javo_rating = new javo_Rating( get_the_ID() );


$javo_this_item_tab_slide_type = 'type2';
?>

<!-- slide -->
	<div class="row">
		<div class="col-md-12">
			<?php get_template_part('templates/parts/part', 'single-detail-tab-sliders');?>
		</div> <!-- col-md-12 -->
	</div> <!-- row -->
	
	<!-- slide end -->

	<div class="row">
			<div class="col-md-12">
			<div class="item-single-details-box">
				<h4 class="detail-titles"><?php _e('Description', 'javo_fr'); ?></h4>
				<div class="javo-left-overlay">
					<div class="javo-txt-meta-area admin-color-setting"><?php _e('Description', 'javo_fr'); ?></div> <!-- javo-txt-meta-area -->
					<div class="corner-wrap">
						<div class="corner admin-color-setting"></div>
						<div class="corner-background admin-color-setting"></div>
					</div> <!-- corner-wrap -->
				</div> <!-- javo-left-overlay -->
				<!-- <div class="title-box"><?php _e('Description', 'javo_fr'); ?></div> -->
				<div class="inner-items">
					<?php the_content();?>
				</div> <!-- inner-items -->
			</div> <!-- item-single-details-box -->
		</div> <!-- col-md-12 -->

		<div class="col-md-12">
			<div class="item-single-details-box">
				<h4 class="detail-titles"><?php _e('Contact', 'javo_fr'); ?></h4>
				<div class="javo-left-overlay">
					<div class="javo-txt-meta-area admin-color-setting"><?php _e('Contact', 'javo_fr'); ?></div> <!-- javo-txt-meta-area -->
					<div class="corner-wrap">
						<div class="corner admin-color-setting"></div>
						<div class="corner-background admin-color-setting"></div>
					</div> <!-- corner-wrap -->
				</div> <!-- javo-left-overlay -->

				<div class="inner-items">
					<ul>
						<li><span><?php echo __('Address', 'javo_fr').'</span> '.$javo_directory_query->get('address');?></li>
						<li><span><?php echo __('Phone', 'javo_fr').'</span> '.$javo_directory_query->get('phone');?></li>
						<li><span><?php echo __('Email', 'javo_fr').'</span> '.$javo_directory_query->get('email');?></li>
						<li><span><?php echo __('Website', 'javo_fr').'</span> '.$javo_directory_query->get('website');?></li>
						<li><span><?php echo __('Category', 'javo_fr').'</span> '.$javo_directory_query->cat('item_category');?></li>
						<li><span><?php echo __('Location', 'javo_fr').'</span> '.$javo_directory_query->cat('item_location');?></li>
					</ul>
				</div>
			</div>
			<?php
			$javo_custom_field = javo_custom_field::gets();
			if( !empty( $javo_custom_field ) ){
				?>
				<div class="item-single-details-box">
					<h4 class="detail-titles"><?php echo $javo_tso->get('field_caption', __('Aditional Information', 'javo_fr'))?></h4>
					<div class="javo-left-overlay">
						<div class="javo-txt-meta-area admin-color-setting"><?php echo $javo_tso->get('field_caption', __('Aditional Information', 'javo_fr'))?></div> <!-- javo-txt-meta-area -->
						<div class="corner-wrap">
							<div class="corner admin-color-setting"></div>
							<div class="corner-background admin-color-setting"></div>
						</div> <!-- corner-wrap -->
					</div> <!-- javo-left-overlay -->
					<div class="inner-items">
						<ul>
							<?php
							foreach($javo_custom_field as $field){
								printf('<li><span>%s</span> %s</li>', $field['label'], $field['value']);
							}; // End Foreach ?>
						</ul>
					</div>
				</div>
				<?php
			};// End If?>

		</div> <!-- col-md-12 -->
	</div> <!-- row -->

	