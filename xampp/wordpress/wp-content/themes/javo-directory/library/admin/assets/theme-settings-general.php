<div class="javo_ts_tab javo-opts-group-tab" tar="general">
<!-- Themes setting > General -->
	<h2><?php _e("General", "javo_fr");?></h2>
	<table class="form-table">
	<tr><th>
		<?php _e("Header Logo","javo_fr"); ?>
		<span class='description'>
			<?php _e("Head log :)", "javo_fr");?>
		</span>
	</th>
	<td>
		<h4><?php _e("Logo image url","javo_fr"); ?></h4>
		<fieldset>
			<input type="text" name="javo_ts[logo_url]" value="<?php echo $javo_theme_option['logo_url']?>" tar="g01">
			<input type="button" class="button button-primary fileupload" value="Select Image" tar="g01">
			<input class="fileuploadcancel button" tar="g01" value="Delete" type="button">
			<p>
				<?php _e("Preview","javo_fr"); ?><br>
				<img src="<?php echo $javo_theme_option['logo_url'];?>" tar="g01">
			</p>
		</fieldset>

		<h4><?php _e("Retina Logo","javo_fr"); ?></h4>
		<fieldset>
			<p>
				<input type="text" name="javo_ts[retina_logo_url]" value="<?php echo $javo_theme_option['retina_logo_url']?>" tar="g02">
				<input type="button" class="button button-primary fileupload" value="Select Image" tar="g02">
				<input class="fileuploadcancel button" tar="g02" value="Delete" type="button">
			</p>
			<p>
				<?php _e("Preview","javo_fr"); ?><br>
				<img src="<?php echo $javo_theme_option['retina_logo_url'];?>" tar="g02">
			</p>
		</fieldset>

		<h4><?php _e("Favicon","javo_fr"); ?></h4>
		<fieldset>
			<p>
				<input type="text" name="javo_ts[favicon_url]" value="<?php echo $javo_theme_option['favicon_url']?>" tar="f01">
				<input type="button" class="button button-primary fileupload" value="Select Image" tar="f01">
				<input class="fileuploadcancel button" tar="f01" value="Delete" type="button">
			</p>
			<p>
				<?php _e("Preview","javo_fr"); ?><br>
				<img src="<?php echo $javo_theme_option['favicon_url'];?>" tar="f01">
			</p>
		</fieldset>
	</td></tr><tr><th>
		<?php _e("Bottom Logo","javo_fr"); ?>
		<span class='description'>
			<?php _e("Logo for bottom line. Footer widgets", "javo_fr");?>
		</span>
	</th><td>
		<h4><?php _e("Logo","javo_fr"); ?></h4>
		<fieldset>
			<p>
				<input type="text" name="javo_ts[bottom_logo_url]" value="<?php echo $javo_theme_option['bottom_logo_url']?>" tar="g03">
				<input type="button" class="button button-primary fileupload" value="Select Image" tar="g03">
				<input class="fileuploadcancel button" tar="g03" value="Delete" type="button">
			</p>
			<p>
				<?php _e("Preview","javo_fr"); ?><br>
				<img src="<?php echo $javo_theme_option['bottom_logo_url'];?>" tar="g03">
			</p>
		</fieldset>

		<h4><?php _e("Retina Logo","javo_fr"); ?></h4>
		<fieldset>
			<p>
				<input type="text" name="javo_ts[bottom_retina_logo_url]" value="<?php echo $javo_theme_option['bottom_logo_url']?>" tar="g04">
				<input type="button" class="button button-primary fileupload" value="Select Image" tar="g04">
				<input class="fileuploadcancel button" tar="g04" value="Delete" type="button">
			</p>
			<p>
				<?php _e("Preview","javo_fr"); ?><br>
				<img src="<?php echo $javo_theme_option['bottom_retina_logo_url'];?>" tar="g04">
			</p>
		</fieldset>
	</td></tr><tr><th>
		<?php _e("Login Redirect","javo_fr"); ?>
		<span class='description'>
			<?php _e("Setup redirect page after login", "javo_fr");?>
		</span>
	</th><td>
		<h4><?php _e("Redirect to","javo_fr"); ?> :</h4>

		<fieldset>
		<?php
		$javo_login_redirect_options = Array(
			'home'=> 'Main Page'
		);

		?>
			<select name="javo_ts[login_redirect]">
				<option value=""><?php _e('Default (Profile page', 'javo_fr');?></option>
				<?php
					foreach($javo_login_redirect_options as $key=> $text){
						printf('<option value="%s" %s>%s</option>', $key
							,( !empty($javo_theme_option['login_redirect']) && $javo_theme_option['login_redirect'] == $key? " selected": "")
							, $text);
					}

				?>
			</select>
		</fieldset>
	</td></tr>
	<tr><th>
		<?php _e("Setup default color or button color","javo_fr"); ?>
		<span class="description">
			<?php _e("Setup Button color & hover Event", "javo_fr");?>
		</span>
	</th><td>
		<h4><?php _e("Primary Color", 'javo_fr'); ?></h4>
		<fieldset>
			<input name="javo_ts[total_button_color]" type="text" value="<?php echo $javo_theme_option['total_button_color'];?>" class="wp_color_picker" data-default-color="#0FAF97">
		</fieldset>

		<h4><?php _e("Button border", 'javo_fr'); ?></h4>
		<fieldset>
			<label><input type="radio" name="javo_ts[total_button_border_use]" value="use" <?php checked($javo_tso->get('total_button_border_use') == "use");?>><?php _e('Use', 'javo_fr');?></label>
			<label><input type="radio" name="javo_ts[total_button_border_use]" value="" <?php checked($javo_tso->get('total_button_border_use')== "");?>><?php _e('Not Use', 'javo_fr');?></label>
		</fieldset>

		<h4><?php _e("Border Color", 'javo_fr'); ?></h4>
		<fieldset>
			<input name="javo_ts[total_button_border_color]" type="text" value="<?php echo $javo_theme_option['total_button_border_color'];?>" class="wp_color_picker" data-default-color="#0FAF97">
		</fieldset>

	</td></tr>
	<tr><th>
		<?php _e("Layout style","javo_fr"); ?>
		<span class='description'>
			<?php _e("Please select a layout style", "javo_fr");?>
		</span>
	</th><td>
		<fieldset>
			<label><input type="radio" name="javo_ts[layout_style_boxed]" value="" <?php checked($javo_tso->get('layout_style_boxed') == "");?>><?php _e('Wide', 'javo_fr');?></label>
			<label><input type="radio" name="javo_ts[layout_style_boxed]" value="active" <?php checked($javo_tso->get('layout_style_boxed')== "active");?>><?php _e('Boxed', 'javo_fr');?></label>
		</fieldset>
	</td></tr><tr><th>
		<?php _e('My page menu on/off',"javo_fr"); ?>
		<span class='description'>
			<?php _e('', "javo_fr");?>
		</span>
	</th><td>
		<h4><?php _e('Display My Page Menus in Navigation bar', 'javo_fr');?></h4>
		
		<fieldset>			
			<label><input type="checkbox" name="javo_ts[nav_show_mypage]" value="use" <?php checked($javo_tso->get('nav_show_mypage')== "use");?>><?php _e('Enabled', 'javo_fr');?></label>
		</fieldset>
		<div><?php _e('Please make sure to setup permarlink.', 'javo_fr');?></div>
		<div><a href='<?php echo admin_url('options-permalink.php');?>'><?php _e('Please select "POST NAME" in permarlink list', 'javo_fr');?></a></div>
	</td></tr>
	</table>
</div>