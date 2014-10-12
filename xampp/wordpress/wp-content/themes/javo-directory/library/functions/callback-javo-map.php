<?php
add_action('wp_ajax_nopriv_javo_map', 'javo_map_callback');
add_action('wp_ajax_javo_map', 'javo_map_callback');
add_filter('javo_map_info_content', 'javo_map_info_content_callback');

function javo_map_callback(){

	$javo_query = new javo_array($_POST);

	$javo_this_posts_args = Array(
		'post_status'=> 'publish'
		, 'post_type'=> $javo_query->get('post_type', 'post')
		, 'posts_per_page'=> $javo_query->get('ppp', 20)
		, 'paged'=> (int)$javo_query->get('current', 1)
		, 'order'=> $javo_query->get('order', 'DESC')
	);

	if( $javo_query->get('filter', null) != null){

		if( is_Array( $javo_query->get('filter') ) ){

			foreach( $javo_query->get('filter') as $taxonomy => $terms ){

				if( !empty( $terms) ){
					$javo_this_posts_args['tax_query']['relation'] = 'AND';
					$javo_this_posts_args['tax_query'][] = Array(
						'taxonomy'	=> $taxonomy
						, 'field'	=> 'term_id'
						, 'terms'	=> $terms
					);
				};
			};
		};
	}; // End Filter
	if( $javo_query->get('keyword', null) != null){
		$javo_this_posts_args['s'] = $javo_query->get('keyword');
	};
	ob_start();
	switch( $javo_query->get('panel', 'list') ){
		case 'featured':
			$javo_this_posts_args['meta_query']['relation'] = 'AND';
			$javo_this_posts_args['meta_query'][]			= Array(
				'key'		=> 'javo_this_featured_item'
				, 'compare'	=> '='
				, 'value'	=> 'use'			
			); ?>
			<h2><?php _e('Featured Items', 'javo_fr');?></h2>
			<?php
		break;
		case 'favorite':
			$javo_this_posts_args							= Array( 'post_type'=> $javo_query->get('post_type', 'post')	);	
			$javo_this_user_favorite						= (Array)get_user_meta( get_current_user_id(), 'favorites', true);
			$javo_this_user_favorite_posts					= Array('0');
			if( !empty($javo_this_user_favorite) ){
				foreach( $javo_this_user_favorite as $favorite ){
					if(!empty($favorite['post_id'] ) ){
						$javo_this_user_favorite_posts[]	= $favorite['post_id'];
					};
				}; // End foreach
			}; // End if
			$javo_this_posts_args['post__in']				= (Array)$javo_this_user_favorite_posts;
			?>

			<h2><?php _e('My Favorites', 'javo_fr');?></h2>

			<?php
		break;
		case 'list':
		default:
	};
	$javo_this_content_prepend = ob_get_clean();
	$javo_this_posts_markers = Array();
	$javo_this_posts = new WP_Query($javo_this_posts_args);
	ob_start();
	if( $javo_this_posts->have_posts() ){		
		while( $javo_this_posts->have_posts() ){
			$javo_this_posts->the_post();
			$javo_this_author_avatar_id = get_the_author_meta('avatar');
			$javo_meta_query			= new javo_GET_META( get_the_ID() );
			?>
			<div class='row javo_somw_list_inner'>
				<div class='col-sm-3'>
					<?php the_post_thumbnail( Array(50, 50) );?>
				</div><!-- col-md-3 thumb-wrap -->

				<div class='cols-sm-9 meta-wrap'>
					<div class='javo_somw_list'>
						<a href='javascript:' class='javo-hmap-marker-trigger' data-id="<?php echo 'mid_'.get_the_ID();?>" data-post-id="<?php the_ID();?>"><?php echo javo_str_cut( get_the_title(), 40);?></a>
					</div>
					<div class='javo_somw_list'>
						<?php printf('%s / %s', $javo_meta_query->cat('item_category', __('No Category', 'javo_fr')), $javo_meta_query->cat('item_location', __('No Location', 'javo_fr')));?>
					
					
					</div>
				</div><!-- col-md-9 meta-wrap -->
			</div><!-- row -->



			<?php
			$javo_this_geolocation = @unserialize(get_post_meta( get_the_ID(), 'latlng', true));
			$javo_this_posts_markers[ get_the_ID() ] = Array(
				'lat'=> $javo_this_geolocation['lat']
				, 'lng'=> $javo_this_geolocation['lng']
				, 'content'=> apply_filters( 'javo_map_info_content', get_the_ID() )
			);
		}; // End While
	}else{
		_e('No found posts', 'javo_fr');
	}; // End If

	$big = 999999999; // need an unlikely integer
	$javo_this_pagination = paginate_links( array(
		'base' => "%_%",
		'format' => '?%#%',
		'current' => (int)$javo_query->get('current', 1),
		'prev_text'    => __('< Prev' , 'javo_fr'),
		'next_text'    => __('Next >' , 'javo_fr'),
		'total' => $javo_this_posts->max_num_pages,
		'before_page_number'=> '<span class="javo-hmap-pagination">',
		'after_page_number'=> '</span>'
	) );
	printf('<div class="clearfix"></div><div class="javo-hmap-pagination-wrap margin-10">%s</div>', $javo_this_pagination);
	$javo_this_content_htmls = ob_get_clean();
	wp_reset_query();
	echo json_encode(Array(
		'html'=> $javo_this_content_prepend.$javo_this_content_htmls
		, 'markers'=> $javo_this_posts_markers
	));
	exit;
}

