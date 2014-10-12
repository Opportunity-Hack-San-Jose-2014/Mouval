<div class="javo_ts_tab javo-opts-group-tab" tar="itemfield">
	<h2> <?php _e("Item Fields Settings", "javo_fr"); ?> </h2>
	<table class="form-table">
	<tr><th>
		<?php _e('Field Group Caption', 'javo_fr');?>
		<span class="description">
			<?php _e('Todo : insert description here XD.', 'javo_fr');?>
		</span>
	</th><td>
		<h4><?php _e('Caption', 'javo_fr');?></h4>
		<fieldset>
			<input type="text" name="javo_ts[field_caption]" value="<?php echo $javo_tso->get('field_caption', __('Aditional Information', 'javo_fr'));?>" class="large-text">
		</fieldset>
	</td></tr><tr><th>
		<?php _e('Item Fields', 'javo_fr');?>
		<span class="description">
			<?php _e('Todo : insert description here XD.', 'javo_fr');?>
		</span>
	</th><td bgcolor='#efefef'>
		<div id="dashboard-widgets-wrap">
			<div id="dashboard-widgets" class="metabox-holder">
				<?php 
				$javo_custom_field = new javo_custom_field;
				echo $javo_custom_field->admin();?>
			</div>
		</div>
	</td></tr>
	</table>
</div>