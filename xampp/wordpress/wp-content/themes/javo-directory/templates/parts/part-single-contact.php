<?php
global $javo_custom_field, $javo_tso, $post;
$javo_this_author				= get_userdata($post->post_author);
$javo_this_author_avatar_id		= get_user_meta($javo_this_author->ID, 'avatar', true);
$javo_directory_query			= new javo_get_meta( get_the_ID() );

echo apply_filters('javo_shortcode_title', __('Contact', 'javo_fr'), get_the_title() );
?>

<!-- total contact start -->
<div class="row single-contact-wrap">
	<div class="col-md-6 javo-animation x2 javo-left-to-right-999">
		<div class="single-contact-info">
		<?php echo wp_get_attachment_image($javo_this_author_avatar_id, 'thumbnail');?>	
		<ul class="inner-items">
				<li><?php _e('By', 'Name'); ?> <?php printf('%s %s', $javo_this_author->first_name, $javo_this_author->last_name);?></li>
				<li><?php echo __('Address', 'javo_fr').': '.$javo_directory_query->get('address');?></li>
				<li><?php echo __('Phone', 'javo_fr').': '.$javo_directory_query->get('phone');?></li>
				<li><?php echo __('Email', 'javo_fr').': '.$javo_directory_query->get('email');?></li>
				<li><?php echo __('Website', 'javo_fr').': '.$javo_directory_query->get('website');?></li>
			</ul>

		</div> <!-- single-contact-info -->
	</div> <!-- col-md-6 -->

	<div class="col-md-6 javo-animation x2 javo-right-to-left-999">
		<div class="single-contact-form">
		<?php 
		if( (int)$javo_tso->get('contact_form_id', 0) > 0 ){
			$javo_this_cf7_code = sprintf('[contact-form-7 id="%s" title="%s"]'
				, $javo_tso->get('contact_form_id')
				, __('Shop Contact Form', 'javo_fr')
			);
			echo do_shortcode($javo_this_cf7_code);
		}else{
			?>
			<div class="alert alert-light-gray">
				<strong><?php _e('Please create a form with contact 7 and add.', 'javo_fr');?></strong>
				<p><?php _e('Theme Settings > Item Pages > Contact > Contact Form ID', 'javo_fr');?></p>
			</div>
			<?php
		};?>
	</div> <!-- single-contact-form -->
	</div> <!-- col-md-6 single-contact-form -->
</div>

		
<!-- total contact end -->
