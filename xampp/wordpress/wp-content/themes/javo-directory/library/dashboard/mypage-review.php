<?php
/**
***	My Review Lists
***/
require_once 'mypage-common-header.php';
get_header(); ?>
<div class="jv-my-page jv-my-page-review">
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
										<?php _e('My Reviews Lists', 'javo_fr');?>
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

								<?php
								$javo_this_review_args = Array(
									'post_type'=> 'review'
									, 'posts_per_page'=> -1
									, 'author'		=> get_current_user_id()
									, 'post_status'=> 'publish'
								);
								$javo_this_reviews = new WP_Query($javo_this_review_args);
								if( $javo_this_reviews->have_posts() ){
									while( $javo_this_reviews->have_posts() ){
										$javo_this_reviews->the_post();
										$javo_this_parent_id = get_post_meta(get_the_ID(), 'parent_post_id', true);?>

										<div class="row content-panel-wrap-row <?php echo (int)$javo_this_parent_id <= 0? ' javo-rating-deleted-item':'';?>">
											<div class="col-md-2 thumb">
											<a href="<?php echo get_permalink($javo_this_parent_id);?>#single-review-section">
											<?php
												if( has_post_thumbnail() ){
													the_post_thumbnail('javo-avatar', Array('class'=>'img-responsive img-cycle'));					
												};?>
											</a>										
										</div> <!-- col-md-2 -->
										<div class="col-md-10">
											<div class="row">
												<div class="col-md-6 pull-left my-item-titles">
													<a href="<?php echo get_permalink($javo_this_parent_id);?>#single-review-section">
														<h3><?php the_title();?></h3>
														<span> Jun 4 2014</span>
														<span> Shop Name</span>
													</a>
												</div> <!-- col-md-6 -->
												<div class="col-md-6 pull-right">
													<div class="row content-panel-button-list" align="right">
														
														<a href="<?php echo home_url('add-review/'.wp_get_current_user()->user_login.'/?edit='.get_the_ID());?>" type="button" class="btn btn-warning btn-circle mypage-tooltips" title="<?php _e('Edit Item', 'javo_fr'); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
														<a class="btn btn-danger btn-circle javo_this_trash mypage-tooltips" data-post="<?php the_ID();?>" title="<?php _e('Delete Item', 'javo_fr'); ?>"><i class="glyphicon glyphicon-trash"></i></a>
													</div>
												</div> <!-- col-md-6 -->
											</div> <!-- row -->
											<div class="text-in-content">
												<a href="<?php echo get_permalink($javo_this_parent_id);?>#single-rating-section">
													<span><?php the_excerpt();?></span>
												</a>
											</div><!-- text-in-content -->
										</div> <!-- col-md-10 -->	
										</div> <!-- row-->
										<?php
									};
								};
								wp_reset_query();?>
							
							<!-- End Content -->
							</div> <!-- panel-body -->
						</div> <!-- panel -->
					</div> <!-- col-md-12 -->
				</div><!--/row-->
			</div><!-- wrap-right -->
		</div><!--/row-->
	</div><!--/.container-->
</div><!--jv-my-page-->
<?php 
get_template_part('library/dashboard/mypage', 'common-script');
get_footer();