function javo_map_info_content_callback($post_id){
	// Map InfoWindow Contents Filter
	$javo_this_post = get_post( $post_id );
	$javo_meta_query = new javo_get_meta( $post_id );
	$javo_this_author_avatar_id = get_the_author_meta('avatar');
	$javo_this_author_avatar_name = sprintf('%s %s', get_the_author_meta('first_name'), get_the_author_meta('last_name'));
	ob_start();
	?>
	<div class="javo_somw_info panel" style="overflow:hidden;">
	
		<h4><strong><?php the_title();?></strong></h4>

		<div class="des">
			<ul class="list-unstyled">
				<li><div class="prp-meta"><?php echo $javo_meta_query->get('phone');?>
				<li><div class="prp-meta"><?php echo $javo_meta_query->get('mobile');?>
				<li><div class="prp-meta"><?php echo $javo_meta_query->get('website');?>
				<li><div class="prp-meta"><?php echo $javo_meta_query->get('email');?>
			</ul>
			<hr />
			<div class="lister">
				<span class="thumb">
					<?php echo wp_get_attachment_image($javo_this_author_avatar_id, 'javo-avatar');?>
				</span>
				<ul class="list-unstyled">
					<li><?php echo $javo_this_author_avatar_name;?></li>
					<li><?php echo get_the_author_meta('phone');?></li>
					<li><?php echo get_the_author_meta('mobile');?></li>
				</ul>
			</div> <!-- lister -->
		</div> <!-- des -->

		<div class="pics">
			<div class="thumb">
				<a href="<?php the_permalink();?>" target="_blank"><?php the_post_thumbnail('javo-map-thumbnail'); ?></a>
			</div> <!-- thumb -->
			<div class="img-in-text"><?php _e('Category', 'javo_fr');?></div>
			<div class="javo-left-overlay">
				<div class="javo-txt-meta-area"><?php _e('Location', 'javo_fr');?></div>
				<div class="corner-wrap">
					<div class="corner"></div>
					<div class="corner-background"></div>
				</div> <!-- corner-wrap -->
			</div> <!-- javo-left-overlay -->
		</div> <!-- pic -->

		<div class="row"><h3>&nbsp;</h3></div>

		<div class="row">
			<div class="col-md-12">
				<div class="btn-group btn-group-justified pull-right">
					<a class="btn btn-primary btn-sm javo-map-load-brief" onclick="javo_map.brief_run(this);" data-id="<?php echo get_the_ID();?>">
						<i class="fa fa-user"></i> <?php _e("Brief", "javo_fr"); ?>
					</a>
					<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">
						<i class="fa fa-group"></i> <?php _e("Detail", "javo_fr"); ?>
					</a>
					<a href="javascript:" class="btn btn-primary btn-sm" onclick="javo_map.contact_run(this)" data-to="<?php the_author_meta('user_email');?>">
						<?php _e("Contact", "javo_fr"); ?>
					</a>
				 </div><!-- btn-group -->
			</div> <!-- col-md-12 -->
		</div> <!-- row -->
	</div> <!-- javo_somw_info -->

	<?php
	return ob_get_clean();
}