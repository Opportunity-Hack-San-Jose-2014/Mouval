<?php
add_shortcode('javo_events','events_function');
function events_function($atts, $content=''){
	wp_enqueue_style( 'javo-events-slider-css', JAVO_THEME_DIR.'/library/shortcodes/events/javo-events-listing.css', '1.0' );
	extract(shortcode_atts(Array(
		'title'=>''
		, 'sub_title'=>''
		, 'title_text_color'=>'#000'
		, 'sub_title_text_color'=>'#000'
		, 'line_color'=> '#fff'
		, 'category'=>''
		, 'page'=>'4'
		, 'order'=>'DESC'
		, 'type'=>'single'
	),$atts));

	$args = Array(
		'post_type'=>'jv_events',
		'post_status'=>'publish',
		'posts_per_page'=>$page,
		'order'=>$order,
		'orderby'=>'post_date',
		'tax_query'=> Array()
	);
	/*get categories */
	if($category!=''){
		$args['tax_query'][] = Array(
			'taxonomy'=> 'jv_events_category',
			'field'=> 'tern_id',
			'terms'=> $category
		);
	}	

	/*category,type,city check(end) */
	ob_start();?>
	<div class="sc-wrap" id="javo-sc-events-listing">
		<div class="sc-items sc-item-long-line-box">
			<div class='row'>
				
				<?php
				$thumbnail = '';
				if($type=='single'){
					// BOARD TYPE
					/*$javo_events_posts = new WP_Query($args);

					?>
					<table class="table table-striped table-hover table-responsive table-condensed">
						<tr>
							<th><?php _e('', 'javo_fr');?></th>
							<th><?php _e('Subject', 'javo_fr');?></th>
							<th><?php _e('Type', 'javo_fr');?></th>
							<th><?php _e('Author', 'javo_fr');?></th>
						</tr>
						<?php
						if( $javo_events_posts->have_posts() ){ //posts != null
							while( $javo_events_posts->have_posts() ){
								$javo_events_posts->the_post();
								$post = get_post( get_the_ID() );
								$javo_shortcode_str = new get_char($post);
								## Picture and Text Type ###############
								if(has_post_thumbnail()){
									$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'javo-tiny');
									$thumbnail = $thumbnail[0];
								};?>
								<tr>
									<td>
										<a href="<?php the_permalink();?>">
											<?php the_post_thumbnail(Array(35, 35), Array('class'=>'img-responsive'));?>
										</a>
									</td>
									<td>
										<a href="<?php the_permalink();?>">
											<?php the_title();?>
										</a>
									</td>
									<td><?php echo $javo_shortcode_str->__cate('jv_events_category', 'No Status', true);?></td>
									<td><?php the_author_meta('user_login');?></td>
								</tr>
								<?php
							};
						}else{
							printf('<tr><td colspan="4">%s</td></tr>', __('No Posts', 'javo_fr'));
						}?>
					</table>*/
					
					$javo_event_slider_args = Array(
						'post_type'=> 'jv_events'
						, 'post_status'=> 'publish'
						, 'posts_per_page'=>-1
					);
					// NORMAL TYPE
					$javo_item_event = new wp_query($args);
					
					$javo_event_columns_slice = 12;
					$javo_event_columns = 1;
					
					ob_start();?>
					<div class="javo-event-item-slider single-event-col">
						<div class="row">
							<div class="col-md-offset-9 col-md-3">
								<!-- Controls -->
								<div class="controls pull-right hidden-xs">
									<a class="left fa fa-chevron-left btn btn-success btn-circle btn-white" href="#javo-event-item-slider-container" data-slide="prev"></a>
									<a class="right fa fa-chevron-right btn btn-success btn-circle btn-white" href="#javo-event-item-slider-container" data-slide="next"></a>
									
								</div>
							</div>
						</div>


						<div id="javo-event-item-slider-container" class="carousel slide" data-ride="carousel">
							<!-- Wrapper for slides -->
							<div class="carousel-inner">
							<?php
							for(
								$i=0;
								$i < ceil($javo_item_event->post_count / (int)$javo_event_columns);
								$i++
							){
								?>
									<div class="item<?php echo $i==0? ' active':'';?>">
										<div class="row">
										<?php
										$javo_event_slider_args['offset'] = $i * $javo_event_columns;
										$javo_event_slider_args['posts_per_page'] = $javo_event_columns;
										$javo_this_event_posts = new WP_Query($javo_event_slider_args);
										if( $javo_this_event_posts->have_posts() ){
											while($javo_this_event_posts->have_posts()){
												$javo_this_event_posts->the_post();
												$javo_get_parent_id = (int)get_post_meta(get_the_ID(), 'parent_post_id', true);
												$javo_get_parent = get_post($javo_get_parent_id);
												$javo_get_parent_url = get_permalink($javo_get_parent->ID).'#item-event';
												?>
													<div class="col-sm-<?php echo $javo_event_columns_slice;?> pull-left">
														
															<div class="row">
																<div class="col-md-12 text-center">
																	<div class="javo-shortcode-event-listing one-col-event">
																		
																		<?php
																		if ( has_post_thumbnail() ) {
																			the_post_thumbnail('javo-box', Array('class'=> 'img-responsive'));
																		}else{
																			printf('<img src="%s" class="img-responsive">', JAVO_IMG_DIR.'/no_image.gif');
																		};?>
																		<div class="javo-event-one-col">
																			<a href="<?php echo $javo_get_parent_url;?>">
																				<?php echo $javo_get_parent->post_title;?>
																				<div class="offer">
																					<?php the_title();?><br/>
																				</div>
																				<div class="javo-event-one-col-content">
																					<?php echo javo_str_cut(get_the_excerpt(), 400);?>
																				</div><!-- events-content-->
																			</a>
																		</div> <!-- javo-shop-name-->
																	</div><!-- javo-shortcode-event-listing-->
																</div>
															</div>			
														
													</div>
												<?php								
											}; // Close While			
										}else{
											?>
											<div class="col-md-12">
												<?php _e('No found event posts.', 'javo_fr');?>
											</div>
											<?php
										}; // Close if
										?>
										</div>
									</div>
								<?php				
							}; // Close For
							?>
							</div><!-- Carousel Inner -->
						</div><!-- Slider Container -->
					</div><!-- Slider Shortcode Wrap -->
					<?php
				}else{ // $type != 'single'
					

				$javo_event_slider_args = Array(
					'post_type'=> 'jv_events'
					, 'post_status'=> 'publish'
					, 'posts_per_page'=>-1
				);

					// NORMAL TYPE
					$javo_item_event = new wp_query($args);
					if($type=='two-cols'){
						$javo_event_columns_slice = 6;
						$javo_event_columns = 2;
					}else if($type=='three-cols'){
						$javo_event_columns_slice = 4;
						$javo_event_columns = 3;
					}else{
						$javo_event_columns_slice = 3;
						$javo_event_columns = 4;
					}
					ob_start();?>
					<div class="javo-event-item-slider">
						<?php echo apply_filters('javo_shortcode_title', $title, $sub_title, Array('title'=>'color:'.$title_text_color.';', 'subtitle'=>'color:'.$sub_title_text_color.';',  'line'=>'border-color:'.$line_color.';'));?>
						<div class="row">
							<div class="col-md-offset-9 col-md-3">
								<!-- Controls -->
								<div class="controls pull-right hidden-xs">
									<a class="left fa fa-chevron-left btn btn-success btn-circle btn-white" href="#javo-event-item-slider-container" data-slide="prev"></a>
									<a class="right fa fa-chevron-right btn btn-success btn-circle btn-white" href="#javo-event-item-slider-container" data-slide="next"></a>
								</div>
							</div>
						</div>
						<div id="javo-event-item-slider-container" class="carousel slide" data-ride="carousel">
							<!-- Wrapper for slides -->
							<div class="carousel-inner">
							<?php							
							for(
								$i=0;
								$i < ceil($javo_item_event->found_posts / (int)$javo_event_columns);
								$i++
							){
								?>
									<div class="item<?php echo $i==0? ' active':'';?>">
										<div class="row">
										<?php
										$javo_event_slider_args['offset'] = $i * $javo_event_columns;
										$javo_event_slider_args['posts_per_page'] = $i < ceil($javo_item_event->found_posts / (int)$javo_event_columns)-1 ? $javo_event_columns : $page;
										$javo_this_event_posts = new WP_Query($javo_event_slider_args);
										if( $javo_this_event_posts->have_posts() ){
											while($javo_this_event_posts->have_posts()){
												$javo_this_event_posts->the_post();
												$javo_get_parent_id		= (int)get_post_meta(get_the_ID(), 'parent_post_id', true);
												$javo_get_parent		= get_post($javo_get_parent_id);
												$javo_get_parent_url	= get_permalink($javo_get_parent->ID).'#item-event';
												$javo_meta_query		= new javo_GET_META( $javo_get_parent_id );
												?>
													<div class="col-sm-<?php echo $javo_event_columns_slice;?> pull-left javo-second-event-wrap">
														
															<div class="row">
																<div class="col-md-12 text-center">
																	<div class="javo-second-event-listing ">
																	<!-- <div class="javo-shortcode-event-listing"> -->
																		<div class="event-inner-overlay-bg">
																			<a href="<?php echo $javo_get_parent_url;?>">
																				<div class="event-image-inner-top">
																					<div class="offer">
																						<?php the_title();?>
																					</div><!-- offer -->
																				</div><!-- event-image-inner-top -->																					
																				<div class="col-md-7 events-content">
																					<?php echo javo_str_cut(get_the_excerpt(), 70);?>
																				</div><!-- events-content-->
																				
																			</a>
																		</div><!-- event-inner-overlay-bg -->
																		<?php
																		if ( has_post_thumbnail()) {
																			if($javo_event_columns != 2){
																				the_post_thumbnail('javo-box', Array('class'=> 'img-responsive'));
																			}else{
																				the_post_thumbnail('javo-box-v', Array('class'=> 'img-responsive'));
																			}
																		}else{
																			printf('<img src="%s" class="img-responsive">', JAVO_IMG_DIR.'/no_image.gif');
																		};?>

																		<div class="item-name">
																			<span class="top-small-post-title">
																				<?php
																				if(strlen($javo_get_parent->post_title)>30) echo substr($javo_get_parent->post_title, 0, 30).'...'; 
																				else echo $javo_get_parent->post_title;
																				?>
																			</span>																	
																		</div> <!-- item-name -->
																	</div><!-- javo-shortcode-event-listing -->

																	<div class="javo-left-overlay bg-black">
																		<?php if( get_post_meta( get_the_ID(), 'brand', true) != ""){ ?>
																			<div class="javo-txt-meta-area admin-color-setting">
																				<?php echo get_post_meta( get_the_ID(), 'brand', true);?>
																			</div> <!-- javo-txt-meta-area -->
																			<div class="corner-wrap ">
																				<div class="corner admin-color-setting"></div>
																				<div class="corner-background admin-color-setting"></div>
																		</div> <!-- corner-wrap -->
																		<?php }; ?>
																		
																	</div>
																</div>
															</div>			
														
													</div>
												<?php								
											}; // Close While			
										}else{
											?>
											<div class="col-md-12">
												<?php _e('No found event posts.', 'javo_fr');?>
											</div>
											<?php
										}; // Close if
										wp_reset_query(); ?>
										</div>
									</div>
								<?php				
							}; // Close For
							?>
							</div><!-- Carousel Inner -->
						</div><!-- Slider Container -->
					</div><!-- Slider Shortcode Wrap -->
				<?php
						
					
									} // else ?>
			</div><!-- row-->
		</div> <!-- sc-items -->
	</div> <!-- sc-wrap -->
	<?php
	$content = ob_get_clean();
	return $content;
	}