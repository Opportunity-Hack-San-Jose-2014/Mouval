<?php
/**
***	Payment History Page
***/
require_once 'mypage-common-header.php';
get_header(); ?>
<div class="jv-my-page jv-my-page-payment">
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
										<?php _e('My Payment History', 'javo_fr');?>
									</div> <!-- my-page-title -->

									<div class="col-md-1">
										<p class="text-center"><a href="#full-mode" class="toggle-full-mode"><i class="fa fa-arrows-alt"></i></a></p>
										<script type="text/javascript">
										(function($){
											"use strict";
											$('body').on('click', '.toggle-full-mode', function(){
												$('body').toggleClass('content-full-mode');
											});
										})(jQuery);
										</script>
									</div> <!-- my-page-title -->
								</div> <!-- row -->
							</div> <!-- panel-heading -->

							<div class="panel-body">
							<!-- Starting Content -->



								<div class="row">
									<div class="col-md-12">
										<h5><?php _e('Activated Items', 'javo_fr');?>
										<div class="row">
											<div class="col-md-11 col-md-offset-1">
												<?php
												$javo_user_pay_history = @unserialize(get_user_meta(get_current_user_id(), "pay_items_ids", true));
												$javo_uph_args = Array(
													"post__in"=>$javo_user_pay_history
													, "post_status"=> "publish"
													, "post_type"=> Array("payment")
													, "posts_per_page"=>-1
													, "author"=>get_current_user_id()
												);
												$javo_uph_posts = new WP_Query($javo_uph_args);
												if( $javo_uph_posts->have_posts() ){
													?>
													<table class="table table-hover">
													<tr>
														<td><?php _e('Payment Type', 'javo_fr');?></td>
														<td><?php _e('Detail', 'javo_fr');?></td>
														<td><?php _e('Pay Price', 'javo_fr');?></td>
														<td><?php _e('Pay Day.', 'javo_fr');?></td>
													</tr>

													<?php
													while( $javo_uph_posts->have_posts() ){
														$javo_uph_posts->the_post();
														$javo_meta_query = new javo_GET_META( get_the_ID() );
													?>
													<tr>
														<td><?php echo $javo_meta_query->cat('payment_type');?></td>
														<td>
															<?php printf('Post: %s / Days: %s', $javo_meta_query->_get('pay_cnt_post'), $javo_meta_query->_get('pay_expire_day'));?>
														</td>
														<td>
															<?php printf('%s %s', $javo_meta_query->_get('pay_price'), $javo_meta_query->_get('pay_currency'));?>
														</td>
														<td><?php echo $javo_meta_query->_get('pay_day');?></td>
													</tr>
												<?php
													}; // End While
													?>
													</table>
													<?php
												}else{
													_e('No Found Active Items.', 'javo_fr');
												};
												wp_reset_query();
												?>
											</div><!-- 11 Columns offset 1 close -->
										</div><!-- Row Close -->
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h5><?php _e('Pending Items', 'javo_fr');?></h5>
										<div class="row">
											<div class="col-md-11 col-md-offset-1">
												<?php
												$javo_user_pay_history = @unserialize(get_user_meta(get_current_user_id(), "pay_items_ids", true));
												$javo_uph_args = Array(
													"post__in"=>$javo_user_pay_history
													, "post_status"=> "pending"
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
												$javo_uph_posts = new WP_Query($javo_uph_args);
												if($javo_uph_posts->have_posts()){
													?>
													<table class="table table-hover">
													<tr>
														<th><?php _e('Payment Type', 'javo_fr');?></th>
														<th><?php _e('Detail', 'javo_fr');?></th>
														<th><?php _e('Pay Price', 'javo_fr');?></th>
														<th><?php _e('Pay Day.', 'javo_fr');?></th>
													</tr>

													<?php
													while( $javo_uph_posts->have_posts() ){
														$javo_uph_posts->the_post();
														$javo_meta_query = new javo_get_meta(get_the_ID() );
													?>
													<tr>
														<td><?php echo $javo_meta_query->cat('payment_type');?></td>
														<td>
															<?php printf('Post: %s / Days: %s', $javo_meta_query->_get('pay_cnt_post'), $javo_meta_query->_get('pay_expire_day'));?>
														</td>
														<td>
															<?php printf('%s %s', $javo_meta_query->_get('pay_price'), $javo_meta_query->_get('pay_currency'));?>
														</td>
														<td><?php echo $javo_meta_query->_get('pay_day');?></td>
													</tr>
												<?php
													}; // End while
													?>
													</table>
													<?php
												}else{
													_e('No Pending	 Items.', 'javo_fr');							
												};
												wp_reset_query();?>
											</div><!-- 11 Columns offset 1 close -->
										</div><!-- Row Close -->
									</div>
								</div>

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