<?php
class javo_post_meta_box{
	public function __construct(){
		add_action('admin_enqueue_scripts', Array($this, 'javo_admin_post_meta_enqueue'));
		add_action('add_meta_boxes', Array($this, 'javo_post_meta_box_init'));
		add_action('save_post', Array($this, 'javo_post_meta_box_save'));
		add_action('admin_footer', Array($this, 'sub_main'));
	}
	public function sub_main(){ ?>
		<script type='text/javascript'>
		(function($){
			"use strict";
			$("body").on("click", ".javo_pmb_option", function(){
				if( $(this).hasClass("sidebar") ) $(".javo_pmb_option.sidebar").removeClass("active");
				if( $(this).hasClass("header") ) $(".javo_pmb_option.header").removeClass("active");
				if( $(this).hasClass("fancy") ) $(".javo_pmb_option.fancy").removeClass("active");
				if( $(this).hasClass("slider") ) $(".javo_pmb_option.slider").removeClass("active");
				$(this).addClass("active");
			}).on("change", "input[name='javo_opt_header']", function(){
				$("#javo_post_header_fancy, #javo_post_header_slide").hide();
				switch( $(this).val() ){
					case "fancy": $("#javo_post_header_fancy").show(); break;
					case "slider": $("#javo_post_header_slide").show(); break;
				};
			});
		})(jQuery);
		</script><?php
	}
	public function javo_admin_post_meta_enqueue(){
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script( 'my-script-handle', JAVO_THEME_DIR.'/assets/js/admin-color-picker.js', array( 'wp-color-picker' ), false, true );
		wp_enqueue_script('thickbox');
		wp_enqueue_script('google_map_API', 'http://maps.google.com/maps/api/js?sensor=false&amp;language=en', null, '0.0.1', false);
		javo_get_script('gmap3.js', 'jQuery-gmap3', '5.1.1', false);
	}
	public function javo_post_meta_box_init(){
		$screen = Array('post', 'page');
		javo_get_asset_style('javo_admin_post_meta.css', 'javo-admin-post-meta-css');
		foreach($screen as $s=>$v){
			add_meta_box( 'javo_post_sidebar_options', 'Sidebar Options', Array($this, 'javo_post_sidebar_option_box'), $v, 'side');
			add_meta_box( 'javo_post_header_options', 'Header Options', Array($this, 'javo_post_header_option_box'), $v );
			add_meta_box( 'javo_post_header_fancy', 'Fancy header options', Array($this, 'javo_post_header_fancy_option'), $v);
			add_meta_box( 'javo_post_header_slide', 'Slide header options', Array($this, 'javo_post_header_slide_option'), $v);
		};
		add_meta_box( 'javo_post_control'		, 'Listing Style Options', Array($this, 'javo_post_controller'), 'page', 'side');
		add_meta_box( 'javo_page_type_option'	, 'Single Page View Type', Array($this, 'javo_page_type_option_callback'), 'item', 'side');
		add_meta_box( 'javo_post_options'		, 'Post Options', Array($this, 'javo_post_option_box'), 'past');
		add_meta_box( 'javo_page_options'		, 'item Listing Filter (only for item listing pages)', Array($this, 'javo_page_option_box'), 'page', 'side');
		add_meta_box( 'javo_blog_options'		, 'Blogs Listing Filter (only for post listing pages)', Array($this, 'javo_blog_option_box'), 'page', 'side');
		add_meta_box( 'javo_map_options'		, 'Map Options', Array($this, 'javo_map_option_box'), 'page');
		add_meta_box( 'javo_item_options'		, 'item meta', Array($this, 'javo_item_option_box'), 'item');
		add_meta_box( 'javo_item_author'		, 'item Author', Array($this, 'javo_item_author_box'), 'item');
		add_meta_box( 'javo_lister_options'		, 'lister meta', Array($this, 'javo_lister_option_box'), 'lister');
		add_meta_box( 'javo_payment_info'		, 'Payment Infomation', Array($this, 'javo_pay_ment_info_box'), 'payment');
		add_meta_box( 'javo_special_item'		, 'Item Setting', Array($this, 'javo_special_item_callback'), 'item', 'side');

	}
	public function javo_page_type_option_callback($post){
		$javo_this_option_current = get_post_meta( $post->ID, 'single_post_type', true);
		$javo_this_options = Array(
			__('Tabs Type', 'javo_fr')	=> 'item-tab'			
		);?>
		<select name="javo_single_page_type">
			<option value="item-one-page"><?php _e('One Page Type (Default)', 'javo_fr');?></option>
			<?php
			foreach( $javo_this_options as $key => $value ){
				printf('<option value="%s"%s>%s</option>', $value, ($javo_this_option_current == $value ? ' selected':''), $key);
			};?>
		</select>



		<?php	
	}
	public function javo_special_item_callback($post){
		$javo_get_this_item_featured = get_post_meta($post->ID, 'javo_this_featured_item', true);
		?>
		<table class="form-table">
		<tr>
			<th><?php _e('Featured Item', 'javo_fr');?></th>
			<td><input name="javo_item_attribute[featured]" value="use" type="checkbox"<?php checked($javo_get_this_item_featured == 'use');?>></td>			
		</tr>
		</table>
		<?php	
	}
	public function javo_post_sidebar_option_box($post){
		// Sidebar LEFT / CENTER / RIGHTER Setting
		$get_javo_opt_sidebar = get_post_meta($post->ID, 'javo_sidebar_type', true);
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			"use strict";
			var t = "<?php echo $get_javo_opt_sidebar;?>";
			if(t != "")$("input[name='javo_opt_sidebar'][value='" + t + "']").trigger("click");
		});
		</script>
		<h5 class="javo_pmb_title"><?php _e("Sidebar position","javo_fr"); ?></h5>
		<label class="javo_pmb_option sidebar op_s_left">
			<span class="ico_img"></span>
			<p><input name="javo_opt_sidebar" value="left" type="radio"> <?php _e("Left","javo_fr"); ?></p>
		</label>
		<label class="javo_pmb_option sidebar op_s_right active">
			<span class="ico_img"></span>
			<p><input name="javo_opt_sidebar" value="right" type="radio" checked="checked"> <?php _e("Right","javo_fr"); ?></p>
		</label>
		<label class="javo_pmb_option sidebar op_s_full">
			<span class="ico_img"></span>
			<p><input name="javo_opt_sidebar" value="full" type="radio"> <?php _e("Fullwidth","javo_fr"); ?></p>
		</label>
