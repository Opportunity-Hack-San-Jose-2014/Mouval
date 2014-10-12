<?php
/*
define default functions.
*/

function javo_get_script($fn=NULL, $name="javo", $ver="0.0.1", $bottom=true){
	wp_register_script($name, get_template_directory_uri().'/assets/js/'.$fn, Array('jquery'), $ver, $bottom);
	wp_enqueue_script($name);
};
function javo_get_style($fn=NULL, $name="javo", $ver="0.0.1", $media="all"){
	wp_register_style( $name, get_template_directory_uri().'/css/'.$fn, NULL, $ver, $media );
	wp_enqueue_style($name);
};
function javo_get_asset_script($fn=NULL, $name="javo", $ver="0.0.1", $bottom=true){
	wp_register_script($name, get_template_directory_uri().'/assets/js/'.$fn, Array('jquery'), $ver, $bottom);
	wp_enqueue_script($name);
};
function javo_get_asset_style($fn=NULL, $name="javo", $ver="0.0.1", $media="all"){
	wp_register_style( $name, get_template_directory_uri().'/assets/css/'.$fn, NULL, $ver, $media );
	wp_enqueue_style($name);
};

function javo_get_count_in_taxonomy($term_id, $taxonomy='item_category', $post_type='item'){
	$javo_this_return = get_posts(Array(
		'post_type'			=> $post_type
		, 'post_status'		=> 'publish'
		, 'posts_per_page'	=> -1
		, 'tax_query'		=> Array(
			Array(
				'taxonomy'	=> $taxonomy
				, 'field'	=> 'term_id'
				, 'terms'	=> $term_id			
			)			
		)
	));
	return (int)count($javo_this_return);
}






function javo_get_cat($post_id = NULL, $tax_name = NULL, $default=NULL, $return_array = false){
	if($post_id == NULL || $tax_name == NULL) return;
	$terms = wp_get_post_terms($post_id, $tax_name);
	if($terms != NULL){
		$output = "";
		if(!$return_array){
			foreach($terms as $item) $output .= $item->name.", ";
			return substr(trim($output), 0, -1);
		}else{
			return $terms;
		};
	}else{
		if(!$return_array) return $default;
	};
	return false;
};
function javo_str_cut($str, $strLength=10){ return (mb_strlen($str) > $strLength) ? mb_substr($str, 0, $strLength, "utf8")."..." : $str; };
global $javo_filter_prices;
$javo_filter_prices = Array(
	"1000"=>	"$1,000"
	, "5000"=>	"$5,000"
	, "10000"=> "$10,000"
	, "50000"=> "$50,000"
	, "100000"=> "$100,000"
	, "200000"=> "$200,000"
	, "300000"=> "$300,000"
	, "400000"=> "$400,000"
	, "500000"=> "$500,000"
	, "600000"=> "$600,000"
	, "700000"=> "$700,000"
	, "800000"=> "$800,000"
	, "900000"=> "$900,000"
	, "1000000"=> "$1,000,000"
	, "1500000"=> "$1,500,000"
	, "2000000"=> "$2,000,000"
	, "2500000"=> "$2,500,000"
	, "5000000"=> "$5,000,000"
);
add_filter( 'redirect_canonical', 'javo_lister_redirect_disabled' );
function javo_lister_redirect_disabled( $redirect_url ) {
	if ( is_singular( 'lister' ) )
		$redirect_url = false;
	return $redirect_url;
};

function javo_str($content, $return_value=NULL){
	return !empty($content) ? $content : $return_value;
};


//**** login and logout affix position setting
add_filter('body_class', 'javo_mbe_body_class');
function javo_mbe_body_class($classes){
    if(is_user_logged_in()){
        $classes[] = 'body-logged-in';
    } else{
        $classes[] = 'body-logged-out';
    }
    return $classes;
}

//add_action('wp_head', 'javo_mbe_wp_head');
function javo_mbe_wp_head(){
    echo '<style>'.PHP_EOL;
    //echo 'body{ padding-top: 48px !important; }'.PHP_EOL;
    // Using custom CSS class name.
    echo 'body.body-logged-in #stick-nav.affix{ top: 28px !important; }'.PHP_EOL;

	// For affix top bar
	echo 'body.body-logged-out #stick-nav.affix{ top: 0px !important; }'.PHP_EOL;

    // Using WordPress default CSS class name.
    echo 'body.logged-in #stick-nav.affix{ top: 28px !important; }'.PHP_EOL;
    echo '</style>'.PHP_EOL;
}

