<?php global $javo_tso; ?>


<div class="modal fade" id="javo-item-active" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?php _e('Alert Use Item', 'javo_fr');?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
					<?php
					$javo_user_pay_history = @unserialize(get_user_meta(get_current_user_id(), "pay_items_ids", true));
					$javo_uph_args = Array(
						"post__in"=>$javo_user_pay_history
						, "post_status"=> "publish"
						, "post_type"=> Array("payment")
						, "posts_per_page"=>-1
						, "author"=>get_current_user_id()
						, "meta_query"=> Array(
							Array(
								"key"=> "pay_cnt_post"
								, "type"=> "NUMBERIC"
								, "compare"=> ">"
								, "value"=> (int)0
							)
						)
					);
					$javo_uph_posts = query_posts($javo_uph_args);
					wp_reset_query();
					if(!empty($javo_uph_posts)){
						?>
						<div class="row">
							<div class="col-md-3"><?php _e('Packages', 'javo_fr');?></div>
							<div class="col-md-3"><?php _e('Detail', 'javo_fr');?></div>
							<div class="col-md-3"><?php _e('Pay Price', 'javo_fr');?></div>
							<div class="col-md-3"><?php _e('Pay Day.', 'javo_fr');?></div>
						</div>

						<?php
						foreach($javo_uph_posts as $post){
							setup_postdata($post);
							$javo_get_meta = new javo_get_meta($post->ID);
						?>
						<div class="row">
							<div class="col-md-3">
								<input type="radio" name="javo_item_item" value="<?php echo $post->ID;?>">
							</div>
							<div class="col-md-3">
								<?php printf('Post: %s / Days: %s', $javo_pay_meta->_get('pay_cnt_post'), $javo_pay_meta->_get('pay_expire_day'));?>
							</div>
							<div class="col-md-3">
								<?php printf('%s %s', $javo_pay_meta->_get('pay_price'), $javo_pay_meta->_get('pay_currency'));?>
							</div>
							<div class="col-md-3"><?php echo $javo_pay_meta->_get('pay_day');?></div>
						</div>
						<?php };?>
						<div class="row">
							<div class="col-md-12">
								<a class="btn btn-primary hidden javo-use-item-submit"><?php _e('Use selected item', 'javo_fr');?></a>
							</div>
						</div>

						<script type="text/javascript">
						(function($){
							"use strict";
							$('[name="javo_item_item"]').on('change', function(){
								$(".javo-use-item-submit").removeClass('hidden');
							});
							$(".javo-use-item-submit").on('click', function(){
								var _this = $(this);
								var param = {
									post_id: $(this).data('post')
									, user_id: "<?php echo get_current_user_id();?>"
									, item_id: $('[name="javo_item_item"]:checked').val()
									, action: "publish_item"
								};
								var options = {
									url: "<?php echo admin_url('admin-ajax.php');?>"
									, type:"post"
									, data: param
									, dataType: "json"
									, error:function(e){
										alert("Server Error");
										_this
											.text("Re Submit")
											.prop("disabled", false)
											.removeClass("disabled");
									}
									, success: function(d){

										if( d.status == "success"){
											alert('Successfully');
											location.href= d.permalink;
										}else{
											alert(d.comment);
											_this
											.text("Re Submit")
											.prop("disabled", false)
											.removeClass("disabled");
										};
									}
								};
								_this
									.text("Processing...")
									.prop("disabled", true)
									.addClass("disabled");
								$.ajax(options);
							});
						})(jQuery);
						</script>
					<?php }else{ ?>
						<div class="row">
							<div class='col-md-12'>
								<?php _e('Not found Activity item', 'javo_fr');?>
								<form method="post" action="<?php echo home_url('add-item/'.wp_get_current_user()->user_login);?>">
									<input type="hidden" name="act2" value="true">
									<input type="hidden" name="post_id" value="" id="javo-pay-post-id">
									<input type="submit" class="btn btn-primary" value="<?php _e('go Pay', 'javo_fr');?>">
								</form>
							</div>
						</div><!-- row -->


					<?php }; ?>
					</div><!-- 12 Columns close -->
				</div><!-- Row close -->

			</div><!-- modal body -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
(function($){
	"use strict";
	$('body').on('click', '.javo-this-active', function(){
		$(".javo-use-item-submit").data("post", $(this).data('post'));
		$("#javo-pay-post-id").val($(this).data('post'));
		$('#javo-item-active').modal();
	})
})(jQuery);
</script>