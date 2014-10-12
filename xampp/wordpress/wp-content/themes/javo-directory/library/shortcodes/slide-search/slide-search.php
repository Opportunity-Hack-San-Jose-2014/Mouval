<?php

class javo_slide_search{
	public function __construct(){
		add_shortcode("javo_slide_search", Array($this, "javo_slide_search_callback"));
	}
	public function javo_slide_search_callback($atts, $content=""){
		global $javo_tso;
		wp_enqueue_style( 'javo-boxes-icons-css', JAVO_THEME_DIR."/library/shortcodes/slide-search/slide-search.css", '1.0' );	
		extract(shortcode_atts(
			Array(
				"items"=>4
				, 'search_type'=> 'horizontal'
			), $atts)
		);
		
		$javo_item_search_slider_args = Array(
			'post_type'				=> 'item'
			, 'post_status'			=> 'publish'
			, 'posts_per_page'		=> -1
			, 'meta_query'			=> Array(
				Array(
					'key'			=> 'javo_this_featured_item'
					, 'compare'		=> '='
					, 'value'		=> 'use'
				)
				
			)
		);
		$javo_item_search_slider = new wp_query($javo_item_search_slider_args);
		ob_start();?>
		<div id="<?php echo $search_type == 'vertical'? 'javo-box-bg-search' : 'javo-slide-search';?>" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators list-unstyled">
				<?php
				for($i=0; $i < $javo_item_search_slider->found_posts; $i++){
					printf('<li data-target="#javo-slide-search" data-slide-to="%s" class="%s"></li>', $i, ($i == 0 ? 'active':''));
				};?>
			</ol>
			<div class="<?php echo $search_type == 'vertical'? 'background-search-box' : 'slider-search-box';?>">
				<div class="inner">
					<div class="inner_wrap">
						<?php 
						if($javo_tso->get('page_item_result', 0) > 0 ){
							switch( $search_type ){
								case 'horizontal':
									?>
									<form class="navbar-form navbar-left" role="search" method="post" action="<?php echo get_permalink($javo_tso->get('page_item_result'));?>">
										<div class="slider-search-part-wrap">
											<div class="form-group"><input type="text" class="form-control input-large" placeholder="Keyword" name="keywrod"></div>

											<!-- Large button group -->
											<div class="btn-group">
												<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
													<?php _e('Category', 'javo_fr'); ?> <span class="caret"></span>
												</button>
												<ul class="dropdown-menu javo-this-filter" role="menu">
													<li><a class="btn" data-term=""><?php _e('All Categories', 'javo_fr');?></a></li>
													<li class="divider"></li>
													<?php
													$javo_get_this_terms = get_terms('item_category', Array('hide_empty'=>0));
													if( !empty( $javo_get_this_terms ) ){
														foreach( $javo_get_this_terms as $term){
															printf('<li><a class="btn" data-term="%s">%s</a></li>', $term->term_id, $term->name);												
														};
													};?>
												</ul>
												<input type="hidden" name="filter[item_category]">
											</div>

											<!-- Large button group -->
											<div class="btn-group">
												<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
													Location <span class="caret"></span>
												</button>
												<ul class="dropdown-menu javo-this-filter" role="menu">
													<li><a class="btn" data-term=""><?php _e('All Locations', 'javo_fr');?></a></li>
													<li class="divider"></li>
													<?php
													$javo_get_this_terms = get_terms('item_location', Array('hide_empty'=>0));
													if( !empty( $javo_get_this_terms ) ){
														foreach( $javo_get_this_terms as $term){
															printf('<li><a class="btn" data-term="%s">%s</a></li>', $term->term_id, $term->name);
														};
													};?>
												</ul>
												<input type="hidden" name="filter[item_location]">
											</div>
											<button type="submit" class="btn btn-primary admin-color-setting"><i class="glyphicon glyphicon-map-marker"></i> <?php _e('Search on Map', 'javo_fr');?></button>
										</div><!-- slider-search-part-wrap -->
									</form>
									<?php
								break;
								case 'vertical':
								default:
									?>
									<form class="navbar-form navbar-left" role="search" method="post" action="<?php echo get_permalink($javo_tso->get('page_item_result'));?>">
										<div class="slider-search-part-wrap">
											<h3><?php _e('Search','javo_fr'); ?></h3>
											<div class="form-group"><input type="text" class="form-control input-large" placeholder="Search" name="keywrod"></div>
											<!-- Large button group -->
											<div class="btn-group">
												<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
													<?php _e('Category', 'javo_fr'); ?> <span class="caret"></span>
												</button>
												<ul class="dropdown-menu javo-this-filter" role="menu">
													<li><a class="btn" data-term=""><?php _e('All Categories', 'javo_fr');?></a></li>
													<li class="divider"></li>
													<?php
													$javo_get_this_terms = get_terms('item_category', Array('hide_empty'=>0));
													if( !empty( $javo_get_this_terms ) ){
														foreach( $javo_get_this_terms as $term){
															printf('<li><a class="btn" data-term="%s">%s</a></li>', $term->term_id, $term->name);												
														};
													};?>
												</ul>
												<input type="hidden" name="filter[item_category]">
											</div>
											<!-- Large button group -->
											<div class="btn-group">
												<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
													<?php _e('Location', 'javo_fr'); ?> <span class="caret"></span>
												</button>
												<ul class="dropdown-menu javo-this-filter" role="menu">
													<li><a class="btn" data-term=""><?php _e('All Locations', 'javo_fr');?></a></li>
													<li class="divider"></li>
													<?php
													$javo_get_this_terms = get_terms('item_location', Array('hide_empty'=>0));
													if( !empty( $javo_get_this_terms ) ){
														foreach( $javo_get_this_terms as $term){
															printf('<li><a class="btn" data-term="%s">%s</a></li>', $term->term_id, $term->name);
														};
													};?>
												</ul>
												<input type="hidden" name="filter[item_location]">
											</div>
											<div class="search-part-inner-text"><?php _e('Search your location and categories to display on maps', 'javo_fr'); ?></div>
											<input type="submit" class="btn btn-primary admin-color-setting" onclick="this.form.submit();" value="<?php _e('Submit', 'javo_fr');?>">
										</div><!-- slider-search-part-wrap -->
									</form>
								<?php
							}; // End Switch
						}else{
							?>
							<div class="alert alert-warning text-center">
								<strong><?php _e('Not Setup Results Page', 'javo_fr');?></strong>
								<p>
									<?php _e('Please check to Theme setting > Item Pages > Search Result', 'javo_fr');?>
								</p>
							</div>
							<?php
						}; //  End If?>
					</div> <!-- inner_wrap -->
				</div> <!-- inner -->
			</div><!-- slider-search-box -->
			<div class="slide-search-bottom-shadow"></div>
			<!-- Wrapper for slides -->
			<div class="carousel-inner">
			<?php
			wp_reset_query();
			if( $javo_item_search_slider->have_posts() ){
				$i=0;
				while( $javo_item_search_slider->have_posts() ){
					$javo_item_search_slider->the_post();
					$javo_rating			= new javo_RATING( get_the_ID() );
					$javo_meta_query		= new javo_GET_META( get_the_ID() );
					$javo_brand_label		= $javo_meta_query->get_events_brand_label();
					?>

					<div class="item<?php echo $i == 0? ' active':''?>">
						<?php
						if( has_post_thumbnail() ){
							$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
							?>
							<div class="slide-bg-images" style="background-image:url('<?php echo $large_image_url[0]; ?>'); height:100%; no-repeat center center fixed;  -webkit-background-size: cover;  -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-attachment: fixed;">
							<div style="position: absolute; left: 0; top: 0; width: 100%; height: 100%; background-image: url('<?php echo JAVO_THEME_DIR;?>/assets/images/pattern-dots-single.png'); background-repeat: repeat; z-index: 1;"></div>
							<a href="<?php the_permalink();?>">
								<div class="<?php echo $search_type == 'vertical'? 'background-slide-title hidden-sm hidden-xs' : 'carousel-caption';?>">
									<h4 class='javo-slider-search-meta hidden-sm hidden-xs'>
										<?php printf('%s / %s', $javo_meta_query->cat('item_location', 'No Location'), $javo_meta_query->cat('item_category', 'No Category'));?>
									</h4>
									<div class="search-slider-title-wrap">
										<h2><?php the_title();?></h2>
									</div>
								</div><!-- carousel-caption -->								
							</a>
							
							<div class="item-author-info">
								<div class="col-md-4"><a href="<?php the_permalink();?>">
									<?php if( !empty($javo_brand_label)){ ?>
										<div class="event_info"><?php echo $javo_brand_label;?>
											<div class="item-author-info-circle-border"></div>
										</div>
									<?php }else{
										printf('<div>&nbsp;</div>');
									};?>
									
								</a></div>								
								<div class="col-md-4">
									<a href="<?php the_permalink();?>"><img src="<?php echo $javo_meta_query->featured_cat();?>">
									<div class="item-author-info-circle-border"></div></a>
								</div>
								<div class="col-md-4">
									<a href="<?php the_permalink();?>"><div class="rating_score text-center"><?php echo $javo_rating->parent_rating_average;?></div>
									<div class="item-author-info-circle-border"></div></a>
								</div>								
							</div><!-- item-author-info -->						
						</div> <!-- slide-bg-images -->
							<?php 
						}; ?>
					</div><!-- item -->
					<?php
					$i++;
				}; // End While
			}else{
				?>
				<div class="item active">
					<img src="" alt="...">
					<div class="carousel-caption">
						<h3><?php _e('No Found Item', 'javo_fr');?></h3>
						<p></p>
					</div><!-- carousel-caption -->
				</div><!-- item -->
				<?php			
			}; // End IF
			wp_reset_query();?>
			</div><!-- carousel-inner -->

			<!-- Controls -->
			<a class="left carousel-control" href="#<?php echo $search_type == 'vertical'? 'javo-box-bg-search' : 'javo-slide-search';?>" role="button" data-slide="prev">
				<i class="glyphicon glyphicon-chevron-left"></i>
			</a>
			<a class="right carousel-control" href="#<?php echo $search_type == 'vertical'? 'javo-box-bg-search' : 'javo-slide-search';?>" role="button" data-slide="next">
				<i class="glyphicon glyphicon-chevron-right"></i>
			</a>
		</div> <!-- javo-slide-search -->

		<script type="text/javascript">
		(function($){
			"use strict";
			var javo_slide_serach = {
				init: function(){
					this.events();
				}, events:function(){
					var $object = this;
					$('body').on('click', '.javo-this-post-views li a', function(){

						$(this).closest('.btn-group').children('button:first-child').text( $(this).text() );
						$object.options.ppp = $(this).data('views');
						$object.run();

					});
					$('.javo-this-filter').each( function(c, v){
						var _this = $(this);
						$(this).on('click', 'a', function(){
							$(this).closest('.btn-group').children('button:first-child').text( $(this).text() );
							$(this).closest('ul').next().val( $(this).data('term') );

						});
					});
				}
			};
			javo_slide_serach.init();
		})(jQuery);
		</script>


		<?php
		$content = ob_get_clean();
		return $content;
	}
}
new javo_slide_search();