add_action('admin_init', 'javo_current_user_upload_role_callback');
function javo_current_user_upload_role_callback(){
	$javo_get_cur_role = wp_get_current_user()->add_cap('upload_files');
}

// Post Expired then, display off
add_action('pre_get_posts', 'javo_expired_post_check_callback');
function javo_expired_post_check_callback($query){
	global $javo_tso, $post, $wp_query;

	if( $query->is_main_query() ) return;
	if( $query->get('post_type') == 'attachment'){
		$query->set('author', wp_get_current_user()->ID);
	}
	
	
	if( is_array($query->get('post_type'))){
		if(!in_array('item', $query->get('post_type'))) return;
	}else{
		if(!($query->get('post_type') == 'item')) return;
	};
	if( $javo_tso->get('item_publish', '') == '') return;
	if( $wp_query->get('shop') != '' ){ return; };

	$javo_pre_meta_query = $query->get('meta_query');
	$javo_pre_meta_query['relation'] = 'AND';
	$javo_pre_meta_query[] = Array(
		"key" => "item_expired"
		, "type"=> "DATE"
		, "value" => date('YmdHis')
		, "compare" => ">="
	);
	$query->set('meta_query', $javo_pre_meta_query);
}


// sns cycle style 
function javo_sns_cycle($post=null, $class_name="javo-share-icons"){

	if(empty($post)) return false;
	$javo_cur_favorites = (Array)get_user_meta(get_current_user_id(), "favorites", true);
	$favied = in_Array($post->ID, $javo_cur_favorites)? true: false;
	ob_start();?>
	<div class="social-wrap <?php echo $class_name;?>">
		<p class="social">
			<span>
				<i class="sns-facebook" data-title="<?php echo $post->post_title;?>" data-url="<?php echo get_permalink($post->ID);?>"><a class="facebook"></a></i>
				<i class="sns-twitter" data-title="<?php echo $post->post_title;?>" data-url="<?php echo get_permalink($post->ID);?>"><a class="twitter"></a></i>
				<a href="javascript:" data-post-id="<?php echo $post->ID;?>" class="save-icon javo_favorite<?php echo $favied ?' saved':'';?>"><?php echo $favied ? __('Unsave', 'javo_fr') : __('Save', 'javo_fr');?></a>
			</span>
		</p>
	</div> <!-- sc-social-wrap -->
	<?php
	return ob_get_clean();
}


function javo_user_get_post_count($user_id, $post_type){
	$javo_this_get_posts = get_posts(Array(
		'post_type'=> $post_type
		, 'author'=> $user_id
		, 'showposts'=> -1
	));
	wp_reset_query();
	return count($javo_this_get_posts);
}

add_filter('javo_shortcode_title', 'javo_shortcode_title_callback', 10, 3);
function javo_shortcode_title_callback($title, $sub_title='', $styles=Array('title'=>'', 'subtitle'=>'', 'line'=>'')){
	if( $title == "" ){ return false; };
	$javo_this_query = new javo_ARRAY( $styles );
	ob_start();?>
	<div class="javo-fancy-title-section">
		<h2 style="<?php echo $javo_this_query->get('title');?>"><?php _e($title, 'javo_fr');?></h2>
		<div class="hr-wrap">
			<span class="hr-inner" style="<?php echo $javo_this_query->get('line');?>">
				<span class="hr-inner-style"></span>
			</span>
		</div> <!-- hr-wrap -->
		<div class="javo-fancy-title-description text-center" style="position:relative;">
			<div style="<?php echo $javo_this_query->get('subtitle');?>">
				<?php _e($sub_title, 'javo_fr');?>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
};

/**
* Add title back to images
*/
function pexeto_add_title_to_attachment( $markup, $id ){
	$att = get_post( $id );
	return str_replace('<a ', '<a title="'.$att->post_title.'" ', $markup);
}
add_filter('wp_get_attachment_link', 'pexeto_add_title_to_attachment', 10, 5);