<?php	}
	public function javo_post_header_option_box($post){
		// Header  Fancy / Slider settings
		$get_javo_opt_header = get_post_meta($post->ID, "javo_header_type", true);
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			"use strict";
			var t = "<?php echo $get_javo_opt_header;?>";
			if(t != "")$("input[name='javo_opt_header'][value='" + t + "']").trigger("click");
		});
		</script>
		<label class="javo_pmb_option header op_h_title_show active">
			<span class="ico_img"></span>
			<p><input name="javo_opt_header" type="radio" value="default"  checked="checked"> <?php _e("Show page title","javo_fr"); ?></p>
		</label>
		<label class="javo_pmb_option header op_h_title_hide">
			<span class="ico_img"></span>
			<p><input name="javo_opt_header" type="radio" value="notitle"> <?php _e("Hide page title","javo_fr"); ?></p>
		</label>
		<label class="javo_pmb_option header op_h_title_fancy">
			<span class="ico_img"></span>
			<p><input name="javo_opt_header" type="radio" value="fancy"> <?php _e("Fancy Header","javo_fr"); ?></p>
		</label>
		<label class="javo_pmb_option header op_h_title_slide">
			<span class="ico_img"></span>
			<p><input name="javo_opt_header" type="radio" value="slider"> <?php _e("Slide Show","javo_fr"); ?></p>
		</label>
		<label class="javo_pmb_option header op_h_title_map">
			<span class="ico_img"></span>
			<p><input name="javo_opt_header" type="radio" value="map"> <?php _e("Map","javo_fr"); ?></p>
		</label>
