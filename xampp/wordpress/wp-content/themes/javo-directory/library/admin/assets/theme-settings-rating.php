<div class="javo_ts_tab javo-opts-group-tab" tar="rating">
	<h2> <?php _e("Rating Settings", "javo_fr"); ?> </h2>
	<table class="form-table">
	<tr><th>
		<?php _e('Rating', 'javo_fr');?>
		<span class="description">
			<?php _e('Todo : insert description here. :D', 'javo_fr');?>
		</span>
	</th><td>

		<h4><?php _e('Enable rating count', 'javo_fr');?></h4>
		<fieldset>
			<select name="javo_ts[rating_count]" id="javo_rating_count">
				<?php
				for($i = 1; $i <= 6; $i++){
					printf('<option name="%s">%s</option>', $i, $i);
				};
				?>
			</select>
			<input type="button" class="button button-primary javo_rat_apply" value="<?php _e('Apply', 'javo_fr');?>">
			<h3><?php _e('Items', 'javo_fr');?></h3>
			<div class="javo_rating_field">
				<?php
				$javo_rating_field = !empty($javo_theme_option['rating_field']) ? $javo_theme_option['rating_field']:null;
				if(!empty($javo_rating_field) && is_array($javo_rating_field)){
					foreach($javo_rating_field as $field){
						printf('<div class="javo_rating_item">
								<label>%s : <input name="javo_ts[rating_field][]" value="%s"></label>
							</div>'
							, __('Display rating field name', 'javo_fr')
							, __($field, 'javo_fr')
						);
					};
				}else{
					printf('<div class="javo_rating_item">
							<label>%s : <input name="javo_ts[rating_field][]"></label>
						</div>'
						, __('Display rating field name', 'javo_fr')
					);
				};
				?>
			</div>
		</fieldset>
		<script type="text/javascript">
		(function($){
			"use strict";
			var _clone = $(".javo_rating_item:first");
			$("body").on("click", ".javo_rat_apply", function(){
				var i=0;
				var _count = $("#javo_rating_count").val();
				$(".javo_rating_field").find(".javo_rating_item:not(:eq(0))").remove();
				
				while(i < (_count - 1)){
					$(".javo_rating_field").append(_clone.clone());
					i++;
				};			
			});
		})(jQuery);
		</script>
		<hr>
		
		<fieldset>
			<h4><?php _e('Rating Alert Title', 'javo_fr');?></h4>
			<input type="text" name="javo_ts[rating_alert_header]" class="large-text" value="<?php echo $javo_tso->get('rating_alert_header', '');?>">
			<h4><?php _e('Rating Alert Content', 'javo_fr');?></h4>
			<textarea name="javo_ts[rating_alert_content]" class="large-text" rows="10"><?php echo $javo_tso->get('rating_alert_content', '');?></textarea>
		</fieldset>
	</td></tr>	
	</table>
</div>	