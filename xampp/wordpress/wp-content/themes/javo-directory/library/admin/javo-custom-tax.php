<?php

class javo_cumstom_tax{

	public function __construct(){
		add_action( 'admin_enqueue_scripts', Array($this, "admin_enqueue_callback"));
		add_action( 'item_category_edit_form_fields', Array($this,'edit_item_category'), 10, 2);
		add_action( 'item_category_add_form_fields', Array($this, 'add_item_category'));
		add_action( 'created_item_category', Array($this, 'save_item_category'), 10, 2);
		add_action( 'edited_item_category', Array($this, 'save_item_category'), 10, 2);
		add_action( 'deleted_term_taxonomy', Array($this, 'remove_item_category'));
		add_action( 'javo_file_script', Array($this, 'javo_file_script_callback'));
		add_filter( 'manage_edit-item_category_columns', Array($this, 'item_category_columns'));
		add_filter( 'manage_item_category_custom_column', Array($this, 'manage_item_category_columns'), 10, 3);
	}
	public function admin_enqueue_callback(){
		if ( function_exists('wp_enqueue_media') ) {
			wp_enqueue_media();
		}
	}
	public function edit_item_category($tag, $taxonomy) {
		$javo_marker = get_option( 'javo_item_category_'.$tag->term_id.'_marker', '' );
		$javo_featured = get_option( 'javo_item_category_'.$tag->term_id.'_featured', '' );?>
		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="javo_item_category_marker"><?php _e('Map Marker', 'javo_fr');?></label>
			</th>
			<td>
				<input type="text" name="javo_item_category_marker" id="javo_item_category_marker" value="<?php echo $javo_marker; ?>">
				<button class="fileupload" data-target='#javo_item_category_marker'><?php _e('Change', 'javo_fr');?></button>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="javo_item_category_featured"><?php _e('Category Featured Image', 'javo_fr');?></label>
			</th>
			<td>
				<input type="text" name="javo_item_category_featured" id="javo_item_category_featured" value="<?php echo $javo_featured; ?>">
				<button class="fileupload" data-target='#javo_item_category_featured'><?php _e('Change', 'javo_fr');?></button>
			</td>
		</tr>
		<?php
		do_action('javo_file_script');
	}

	public function add_item_category($tag) {
		?>
		<div class="form-field">
			<label for="javo_item_category_marker"><?php _e('Map Marker', 'javo_fr');?></label>
			<input type="text" name="javo_item_category_marker" id="javo_item_category_marker" value="" style="width: 80%;"/>
			<button class="fileupload" data-target='#javo_item_category_marker'><?php _e('Upload', 'javo_fr');?></button>
		</div>
		<div class="form-field">
			<label for="javo_item_category_featured"><?php _e('Category Featured Image', 'javo_fr');?></label>
			<input type="text" name="javo_item_category_featured" id="javo_item_category_featured" value="" style="width: 80%;"/>
			<button class="fileupload" data-target='#javo_item_category_featured'><?php _e('Upload', 'javo_fr');?></button>
		</div>
		<?php
		do_action('javo_file_script');
	}

	public function save_item_category($term_id, $tt_id) {
		if (!$term_id) return;

		if (isset($_POST['javo_item_category_marker'])){
			$name = 'javo_item_category_' .$term_id. '_marker';
			update_option( $name, $_POST['javo_item_category_marker'] );
		}
		if (isset($_POST['javo_item_category_featured'])){
			$name = 'javo_item_category_' .$term_id. '_featured';
			update_option( $name, $_POST['javo_item_category_featured'] );
		}
	}

	public function remove_item_category($id) {
		delete_option( 'javo_item_category_'.$id.'_marker' );
		delete_option( 'javo_item_category_'.$id.'_featured' );
	}

	public function item_category_columns($category_columns) {
		$new_columns = array(
			'cb'        		=> '<input type="checkbox">',
			'name'      		=> __('Name', 'javo_fr'),
			'description'     	=> __('Description', 'javo_fr'),
			'marker'			=> __('Marker Preview', 'javo_fr'),
			'featured'			=> __('Featured Preview', 'javo_fr'),
			'slug'      		=> __('Slug', 'javo_fr'),
			'posts'     		=> __('Items', 'javo_fr'),
			);
		return $new_columns;
	}

	public function manage_item_category_columns($out, $column_name, $cat_id){

		$marker = get_option( 'javo_item_category_'.$cat_id.'_marker', '' );
		$featured = get_option( 'javo_item_category_'.$cat_id.'_featured', '' );
		switch ($column_name) {
			case 'marker':
				if(!empty($marker)){
					$out .= '<img src="'.$marker.'" style="max-width:100%;" alt="">';
				}
			break;
			case 'featured':
				if(!empty($featured)){
					$out .= '<img src="'.$featured.'" style="max-width:100%;" alt="">';
				}
			break;
		};
		return $out;
	}

	public function javo_file_script_callback(){
		?>
		<script type="text/javascript">
		(function($){
			"use strict";
			var attachment;
			$("body").on("click", ".fileupload", function(e){
			var t = $(this).data("target");
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
			});
			file_frame.open();
			// Upload field reset button
			}).on("click", ".fileuploadcancel", function(){
				var t = $(this).attr("tar");
				$("input[type='text'][tar='" + t + "']").val("");
				$("img[tar='" + t + "']").prop("src", "");
			});
		})(jQuery);
		</script>
		<?php
	}
};
new javo_cumstom_tax();