<?php	}
	public function javo_post_header_fancy_option($post){
		// Fancy Option
		$get_javo_opt_fancy = get_post_meta($post->ID, "javo_header_fancy_type", true);
		$javo_fancy = @unserialize(get_post_meta($post->ID, "javo_fancy_options", true));
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			"use strict";
			var t = "<?php echo $get_javo_opt_fancy;?>";
			if(t != "")$("input[name='javo_opt_fancy'][value='" + t + "']").trigger("click");

			$("body").on("click", ".fileupload", function(e){
				var attachment;
				var t = $(this).attr("tar");
				e.preventDefault();
				var file_frame;
				if(file_frame){ file_frame.open(); return; }
				file_frame = wp.media.frames.file_frame = wp.media({
					title: jQuery( this ).data( 'uploader_title' ),
					button: {
						text: jQuery( this ).data( 'uploader_button_text' ),
					},
					multiple: false
				});
				file_frame.on( 'select', function(){
					attachment = file_frame.state().get('selection').first().toJSON();
					$(t).val(attachment.url);
					$(".javo_bg_img_preview").prop("src", attachment.url);
				});
				file_frame.open();
			}).on("click", ".fileuploadcancel", function(){
				var t = $(this).attr("tar");
				$(t).val("");
				$(".javo_bg_img_preview").prop("src", "");
			});
		});
		</script>

		<div class="">
			<label class="javo_pmb_option fancy op_f_left active">
				<span class="ico_img"></span>
				<p><input name="javo_opt_fancy" type="radio" value="left" checked="checked"> <?php _e("Title left","javo_fr"); ?></p>
			</label>
			<label class="javo_pmb_option fancy op_f_center">
				<span class="ico_img"></span>
				<p><input name="javo_opt_fancy" type="radio" value="center"> <?php _e("Title center","javo_fr"); ?></p>
			</label>
			<label class="javo_pmb_option fancy op_f_right">
				<span class="ico_img"></span>
				<p><input name="javo_opt_fancy" type="radio" value="right"> <?php _e("Title right","javo_fr"); ?></p>
			</label>
		</div>
		<hr>
		<div class="javo_pmb_field">
			<dl>
				<dt><label for="javo_fancy_field_title"><?php _e("Title","javo_fr"); ?></label></dt>
				<dd><input name="javo_fancy[title]" id="javo_fancy_field_title" type="text" value="<?php echo $javo_fancy['title'];?>"></dd>
			</dl>
			<dl>
				<dt><label for="javo_fancy_field_title_color"><?php _e("Title Color","javo_fr"); ?></label></dt>
				<dd>
					<input name="javo_fancy[title_color]" type="text" value="<?php echo ($javo_fancy['title_color'] != "")?$javo_fancy['title_color']:"#000000";?>" id="javo_fancy_field_title_color" class="wp_color_picker" data-default-color="<?php echo ($javo_fancy['title_color'] != "")?$javo_fancy['title_color']:"#000000";?>">
				</dd>
			</dl>
			<dl>
				<dt><label for="javo_fancy_field_subtitle"><?php _e("Subtitle","javo_fr"); ?></label></dt>
				<dd><input name="javo_fancy[subtitle]" id="javo_fancy_field_subtitle" type="text" value="<?php echo $javo_fancy['subtitle'];?>"></dd>
			</dl>
			<dl>
				<dt><label for="javo_fancy_field_subtitle_color"><?php _e("Subtitle color","javo_fr"); ?></label></dt>
				<dd><input name="javo_fancy[subtitle_color]" value="<?php echo !empty($javo_fancy['subtitle_color'])?$javo_fancy['subtitle_color']:"#000000";?>" id="javo_fancy_field_subtitle_color" type="text" class="wp_color_picker" data-default-color="<?php echo ($javo_fancy['subtitle_color'] != "")?$javo_fancy['subtitle_color']:"#000000";?>"></dd>
			</dl>
			<hr>
			<dl>
				<dt><label for="javo_fancy_field_bg_color"><?php _e("Background color","javo_fr"); ?></label></dt>
				<dd><input name="javo_fancy[bg_color]" value="<?php echo ($javo_fancy['title_color'] != "")?$javo_fancy['bg_color']:"#FFFFFF";?>" id="javo_fancy_field_bg_color" type="text" class="wp_color_picker" data-default-color="<?php echo ($javo_fancy['title_color'] != "")?$javo_fancy['bg_color']:"#FFFFFF";?>"></dd>
			</dl>
			<dl>
				<dt><label for="javo_fancy_field_bg_image"><?php _e("Background Image","javo_fr"); ?></label></dt>
				<dd><input name="javo_fancy[bg_image]" id="javo_fancy_field_bg_image" type="text" value="<?php echo $javo_fancy['bg_image'];?>"><button class="fileupload button button-primary" tar="#javo_fancy_field_bg_image"><?php _e('Upload', 'javo_fr');?></button><input class="fileuploadcancel button" tar="#javo_fancy_field_bg_image" value="Delete" type="button"></dd>
			</dl>
			<dl>
				<dt><?php _e("Background image preview","javo_fr"); ?></dt>
				<dd><img src="<?php echo $javo_fancy['bg_image'];?>" width="200" height="150" border="1" class="javo_bg_img_preview"></dd>
			</dl>
			<script type="text/javascript">
			jQuery(document).ready(function($){
				"use strict";
				var t = new Array( $("select[name='javo_fancy[bg_repeat]']"), $("select[name='javo_fancy[bg_position_x]']"), $("select[name='javo_fancy[bg_position_y]']") );
				var r = new Array("<?php echo $javo_fancy['bg_repeat'];?>", "<?php echo $javo_fancy['bg_position_x'];?>", "<?php echo $javo_fancy['bg_position_y'];?>");
				$.each(r, function(i, v){
					if(v != "") t[i].val(v);
				});
			});


			</script>
			<dl>
				<dt><label for="javo_fancy_field_bg_image"><?php _e("Repeat Option","javo_fr"); ?></label></dt>
				<dd>
					<select name="javo_fancy[bg_repeat]" id="javo_fancy_field_bg_image">
						<option value="no-repeat"><?php _e("no-repeat","javo_fr"); ?></option>
						<option value="repeat-x"><?php _e("repeat-x","javo_fr"); ?></option>
						<option value="repeat-y"><?php _e("repeat-y","javo_fr"); ?></option>
					</select>
				</dd>
			</dl>
			<dl>
				<dt><label for="javo_fancy_field_position_x"><?php _e("Position X","javo_fr"); ?></label></dt>
				<dd>
					<select name="javo_fancy[bg_position_x]" id="javo_fancy_field_position_x">
						<option value="left"><?php _e("Left","javo_fr"); ?></option>
						<option value="center"><?php _e("Center","javo_fr"); ?></option>
						<option value="right"><?php _e("Right","javo_fr"); ?></option>
					</select>
				</dd>
			</dl>
			<dl>
				<dt><label for="javo_fancy_field_position_y"><?php _e("Position Y","javo_fr"); ?></label></dt>
				<dd>
					<select name="javo_fancy[bg_position_y]" id="javo_fancy_field_position_y">
						<option value="top"><?php _e("Top","javo_fr"); ?></option>
						<option value="center"><?php _e("Center","javo_fr"); ?></option>
						<option value="bottom"><?php _e("Bottom","javo_fr"); ?></option>
					</select>
				</dd>
			</dl>
			<hr>
			<dl>
				<dt><label for="javo_fancy_field_fullscreen"><?php _e("Height(pixel)","javo_fr"); ?> </label></dt>
				<dd><input name="javo_fancy[height]" id="javo_fancy_field_fullscreen" value="<?php echo $javo_fancy['height'];?>" type="text"></dd>
			</dl>

		</div>

<?php	}
	public function javo_post_header_slide_option($post){
		// Slide Option
		$javo_slider = @unserialize(get_post_meta($post->ID, "javo_slider_options", true));
		$get_javo_opt_slider = get_post_meta($post->ID, "javo_slider_type", true);
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			"use strict";
			$("body").on("change", "input[name='javo_opt_slider']", function(){
				$(".javo_pmb_tabs.slider")
					.children("div")
					.removeClass("active");
				$("div[tab='" + $(this).val() + "']").addClass("active");
			});
			var t = "<?php echo $get_javo_opt_slider;?>";
			if(t != "")$("input[name='javo_opt_slider'][value='" + t + "']").trigger("click");

		});
		</script>
		<div class="">
			<label class="javo_pmb_option slider op_d_rev active">
				<span class="ico_img"></span>
				<p><input name="javo_opt_slider" type="radio" value="rev" checked="checked"> <?php _e("Revolution","javo_fr"); ?></p>
			</label>
		</div>

		<!-- section  -->
		<div class="javo_pmb_tabs slider javo_pmb_field">
			<div class="javo_pmb_tab active" tab="rev">
				<dl>
					<dt><label><?php _e("Choose slider","javo_fr"); ?></label></dt>
					<dd>
						<?php
						$javo_slider = @unserialize(get_post_meta($post->ID, "javo_slider_options", true));
						if(class_exists('RevSlider')){
							$rev = new RevSlider();
							$arrSliders = $rev->getArrSliders();
							echo '<select name="javo_slide[rev_slider]">';
							foreach ( (array) $arrSliders as $revSlider ) {
								$act = ($javo_slider['rev_slider'] == $revSlider->getAlias())? " selected='selected'" : "";
								printf("<option value='%s'%s>%s</option>", $revSlider->getAlias(), $act, $revSlider->getTitle());
							}
							echo '</select>';
						}else{
							printf('<label>%s</label>', __('Please install revolition slider plugin or create slide item.', 'javo_fr'));
						};?>
					</dd>
				</dl>
			</div>
		</div>

