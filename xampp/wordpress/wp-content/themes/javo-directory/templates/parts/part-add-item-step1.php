<?php
global $javo_tso, $edit;
if(isset($_GET["edit"])){
	$user_id = get_current_user_id();
	$edit = get_post($_GET["edit"]);
	$javo_meta = new javo_get_meta($edit->ID);
	if(
		($user_id != $edit->post_author) &&
		(!current_user_can("manage_options"))
	){
		printf("<script>alert('%s');location.href='%s';</script>",
			 __("Access Rejected", "javo_fr"),
			get_site_url());
	};
	$detail_images = @unserialize(get_post_meta($edit->ID, "detail_images", true));
};
$latlng = !empty($edit)? @unserialize(get_post_meta($edit->ID, "latlng", true)) : Array();
$latlng = new javo_ARRAY( $latlng );

?>
<script type="text/javascript">
(function(){
	"use strict";
	window.transmission = false;
	jQuery("form").submit(function(){ window.transmission = true; });
	window.onbeforeunload = function(){ if(!window.transmission) return ""; };
})();
(function($){
	"use strict";
	$("body").on("keyup", ".only_number", function(){
		this.value = this.value.replace(/[^0-9]/g, '');
	});
})(jQuery);
</script>



<div class="row">
	<div class="col-md-12">
		<form role="form" class="form-horizontal" method="post" id="frm_item">
			<div class="row">
				<div class="col-md-8 form-left">
					<div class="line-title-bigdots">
						<h2><span><?php _e("Title","javo_fr"); ?></span></h2>
					</div>
					<div class="form-group">
						<div  class="col-md-12">
							<input name="txt_title" type="text" class="form-control" value="<?php echo isset($edit) ? $edit->post_title : NULL?>">
						</div> <!-- col-md-12 -->
					</div>
					<div class="line-title-bigdots">
						<h2><span><?php _e("Description","javo_fr"); ?></span></h2>
					</div>
					<div class="form-group">
						<div  class="col-md-12">
							<textarea name="txt_content" class="form-control" rows="5"><?php echo isset($edit) ?  $edit->post_content: NULL;?></textarea>
						</div> <!-- col-md-12 -->
					</div>

					<div class="line-title-bigdots">
						<h2><span><?php _e("Features", "javo_fr"); ?></span></h2>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<select name="sel_category" class="form-control">
								<option value=""><?php _e("Category","javo_fr"); ?></option>
								<?php
								$terms = get_terms("item_category", Array("hide_empty"=>0));
								$cats = isset($edit) ? wp_get_post_terms($edit->ID, "item_category") : NULL;

								if(!empty($terms))
									foreach($terms as $item)
										printf("<option value='%s'%s>%s</option>"
											, $item->term_id
											, ((isset($cats[0]->term_id)? $cats[0]->term_id:0) == $item->term_id ? "selected" : "" )
											, $item->name
										);
								?>
							</select>
						</div>
						<div class="col-md-6">
							<select name="sel_location" class="form-control">
								<option value=""><?php _e("Location","javo_fr"); ?></option>
								<?php
								$terms = get_terms("item_location", Array("hide_empty"=>0));
								$cats = isset($edit) ? wp_get_post_terms($edit->ID, "item_location") : NULL;
								if(!empty($terms))
									foreach($terms as $item)
										printf("<option value='%s'%s>%s</option>"
											, $item->term_id
											, ((isset($cats[0]->term_id)? $cats[0]->term_id:0) == $item->term_id ? "selected" : "" )
											, $item->name
										);
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<div class="input-group">
							  <span class="input-group-addon"><?php _e("Telephone","javo_fr"); ?></span>
								<input name="javo_meta[phone]" type="text" class="form-control" value="<?php echo isset($edit)? $javo_meta->get('phone'):null;?>">
							</div> <!-- input-group -->
						</div>
						<div class="col-md-6">
							<div class="input-group">
							  <span class="input-group-addon"><?php _e("Address","javo_fr"); ?></span>
							<input name="javo_meta[address]" type="text" class="form-control" value="<?php echo isset($edit)? $javo_meta->get('address'):null;?>">
							</div> <!-- input-group -->
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon"><?php _e("Email","javo_fr"); ?></span>
							<input name="javo_meta[email]" type="text" class="form-control" value="<?php echo isset($edit)? $javo_meta->get('email'):null;?>">
							</div> <!-- input-group -->
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon"><?php _e("Website","javo_fr"); ?></span>
							<input name="javo_meta[website]" type="text" class="form-control" value="<?php echo isset($edit)? $javo_meta->get('website'):null;?>" placeholder="">
							</div> <!-- input-group -->
						</div>
					</div>

					<div class="line-title-bigdots">
						<h2><span><?php echo $javo_tso->get('field_caption', __('Aditional Information', 'javo_fr'));?></span></h2>
					</div><!-- /.line-title-bigdots -->

					<div class="form-group">
						<div class="col-md-12">
							<?php
							global $javo_custom_field;
							echo $javo_custom_field->form();?>
						</div>
					</div><!-- /.form-group -->

					<div class="line-title-bigdots">
						<h2><span><?php _e("Featured Image", "javo_fr"); ?></span></h2>
					</div>

					<div class="form-group">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									<a class="btn btn-primary btn-sm javo-fileupload" data-title="<?php _e('Upload Featured Image', 'javo_fr');?>" data-input="input[name='javo_featured_url']" data-preview=".javo-this-item-featured"><?php _e("Upload Detail Images","javo_fr"); ?></a>
								</div><!-- col-md-12 -->
							</div><!-- row -->
							<div class="row">
								<div class="col-md-12">
									<?php
									$javo_this_item_featued = NULL;
									if( !empty( $edit ) ){
										$javo_this_item_featued_meta = wp_get_attachment_image_src( get_post_thumbnail_id($edit->ID), 'javo-box');
										$javo_this_item_featued = $javo_this_item_featued_meta[0];
									};?>
									<img src="<?php echo $javo_this_item_featued;?>" class="javo-this-item-featured img-responsive">
									<input name="javo_featured_url" type="hidden" value="<?php echo isset($edit) ?  get_post_thumbnail_id($edit->ID):NULL;?>">
								</div>
							</div>
						</div><!-- col-md-12 -->
					</div><!-- Form Group -->

					<div class="line-title-bigdots">
						<h2><span><?php _e("Detail Images", "javo_fr"); ?></span></h2>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<div class="row">	
								<div class="col-md-12">
									<a class="btn btn-primary btn-sm javo-fileupload" data-multiple="true" data-title="<?php _e('Upload Detail Images', 'javo_fr');?>" data-preview=".javo_dim_field"><?php _e("Upload Detail Images","javo_fr"); ?></a>
									<div class='javo_dim_field row'>
										<!-- Images -->
										<?php
										if( !empty($detail_images) ){
											foreach($detail_images as $index=>$src){
												$url = wp_get_attachment_image_src($src, "thumbnail");
												echo "<div class='col-md-4 javo_dim_div'>";
												printf("
													<div class='row'>
														<div class='col-md-12 javo-dashboard-upload-list'>
															<img src='%s'>
														</div>
													</div>
													<div class='row'>
														<div class='col-md-12' align='center'>
															<input type='hidden' name='javo_dim_detail[]' value='%s'>
															<input type='button' value='%s' class='btn btn-danger btn-xs javo_detail_image_del'>
														</div>
													</div>"
													, $url[0], $src, __("Delete", "javo_fr"));
												echo "</div>";
											};
										};?>
									</div>
								</div><!-- 12 columns -->
							</div><!-- Row -->
						</div>
					</div> <!-- form-group -->

				</div>
				<div class="col-md-4 form-right">
					<div class="form-group">
						<div class="line-title-bigdots">
							<h2><span><?php _e("Location", "javo_fr"); ?></span></h2>
							<div class="input-group">
								<input class="form-control javo-add-item-map-search" placeholder="Address">
								<div class="input-group-btn">
									<input type="button" value="Find" class="javo-add-item-map-search-find btn btn-dark">
								</div>
							</div>
							<div class="map_area"></div>
							<div class="row">
								<div class="col-md-6">
									<div class="input-group input-group-sm">
										<span class="input-group-addon"><?php _e("Latitude","javo_fr"); ?></span>
										<input type="text" name="javo_location[lat]" class="form-control" value="<?php echo $latlng->get('lat', 40.7143528);?>">
									</div> <!-- input-group -->
								</div>
								<div class="col-md-6">
									<div class="input-group input-group-sm">
										<span class="input-group-addon"><?php _e("Longitude","javo_fr"); ?></span>
										<input type="text" name="javo_location[lng]" class="form-control" value="<?php echo $latlng->get('lng', -74.0059731);?>">
									</div> <!-- input-group -->
								</div>
							</div>

						</div>						
					</div> <!-- form-group -->
					
				</div><!-- col-md-4 -->
			</div><!-- row(form-group) -->
			<div class="form-group">
				<div class="col-md-12" align="center">
					<?php printf("<a class='btn btn-lg btn-info item_submit'>%s</a>", isset($edit)? __("Edit item", "javo_fr") : __("Submit This item", "javo_fr")); ?>
				</div>
			</div>
			<div class="row">&nbsp;</div>
			<input name="add_new_post" value="1" type="hidden">
			<input type="hidden" name="edit" value="<?php echo isset($edit) ? $edit->ID : NULL;?>">
			<input type="hidden" name="action" value="add_item">
		</form>
		<form method="post" id="javo_add_item_step1">
			<input type="hidden" name="act2" value="true">
			<input type="hidden" name="post_id" value="">
		</form>


		<?php
		$alerts = Array(
			"title_null"=> __('please type item title.','javo_fr')
			, "content_null"=> __('please type item description.','javo_fr')
			, "latlng_null"=> __('please find address or marker drag.','javo_fr')
			, "item_edit_success"=> __('item modify successfully!','javo_fr')
			, "item_new_success"=> __('Thank you !', 'javo_fr')
		);
		?>
		<script type="text/javascript">
		(function($){
			"use strict";
			var javo_this_location_map = {
				map:$('.map_area')
				, map_attribute:{
					map:{
						latLng: new google.maps.LatLng(40.7143528, -74.0059731)
						, options:{ zoom:8 }
						, events:{
							click:function(m, l){
								$(this)
									.gmap3({
										get:{ 
											name:"marker"
											, callback:function(m){
												m.setPosition( l.latLng );
												$('input[name="javo_location[lat]"]').val( m.getPosition().lat() );
												$('input[name="javo_location[lng]"]').val( m.getPosition().lng() );
											}
										}								
									});
							}
						}
					}
					, marker:{
						latLng: new google.maps.LatLng(40.7143528, -74.0059731)
						, options:{ draggable:true }
						, events:{
							dragend:function(m){
								$('input[name="javo_location[lat]"]').val( m.getPosition().lat() );
								$('input[name="javo_location[lng]"]').val( m.getPosition().lng() );	
							}
						}
					}
				}
				, init:function(){
					if( 
						$('input[name="javo_location[lat]"]').val() &&
						$('input[name="javo_location[lng]"]').val()
					){
						var thisLat = $('input[name="javo_location[lat]"]').val();
						var thisLng = $('input[name="javo_location[lng]"]').val();
						this.map_attribute.map.latLng = new google.maps.LatLng( thisLat, thisLng);
						this.map_attribute.marker.latLng = new google.maps.LatLng( thisLat, thisLng);					
					};

					this.map
						.height( this.map.closest('.row').height() / 2)
						.gmap3( this.map_attribute );

					this.events();
				
				}
				, events:function(){
					var $object = this;
					$('body')
						.on('click', '.javo-add-item-map-search-find', function(){
							$object.map.gmap3({
								getlatlng:{
									address: $('.javo-add-item-map-search').val()
									, callback:function(result){
										if( !result ) return;

										$(this)
											.gmap3({
												get:{ 
													name:"marker"
													, callback:function(marker){
														var $map = $(this).gmap3('get');
														marker.setPosition( result[0].geometry.location );
														$map.setCenter( result[0].geometry.location );

														$('input[name="javo_location[lat]"]').val( result[0].geometry.location.lat() );
														$('input[name="javo_location[lng]"]').val( result[0].geometry.location.lng() );
													}
												}
											});
									}
								}								
							});	
						
						}).on('keyup', '.javo-add-item-map-search', function(e){
							if( e.keyCode == 13 ){
								$('.javo-add-item-map-search-find').trigger('click');												
							};
						});
				
				}
			};
			javo_this_location_map.init();



			function chk_null(obj, msg, objType){
				var objType = objType != null ? objType : "input";
				var obj = $(objType + "[name='" + obj + "']");
				if( obj.val() != "" ) return true;
				obj.addClass("isNull").focus();
				alert(msg);
				return false;
			};
			$("input, textarea").on("keydown", function(){ $(this).removeClass('isNull'); });
			$("body").on("click", ".item_submit", function(){
				var options = {};
				options.type = "post";
				options.url = "<?php echo admin_url('admin-ajax.php');?>";
				options.data = $("#frm_item").serialize();
				options.dataType = "json";
				options.error = function(e){ alert("Server Error : " + e.state() ); };
				options.success = function(d){
					if(d.result == true){
						window.transmission = true;
						switch(d.status){
							case "edit":
								alert("<?php echo $alerts['item_edit_success'];?>");
								location.href = d.link;
							break;
							case "new": default:
								if( d.paid ){
									$("input[name='post_id']").val( d.post_id );
									$("form#javo_add_item_step1").submit();
								}else{
									alert("<?php echo $alerts['item_new_success'];?>");
									location.href = d.link;
								};

						}
					}
				};

				if( chk_null( 'txt_title', "<?php echo $alerts['title_null'];?>") == false ) return false;
				if( chk_null( 'txt_content', "<?php echo $alerts['content_null'];?>", "textarea") == false ) return false;

				if( $("#javo-item-gpsLatitude, #javo-item-gpsLongitude").val() == ""){
					$("#javo-item-address").addClass("isNull").focus();
					alert("<?php echo $alerts['latlng_null'];?>");
					return false;
				};
				$.ajax(options);
			});
		})(jQuery);
		</script>
	</div><!-- container -->
</div><!-- row -->