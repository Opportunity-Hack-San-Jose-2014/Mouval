<?php
/**
***	Review Form
***/
require_once 'mypage-common-header.php';
$javo_query = new javo_ARRAY( $_POST );
if( !is_user_logged_in() ){
	die('Not logged');
	exit(0);
}

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
	$latlng = @unserialize(get_post_meta($edit->ID, "latlng", true));
	$detail_images = @unserialize(get_post_meta($edit->ID, "detail_images", true));
};
get_header(); ?>
<script type="text/javascript">
(function($){
	"use strict";
	$("body").on("keyup", ".only_number", function(){
		this.value = this.value.replace(/[^0-9]/g, '');
	});
})(jQuery);
</script>
<div class="jv-my-page">
	<div class="row top-row">
		<div class="col-md-12">
			<?php get_template_part('library/dashboard/sidebar', 'user-info');?>
		</div> <!-- col-12 -->
	</div> <!-- top-row -->

	<div class="container secont-container-content">
		<div class="row row-offcanvas row-offcanvas-left">
			<?php get_template_part('library/dashboard/sidebar', 'menu');?>
			<div class="col-xs-12 col-sm-10 main-content-right" id="main-content">  
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default panel-wrap">
							<div class="panel-heading">								
								<p class="pull-left visible-xs">
									<button class="btn btn-primary btn-xs" data-toggle="mypage-offcanvas"><?php _e('My page side menus', 'javo_fr'); ?></button>
								</p> <!-- offcanvas button -->
								<div class="row">
									<div class="col-md-11 my-page-title">
										<?php echo empty($edit)? __('Add Review', 'javo_fr') : __('Edit Review', 'javo_fr');?>
									</div> <!-- my-page-title -->

									<div class="col-md-1">
										<p class="text-center"><a href="#full-mode" class="toggle-full-mode"><i class="fa fa-arrows-alt"></i></a></p>
									</div> <!-- my-page-title -->
								</div> <!-- row -->
							</div> <!-- panel-heading -->

							<div class="panel-body">
							<!-- Starting Content -->

								<form method="post" id="javo-add-review-form">
									<div class="form-group">
										<label><?php _e('Title', 'javo_fr');?></label>
										<input type="text" name="txt_title" value="<?php echo !empty($edit)? $edit->post_title:'';?>" class="form-control" placeholder="<?php _e('Review Title', 'javo_fr');?>">
									</div>
									<div class="form-group">
										<label><?php _e('Target Item', 'javo_fr');?></label>
										<?php
										$javo_get_my_posts = new WP_Query(Array(
											'post_type'			=> 'item'
											, 'post_status'		=> 'publish'
											, 'posts_per_page'	=> -1									
										));

										if( $javo_get_my_posts->have_posts() ){
											?>
											<select name="txt_parent_post_id" class="form-control">
												<option value=""><?php _e('Select Target Shop Item', 'javo_fr');?></option>
											<?php
											while( $javo_get_my_posts->have_posts() ){
												$javo_get_my_posts->the_post();
												$javo_this_parent = !empty($edit)? get_post_meta($edit->ID, 'parent_post_id', true) : null;
												printf( '<option value="%s"%s>%s</option>'
													, get_the_ID()
													, ( $javo_this_parent == get_the_ID() || (int)$javo_query->get('parent', 0) == get_the_ID()?' selected':'' )
													, get_the_title() );
											};?>
											</select>
											<?php
										}else{
											_e('No Found Items.', 'javo_fr');
										};
										wp_reset_postdata();?>
									</div>
									<div class="form-group">
										<label><?php _e('Featured Image', 'javo_fr');?></label>
										<p>
											<?php
											if(!empty($edit)){
												echo get_the_post_thumbnail( $edit->ID, 'full', Array('class'=> 'img-responsive javo-upload-preview'));
											}else{
												printf('<img class="img-responsive javo-upload-preview">');										
											};?>
										</p>
										<p>
											<input name="img_featured" type="hidden" value="<?php echo !empty($edit)? get_post_thumbnail_id($edit->ID):null;?>">
											<a class="btn btn-success btn-sm javo-fileupload" data-title="<?php _e('Upload Review Featured Image', 'javo_fr');?>" data-input="input[name='img_featured']" data-preview=".javo-upload-preview"><span class="glyphicon glyphicon-picture"></span><?php _e('Upload Image', 'javo_fr');?></a>
										</p>
									</div>
									<div class="form-group">
										<label><?php _e('Review Content', 'javo_fr');?></label>
										<textarea name="txt_content" data-provide="markdown" rows="10"><?php echo !empty($edit)?$edit->post_content:'';?></textarea>		
									</div>
									<div class="form-group">
										<input name="action" type="hidden" value="add_review">
										<input name="edit" type="hidden" value="<?php echo !empty($edit)? $edit->ID:'';?>">
									</div>
									<div class="form-group">
										<div class="col-md-12" align="center">
											<?php printf("<a class='btn btn-primary item_submit'>%s</a>", isset($edit)? __("Edit This Review", "javo_fr") : __("Submit My Review", "javo_fr")); ?>
										</div>
									</div>
								</form>

								<?php
								$alerts = Array(
									"title_null"=> __('Please type review title.','javo_fr')
									, "content_null"=> __('Please type review content.','javo_fr')
									, "item_edit_success"=> __('Successfully!','javo_fr')
									, "item_new_success"=> __('Thank you !', 'javo_fr')
								);
								?>
								<script type="text/javascript">
								(function($){
									"use strict";
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
										options.data = $("#javo-add-review-form").serialize();
										options.dataType = "json";
										options.error = function(e){ alert("Server Error : " + e.state() ); };
										options.success = function(d){
											if(d.result == true){
												window.transmission = true;
												switch(d.status){
													case "edit":
														alert("<?php echo $alerts['item_edit_success'];?>");
													break;
													case "new": default:
												};
												location.href = '<?php echo home_url("review/".wp_get_current_user()->user_login);?>'
											};
										};
										if( chk_null( 'txt_title', "<?php echo $alerts['title_null'];?>") == false ) return false;
										if( chk_null( 'txt_content', "<?php echo $alerts['content_null'];?>", "textarea") == false ) return false;
										$.ajax(options);
									}).on('click', '.toggle-full-mode', function(){
										$('body').toggleClass('content-full-mode');
									});
									window.transmission = false;
									$("form").submit(function(){ window.transmission = true; });
									window.onbeforeunload = function(){ if(!window.transmission) return ""; };
								})(jQuery);
								</script>
					
							



							<!-- End Content -->
							</div> <!-- panel-body -->
						</div> <!-- panel -->
					</div> <!-- col-md-12 -->
				</div><!--/row-->
			</div><!-- wrap-right -->
		</div><!--/row-->
	</div><!--/.container-->
</div><!--jv-my-page-->
<?php get_footer();