<?php	}
	public function javo_post_option_box($post){
		//
		?>
		<div class="javo_pmb_field">
			<dl>
				<dt><label><?php _e("Hide featured image on post page","javo_fr"); ?></label></dt>
				<dd>
					<input type="checkbox">
				</dd>
			</dl>
			<hr>
			<dl>
				<dt><label><?php _e("Related posts category","javo_fr"); ?></label></dt>
				<dd>
					<label><input type="radio"> <?php _e("from the same category","javo_fr"); ?></label>
					<label><input type="radio"> <?php _e("choose category(s)","javo_fr"); ?></label>
				</dd>
			</dl>
			<hr>
			<dl>
				<dt><label><?php _e("Post Preview Options","javo_fr"); ?></label></dt>
				<dd>
					<label><input type="radio"> <?php _e("Normal","javo_fr"); ?></label>
					<label><input type="radio"> <?php _e("Wide","javo_fr"); ?></label>
				</dd>
			</dl>



		</div>


<?php	}
	public function javo_page_option_box($post){
		$taxs = get_taxonomies(Array("object_type"=> Array("item")));
		$tax_array = @unserialize(get_post_meta($post->ID, 'javo_item_tax', true));
		$term_array = @unserialize(get_post_meta($post->ID, "javo_item_terms", true));

		?>

		<h3><?php _e('Filtering 1.', 'javo_fr');?></h3>
		<div class="javo_cate_term1">
			<select name="javo_item_tax[tax1]" data-tar=".filter1">
				<option value=""><?php _e('None', 'javo_fr');?></option>
				<?php
				foreach($taxs as $tax){
					printf('<option value="%s" %s>%s</option>'
						, $tax, ((!empty($tax_array['tax1']) && $tax == $tax_array['tax1'])? ' selected': '')
						, get_taxonomy($tax)->label);
				};?>
			</select>
			<?php
			foreach($taxs as $tax){?>
				<div class="javo_tax_<?php echo get_taxonomy($tax)->label;?> filter1 hidden">
				<?php
					$terms = get_terms($tax, Array("hide_empty"=>0));
					foreacH($terms as $term)
						printf("<label><input name='javo_item_terms[tax1]' value='%s' type='radio' %s>&nbsp;%s</label><br>"
							, $term->term_id
							, checked(!empty($term_array['tax1']) && $term_array['tax1'] == $term->term_id, true, false)
							, $term->name
						);
				?>
				</div>
			<?php }	?>
		</div>
		<hr>
		<h3><?php _e('Filtering 2.', 'javo_fr');?></h3>
		<div class="javo_cate_term2">
			<select name="javo_item_tax[tax2]" data-tar=".filter2">
				<option value=""><?php _e('None', 'javo_fr');?></option>
				<?php
				foreach($taxs as $tax){
					printf('<option value="%s" %s>%s</option>'
						, $tax, ((!empty($tax_array['tax2']) && $tax == $tax_array['tax2']) ? ' selected': '')
						, get_taxonomy($tax)->label);
				};?>
			</select>
			<?php
			foreach($taxs as $tax){?>
				<div class="javo_tax_<?php echo get_taxonomy($tax)->label;?> filter2 hidden">
				<?php
					$terms = get_terms($tax, Array("hide_empty"=>0));
					foreacH($terms as $term)
						printf("<label><input name='javo_item_terms[tax2]' value='%s' type='radio' %s>&nbsp;%s</label><br>"
							, $term->term_id
							, checked(!empty($term_array['tax2']) && $term_array['tax2'] == $term->term_id, true, false)
							, $term->name
						);
				?>
				</div>
			<?php }	?>
		</div>

			<script type="text/javascript">
			(function($){
				"use strict";				
				var _cur_tmp = "templates/tp-item-list.php";
				$("select[name^='javo_item_tax']").on("change", function(){
					$("div[class^='javo_tax_']" + $(this).data('tar') ).hide();
					$(".javo_tax_" + $(this).children("option:selected").text() + $(this).data('tar')).show();
				});
				$("select[name='page_template']").on("change", function(){
					$("#javo_page_options").hide()
					if( $(this).val() == _cur_tmp) $("#javo_page_options").show();
				});
				$("select[name='page_template']").trigger('change');
				$("select[name^='javo_item_tax']").trigger('change');
			})(jQuery);
			</script>

	<?php
	}
	public function javo_blog_option_box($post){
		$javo_blog_tax = get_taxonomies(Array("object_type"=> Array("post")));
		$javo_blog_term_array = @unserialize(get_post_meta($post->ID, "javo_blog_terms", true));

		printf('<select name="javo_blog_tax"><option value="">%s</option>', __('None', 'javo_fr'));
		foreach($javo_blog_tax as $tax)
			printf("<option value='%s'>%s</option>"
				, $tax
				, get_taxonomy($tax)->label
			);
		echo "</select>";

		foreach($javo_blog_tax as $tax){?>
			<div class="javo_blog_tax_<?php echo get_taxonomy($tax)->label;?>">
			<?php
				$javo_blog_terms = get_terms($tax, Array("hide_empty"=>0));
				foreacH($javo_blog_terms as $term)
					printf("<label><input name='javo_blog_terms[%s]' value='use' type='checkbox'>&nbsp;%s</label><br>"
						, $term->term_id
						, $term->name
					);
			?>
			</div>
		<?php }	?>
			<hr>
			<script type="text/javascript">
				var _cur_blog_tmp = "templates/tp-blogs.php";
				(function($){
					"use strict";
					if( $("select[name='page_template']").val() == _cur_blog_tmp)
						$("#javo_blog_options").show();

					$("select[name='page_template']").on("change", function(){
						$("#javo_blog_options").hide()
						if( $(this).val() == _cur_blog_tmp) $("#javo_blog_options").show()
					});
					var current_blog_term = new Array();
					var current_blog_tax = "<?php echo get_post_meta($post->ID, 'javo_blog_tax', true);?>";
					<?php
					if( !empty( $javo_blog_term_array ) ){
						foreach( $javo_blog_term_array as $term=>$value){
							printf("current_blog_term.push(%s);\n", $term);
						};
					};
					?>
					for(i in current_blog_term){
						$("input[name='javo_blog_terms[" + current_blog_term[i] + "]']").trigger("click");
					}
					$("div[class^='javo_blog_tax_']").hide();
					$("select[name='javo_blog_tax']").on("change", function(){
						$("div[class^='javo_blog_tax_']").hide();
						$(".javo_blog_tax_" + $(this).children("option:selected").text()).show();
					});
					if(current_blog_tax != ""){
						$("select[name='javo_blog_tax']").val(current_blog_tax).trigger("change");
					}
				})(jQuery);
				</script>

<?php
	}

	public function javo_post_controller($post){
	global $javo_lvb;?>
	<script type="text/javascript">
	(function($){
		"use strict";
		var _cur_tmp = new Array(
			"templates/tp-item.php"
			, "templates/tp-blogs.php"
		);
		$("select[name='page_template']").on("change", function(){
			var _this = $(this);
			var _this_div = $("#javo_post_control");
			_this_div.hide();
			$.each( _cur_tmp, function(i, v){
				if( _this.val() == v) _this_div.show();
			});
		});
		$("select[name='page_template']").trigger("change");
	})(jQuery);
	</script>
	<div class="javo_control_panel">
		<input name="javo_post_control_visible" value="use" type="hidden">
		<dl>
			<dt><?php _e("Multiple Buttons and Listings","javo_fr"); ?></dt>
			<dd>
			<?php $javo_lvb->getAdminField($post);?>
			</dd>
		</dl>
		<dl>
			<dt><?php _e("Default View Type","javo_fr"); ?></dt>
			<dd>
			<?php $javo_lvb->getDefaultViewlist($post);?>
			</dd>
		</dl>
		<dl>
			<dt><?php _e("Number of Listings per Page", 'javo_fr'); ?></dt>
			<dd>
				<select name="javo_posts_per_page">
					<?php
					$_cur = get_post_meta($post->ID, "javo_posts_per_page", true);
					$_cur = ((int)$_cur >= 6 )? $_cur : 10;
					for($i=6; $i <= 30; $i++)
						printf("<option value='%s' %s>%s</option>"
							, $i, (($_cur == $i)? " selected" : ""), $i);
					?>
				</select>
			</dd>
		</dl>
	</div>
<?php	}
	public function javo_pt_add($meta_key, $post_id=NULL){
		if($post_id == NULL) return;
		return sprintf("<input name='javo_pt[%s]' value='%s'>"
			, $meta_key
			, get_post_meta($post_id, $meta_key, true));
	}
	public function javo_item_option_box($post){
		//
		//
		//
		$alerts = Array(
			"address_search_fail" => __('Sorry, find address failed', 'javo_fr')
		);
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			"use strict";
			var _cur;
			_cur = $("input[name='javo_pt[lat]']").val() != "" && $("input[name='javo_pt[lng]']").val() != "" ? new google.maps.LatLng($("input[name='javo_pt[lat]']").val(), $("input[name='javo_pt[lng]']").val()) : new google.maps.LatLng(40.7143528, -74.0059731);
			var option = {
				map:{ options:{zoom:10} },
				marker:{
					options:{ draggable:true },
					events:{
						dragend:function(m){
							var mark = m.getPosition();
							$("input[name='javo_pt[lat]']").val(mark.lat());
							$("input[name='javo_pt[lng]']").val(mark.lng());
						}
					}
				}
			};
			option.map.options.center = _cur;
			option.marker.values = [{ latLng: _cur }];

			$(".map_area").css("height", 300).gmap3(option);
			$("body").on("keyup", ".javo_txt_find_address", function(e){
				e.preventDefault();
				if(e.keyCode == 13)
					$(".javo_btn_find_address").trigger("click");
				return false;
			}).parent().find(".javo_btn_find_address").on("click", function(){
				var _addr = $(".javo_txt_find_address").val();
				$(".map_area").gmap3({
					getlatlng:{
						address:_addr,
						callback:function(r){
							if(!r){
								alert('<?php echo $alerts["address_search_fail"];?>');
								return false;
							}
							var _find = r[0].geometry.location;
							$("input[name='javo_pt[lat]']").val(_find.lat());
							$("input[name='javo_pt[lng]']").val(_find.lng());
							$(".map_area").gmap3({
								get:{
									name:"marker",
									callback:function(m){
										m.setPosition(_find);
										$(".map_area").gmap3({map:{options:{center:_find}}});
									}
								}
							});
						}
					}
				});
			});
			$("body").on("click", ".javo_pt_detail_del", function(){
				var t = $(this);
				t.parents(".javo_pt_field").remove();

			});
			$("body").on("click", ".javo_pt_detail_add", function(e){
				e.preventDefault();
				var attachment;
				var file_frame, t = $(this);
				if(file_frame){ file_frame.open(); return; }
				file_frame = wp.media.frames.file_frame = wp.media({
					title: jQuery( this ).data( 'uploader_title' ),
					button: {
						text: jQuery( this ).data( 'uploader_button_text' ),
					},
					multiple: false
				});
				file_frame.on( 'select', function(){
					var str ="";
					attachment = file_frame.state().get('selection').first().toJSON();

					str += "<div class='javo_pt_field' style='float:left;'>";
					str += "<img src='" + attachment.url + "' width='150'> <div align='center'>";
					str += "<input name='javo_pt_detail[]' value='" + attachment.id + "' type='hidden'>";
					str += "<input class='javo_pt_detail_del button' type='button' value='Delete'>";
					str += "</div></div>";
					t.parents("td").find(".javo_pt_images").append(str);
				});
				file_frame.open();
			});


		});
		</script>
		<table class="form-table">
			<tr>
				<th><?php _e('Display map areas', 'javo_fr');?></th>
				<td>
					<?php $javo_meta = new javo_get_meta($post->ID); ?>
					
				</td>
			</tr>
			<tr>
				<th><?php _e('Address', 'javo_fr');?></th>
				<td><input name="javo_pt[meta][address]" value="<?php echo $javo_meta->get('address');?>"></td>
			</tr>
			<tr>
				<th><?php _e('Telephone', 'javo_fr');?></th>
				<td><input name="javo_pt[meta][phone]" value="<?php echo $javo_meta->get('phone');?>"></td>
			</tr>
			<tr>
				<th><?php _e('Email Address', 'javo_fr');?></th>
				<td><input name="javo_pt[meta][email]" value="<?php echo $javo_meta->get('email');?>"></td>
			</tr>
			<tr>
				<th><?php _e('Website Address', 'javo_fr');?></th>
				<td><input name="javo_pt[meta][website]" value="<?php echo $javo_meta->get('website');?>"></td>
			</tr>

			<tr>
				<th><?php _e('Location position', 'javo_fr');?></th>
				<td>
					<input class="javo_txt_find_address" type="text"><a class="button javo_btn_find_address"><?php _e('Find', 'javo_fr');?></a>
					<div class="map_area"></div>
						<?php
						$latlng = @unserialize( get_post_meta( $post->ID, "latlng", true ) );
						printf("
							Latitude : <input name='javo_pt[lat]' value='%s' type='text'>
							Longitude : <input name='javo_pt[lng]' value='%s' type='text'>
						", $latlng['lat'], $latlng['lng']);
					?>
				</td>
			</tr>
			<tr>
				<th><?php _e('Detail Images', 'javo_fr');?></th>
				<td>
					<div class="">
						<a href="javascript:" class="button button-primary javo_pt_detail_add">Add detail image</a>
					</div>
					<div class="javo_pt_images">
						<?php
						$images = @unserialize(get_post_meta($post->ID, "detail_images", true));
						if(is_Array($images)){
							foreach($images as $iamge=>$src){
								$url = wp_get_attachment_image_src($src, 'thumbnail');
								printf("
								<div class='javo_pt_field' style='float:left;'>
									<img src='%s'><input name='javo_pt_detail[]' value='%s' type='hidden'>
									<div class='' align='center'>
										<input class='javo_pt_detail_del button' type='button' value='Delete'>
									</div>
								</div>
								", $url[0], $src);
							};
						};?>
					</div>
				</td>
			</tr>
			<tr>
				<th><?php _e('Append Information', 'javo_fr');?></th>
				<td>
					<?php
					global $javo_custom_field, $edit;
					$edit = $post;
					echo $javo_custom_field->form();?>
				</td>
			</tr>
		</table>


	<?php
	}
	public function javo_item_author_box($post){
		$item_author = get_post_meta($post->ID, 'item_author', true);
		$item_author_id = get_post_meta($post->ID, 'item_author_id', true);
		wp_reset_query();
		$javo_get_listers = new wp_user_query(Array('orderby'=> 'display_name'));?>
		<label>
			<input type="radio" name="item_author" value="" <?php checked("" == $item_author);?>>
			<?php _e('My Profile', 'javo_fr');?>
		</label>
		<br>
		<label>
			<input type="radio" name="item_author" value="admin" <?php checked("admin" == $item_author);?>>
			<?php _e('Administrator Profile', 'javo_fr');?>
		</label>
		<br>
		<label>
			<input type="radio" name="item_author" value="other" <?php checked("other" == $item_author);?>>
			<?php _e('Other lister Profile', 'javo_fr');?>
			<select name="item_author_id">
				<?php
				if( !empty( $javo_get_listers->results ) ){
					foreach( $javo_get_listers->results as $user ){
						printf('<option value="%s"%s>%s %s (%s)</option>'
							, $user->ID
							, ($item_author_id == $user->ID? ' selected': '')
							, $user->first_name
							, $user->last_name
							, $user->user_login
						);
					}; // End Foreach
				}; // End If ?>
			</select>
		</label>
		<?php
		wp_reset_query();
	}
	public function javo_map_option_box($post){
		global $javo_tso;
		$types = Array(
			1 => __('side fixed', 'javo_fr')
			, 2 => __('Side left', 'javo_fr')
			, 3 => __('Side right', 'javo_fr')
		);
		$javo_mss = @unserialize(get_post_meta($post->ID, 'javo_map_setting', true));
		$javo_mss = new javo_array($javo_mss);
		?>
		<script type="text/javascript">
		(function($){
			"use strict";
			var _cur_tmp = new Array(
				"templates/tp-map.php"
			);
			$("select[name='page_template']").on("change", function(){
				var _this = $(this);
				var _this_div = $("#javo_map_options");
				_this_div.hide();
				$.each( _cur_tmp, function(i, v){
					if( _this.val() == v) _this_div.show();
				});
			});
			$("select[name='page_template']").trigger("change");
		})(jQuery);
		</script>
		<table class="form-table">
			<tr>
				<th><?php _e('Map Type','javo_fr');?></th>
				<td>
					<select name="javo_mss[map_side_type]">
						<?php
						foreach($types as $type => $label){
							printf('<option value="%s"%s>%s</option>'
								, $type
								, ($javo_mss->get('map_side_type') == $type ? " selected" : "")
								, $label
							);
						};
						?>
					</select>
				</td>
			</tr>
			<?php
			$javo_view_content = get_post_meta($post->ID,'javo_show_content',true);
			$javo_map_height = get_post_meta($post->ID, 'javo_map_height', true);
			$javo_map_height = !empty($javo_map_height)? $javo_map_height:$javo_tso->get("map_default_height", 800);

			?>

			<tr>
				<th><?php _e('Show Content','javo_fr');?></th>
				<td>
					<label>
						<input type="checkbox" name="javo_show_content" value="use" <?php checked('use'==$javo_view_content); ?>>
						<?php _e('Use', 'javo_fr');?>
					</label>
				</td>
			</tr>
			<tr>
				<th><?php _e('Map height size','javo_fr');?></th>
				<td>
					<input type="text" name="javo_map_height" value="<?php echo $javo_map_height?>"><?php _e('px', 'javo_fr');?>
					<?php printf('on the');?>
				</td>


			</tr>

			<tr><th></th><td></td></tr>
		</table>
<?php
	}

	public function javo_lister_option_box($post){
		$author = get_userdata(get_post($post)->post_author);
	?>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			"use strict";
			$("body").on("click", ".javo_lister_avatar_change", function(e){
				e.preventDefault();
				var attachment;
				var file_frame, t = $(this);
				if(file_frame){ file_frame.open(); return; }
				file_frame = wp.media.frames.file_frame = wp.media({
					title: jQuery( this ).data( 'uploader_title' ),
					button: {
						text: jQuery( this ).data( 'uploader_button_text' ),
					},
					multiple: false
				});
				file_frame.on( 'select', function(){
					attachment = file_frame.state().get('selection').first().toJSON();
					$(".javo_lister_avatar_preview").attr("src", attachment.url);
					$("input[name='javo_lister_avatar']").val(attachment.id);
				});
				file_frame.open();
			});
		});


		</script>
		<table class='form-table'>
			<tr>
				<td colspan="2">
					<?php
					$avatar = get_user_meta($author->ID, "avatar", true);
					$avatar_meta = wp_get_attachment_image_src($avatar, "javo-avatar");
					$avatar_src = $avatar_meta[0];
					printf("
						<img src='%s' width='250' height='250' class='javo_lister_avatar_preview'><br>
						<input name='javo_lister_avatar' value='%s' type='hidden'>"
						, $avatar_src, $avatar);
					?>
					<a class="javo_lister_avatar_change button-primary"><?php _e('Change Avatar', 'javo_fr');?></a>
				</td>
			</tr>
			<tr>
				<th><?php _e('User login ID', 'javo_fr');?> :</th>
				<!-- af = lister field -->
				<td><input name="javo_af[user_login]" value='<?php echo $author->user_login;?>' type='text'></td>
			</tr>
			<tr>
				<th><?php _e('Name', 'javo_fr');?> :</th>
				<td>
					<input name="javo_af[first_name]" value='<?php echo $author->first_name;?>' type='text'>
					<input name="javo_af[last_name]" value='<?php echo $author->last_name;?>' type='text'>
				</td>
			</tr>
			<tr>
				<th><?php _e('Email Address', 'javo_fr');?> :</th>
				<td><input name="javo_af[user_email]" value='<?php echo $author->user_email;?>' type='text'></td>
			</tr>
			<tr>
				<th><?php _e('Introduce', 'javo_fr');?> :</th>
				<td>
					<?php wp_editor(get_user_meta($author->ID, "description", true), "dd", Array("textarea_name"=>"javo_af[description]"));?>
				</td>
			</tr>
			<tr>
				<th><?php _e('Telephone', 'javo_fr');?> :</th>
				<td><input name="javo_af[phone]" value='<?php echo get_user_meta($author->ID, "phone", true);?>' type='text'></td>
			</tr>
			<tr>
				<th><?php _e('Mobile', 'javo_fr');?> :</th>
				<td><input name="javo_af[mobile]" value='<?php echo get_user_meta($author->ID, "mobile", true);?>' type='text'></td>
			</tr>
			<tr>
				<th><?php _e('Fax', 'javo_fr');?> :</th>
				<td><input name="javo_af[fax]" value='<?php echo get_user_meta($author->ID, "fax", true);?>' type='text'></td>
			</tr>
			<tr>
				<th><?php _e('Twitter', 'javo_fr');?> :</th>
				<td><input name="javo_af[twitter]" value='<?php echo get_user_meta($author->ID, "twitter", true);?>' type='text'></td>
			</tr>
			<tr>
				<th><?php _e('Facebook', 'javo_fr');?> :</th>
				<td><input name="javo_af[facebook]" value='<?php echo get_user_meta($author->ID, "facebook", true);?>' type='text'></td>
			</tr>
			<tr></tr>
		</table>
	<?php
	}
	public function javo_pay_ment_info_box($post){
		$javo_pay_post = new javo_get_meta($post);
		?>
		<table class="form-table">
			<tr>
				<th><?php _e('Item name', 'javo_fr');?></th>
				<td><?php echo $javo_pay_post->_get('pay_item_id');?></td>
			</tr>
			<tr>
				<th><?php _e('Item("Post")', 'javo_fr');?></th>
				<td><?php printf('%s %s', $javo_pay_post->_get('pay_cnt_post'), __('posts', 'javo_fr'));?></td>
			</tr>
			<tr>
				<th><?php _e('Item("Post Except")', 'javo_fr');?></th>
				<td><?php printf('%s %s', $javo_pay_post->_get('pay_expire_day'), __('days', 'javo_fr'));?></td>
			</tr>
			<tr>
				<th><?php _e('Pay Type', 'javo_fr');?></th>
				<td><?php echo $javo_pay_post->_get('pay_type');?></td>
			</tr>
			<tr>
				<th><?php _e('Pay Status', 'javo_fr');?></th>
				<td><?php echo get_post_status($post->ID) == "publish"? "Active" : "Pending";?></td>
			</tr>
			<tr>
				<th><?php _e('Pay Price', 'javo_fr');?></th>
				<td><?php echo $javo_pay_post->_get('pay_price');?></td>
			</tr>
			<tr>
				<th><?php _e('Currency', 'javo_fr');?></th>
				<td><?php echo $javo_pay_post->_get('pay_currency');?></td>
			</tr>
			<tr>
				<th><?php _e('Pay Process Day', 'javo_fr');?></th>
				<td><?php echo $javo_pay_post->_get('pay_day');?></td>
			</tr>
			<tr></tr>


		</table>




		<?php

	}
	public function javo_post_meta_box_save($post_id){
		if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE){
			return $post_id;
		};
		$javo_query = new javo_array($_POST);

		// Result Save
		update_post_meta($post_id, "javo_header_type"			, $javo_query->get('javo_opt_header'));
		update_post_meta($post_id, "javo_header_fancy_type"		, $javo_query->get('javo_opt_fancy'));
		update_post_meta($post_id, "javo_sidebar_type"			, $javo_query->get('javo_opt_sidebar'));
		update_post_meta($post_id, "javo_slider_type"			, $javo_query->get('javo_opt_slider'));
		update_post_meta($post_id, "javo_post_control_visible"	, $javo_query->get('javo_post_control_visible'));
		update_post_meta($post_id, "javo_post_default_view"		, $javo_query->get('javo_post_default_view'));
		update_post_meta($post_id, "javo_posts_per_page"		, $javo_query->get('javo_posts_per_page'));
		update_post_meta($post_id, "javo_item_tax"				, @serialize((array)$javo_query->get('javo_item_tax')));
		update_post_meta($post_id, "javo_blog_tax"				, $javo_query->get('javo_blog_tax'));
		update_post_meta($post_id, "single_post_type"			, $javo_query->get('javo_single_page_type'));

		// item Listing Filter terms
		$javo_item_terms = !empty($_POST['javo_item_terms'])? @serialize($_POST['javo_item_terms']): "";
		update_post_meta($post_id, "javo_item_terms", $javo_item_terms);

		// Blogs Listing Filter terms
		$javo_blog_terms = !empty($_POST['javo_blog_terms'])? @serialize($_POST['javo_blog_terms']): "";
		update_post_meta($post_id, "javo_blog_terms", $javo_blog_terms);

		if(!empty($_POST['javo_mss'])){
			$javo_map_option = @serialize($_POST['javo_mss']);
			update_post_meta($post_id, 'javo_map_setting', $javo_map_option);
		};



		switch( get_post_type($post_id) ){
			case "item":
				$javo_item_query = new javo_ARRAY( $javo_query->get('javo_item_attribute', Array()) );
				update_post_meta($post_id, "javo_this_featured_item", $javo_item_query->get('featured', ''));	


				// item meta
				if(isset($_POST['javo_pt'])){
					$ppt_meta = $_POST['javo_pt'];
					$javo_pt_query = new javo_array($ppt_meta);
					$latlng = Array( "lat"=> $ppt_meta['lat'], "lng"=> $ppt_meta['lng']);
					$ppt_images = !empty($_POST['javo_pt_detail'])? $_POST['javo_pt_detail'] : null;

					$map_area_settings = !empty($ppt_meta['item_map_positon'])? $ppt_meta['item_map_positon'] : Array();
					$map_area_settings = @serialize($map_area_settings);
					$map_type_settings = !empty($ppt_meta['item_map_type'])? $ppt_meta['item_map_type'] : Array();
					$map_type_settings = @serialize($map_type_settings);

					
					$args = Array( 'ID' => $post_id );
					if( $javo_query->get('item_author') == 'admin' ){
						$javo_this_admin_id = new wp_user_query(Array('role'=>'administrator'));
						$javo_this_admin_id = $javo_this_admin_id->results;
						$args["post_author"] = $javo_this_admin_id[0]->ID;
						wp_reset_query();
					}elseif( $javo_query->get('item_author') == 'other' ){
						$args["post_author"] = $javo_query->get('item_author_id');
					};
					if( $javo_query->get('item_author') != ''){
						remove_action('save_post', Array($this, 'javo_post_meta_box_save'));
						$post_id = wp_update_post($args);
						add_action('save_post', Array($this, 'javo_post_meta_box_save'));
					};
					update_post_meta($post_id, "latlng", @serialize($latlng));
					update_post_meta($post_id, "directory_meta", @serialize($ppt_meta['meta']));
					update_post_meta($post_id, "detail_images", @serialize($ppt_images));
					update_post_meta($post_id, "item_map_positon", $map_area_settings);
					update_post_meta($post_id, "item_map_type", $map_type_settings);
				};
			break;
			case "lister":
				$author_id = get_post($post_id)->post_author;
				$author = get_userdata($author_id);
				if(isset($_POST['javo_af'])){
					$javo_af = $_POST['javo_af'];
					$args = Array(
						"ID"=> $author_id
						, "user_login"=> $javo_af['user_login']
						, "user_email"=> $javo_af['user_email']
						, "first_name"=> $javo_af['first_name']
						, "last_name"=> $javo_af['last_name']
					);
					wp_update_user($args);
					update_user_meta($author_id, "description", $javo_af['description']);
					update_user_meta($author_id, "phone", $javo_af['phone']);
					update_user_meta($author_id, "mobile", $javo_af['mobile']);
					update_user_meta($author_id, "fax", $javo_af['fax']);
					update_user_meta($author_id, "twitter", $javo_af['twitter']);
					update_user_meta($author_id, "facebook", $javo_af['facebook']);

					$post = get_post($post_id);
					$author = $post->post_author;
					if(isset($_POST['javo_lister_avatar'])){
						update_user_meta($author, "avatar", $_POST['javo_lister_avatar']);
					};
				};
			break;
		};

		// Fancy options
		if(!empty($_POST['javo_fancy'])){
			$fancy = serialize($_POST['javo_fancy']);
			update_post_meta($post_id, "javo_fancy_options", $fancy);
		};
		if(!empty($_POST['javo_slide'])){
			$slider = serialize($_POST['javo_slide']);
			update_post_meta($post_id, "javo_slider_options", $slider);
		};
		$javo_controller_setup = !empty($_POST['javo_post_control'])? @serialize($_POST['javo_post_control']) : "";
		update_post_meta($post_id, "javo_control_options", $javo_controller_setup);

		// Show content enabled
		update_post_meta($post_id, "javo_show_content", (!empty($_POST['javo_show_content'])? $_POST['javo_show_content'] : null));
		update_post_meta($post_id, "javo_map_height", (!empty($_POST['javo_map_height'])? $_POST['javo_map_height'] : ""));
	}
}
new javo_post_meta_box();