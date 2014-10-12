<div class="javo_ts_tab javo-opts-group-tab" tar="page">
<?php
global $javo_query_args, $javo_tso;
$javo_query_args = Array(
	"post_type"=>"page"
	, "post_status"=>"publish"
	, "showposts" => -1
); ?>
<h2><?php _e("item Default Page Settings", "javo_fr");?></h2>
<table class="form-table">
	<tr><th>
		<?php _e("Pages Setup","javo_fr"); ?>
		<span class="description">
			<?php _e('Creat Pages First. Select and Match The Pages', 'javo_fr');?>
		</span>
	</th><td>
		<fieldset>
			<h4><?php _e("Search Result Page from search form (shortcode and widget)","javo_fr"); ?></h4>
			<select name="javo_ts[page_item_result]">
				<option><?php _e("Not Selected","javo_fr"); ?></option>
				<?php
				$javo_query_args['meta_query']				= Array();

				$javo_query_args['meta_query']['relation']  = 'OR';
				$javo_query_args['meta_query'][]			= Array(
					'key'									=> '_wp_page_template',
					'value'									=> 'templates/tp-javo-map-box.php'
				);
				$javo_query_args['meta_query'][]			= Array(
					'key'									=> '_wp_page_template',
					'value'									=> 'templates/tp-javo-map-wide.php'
				);
				$javo_query_posts = query_posts($javo_query_args);
				foreach($javo_query_posts as $post){
					setup_postdata($post);
					$javo_active = ($javo_theme_option['page_item_result'] == $post->ID) ? " selected" : "";
					printf("<option value='%s'%s>%s</option>", $post->ID, $javo_active, $post->post_title);
				};
				wp_reset_query();?>
			</select>
		</fieldset>
		<fieldset>
			<h4><?php _e("Payment Success Page","javo_fr"); ?></h4>
			<select name="javo_ts[page_item_active]">
				<option><?php _e("Not Selected","javo_fr"); ?></option>
				<?php
				$javo_query_args['meta_query'] = Array();
				$javo_query_args['meta_query'][] = Array(
					'key' => '_wp_page_template',
					'value' => 'templates/tp-payment-success.php'
				);
				$javo_query_posts = query_posts($javo_query_args);
				wp_reset_query();
				foreach($javo_query_posts as $post){
					setup_postdata($post);
					$javo_active = ($javo_theme_option['page_item_active'] == $post->ID) ? " selected" : "";
					printf("<option value='%s'%s>%s</option>", $post->ID, $javo_active, $post->post_title);
				};?>
			</select>
		</fieldset>
	</td></tr><tr><th>
		<?php _e("Map Setup","javo_fr"); ?>
		<span class="description">
			<?php _e('Creat Pages First. Select and Match The Pages', 'javo_fr');?>
		</span>
	</th><td>
		<h4><?php _e('Marker Image', 'javo_fr');?></h4>
		<fieldset>
			<input type="text" name="javo_ts[map_marker]" value="<?php echo !empty($javo_theme_option['map_marker'])?$javo_theme_option['map_marker']:null?>" tar="map_marker">
			<input type="button" class="button button-primary fileupload" value="Select Image" tar="map_marker">
			<input class="fileuploadcancel button" tar="map_marker" value="Delete" type="button">
			<p>
				<?php _e("Preview","javo_fr"); ?><br>
				<img src="<?php echo !empty($javo_theme_option['map_marker'])? $javo_theme_option['map_marker']:null;?>" tar="map_marker">
			</p>
		</fieldset>
	</td></tr><tr><th>
		<?php _e("Contact","javo_fr"); ?>
		<span class="description">
			<?php _e('', 'javo_fr');?>
		</span>
	</th><td>
		<h4><?php _e('This form is for single item pages (detail pages)', 'javo_fr');?></h4>
		<fieldset>
		<label>
			<?php _e('Contact Form ID', 'javo_fr');?><br>
			<input type="text" name="javo_ts[contact_form_id]" value="<?php echo $javo_tso->get('contact_form_id');?>">
		</label>
		<p><?php _e('Please go to contact form menu and find created form ID', 'javo_fr');?></p>
		</fieldset>
	</td></tr>
	<!--//-->
</table>
</div>
<?php
add_thickbox();