<?php
/************************************************
**	Ajax Process
************************************************/
class javo_ajax_propcess{

	public function __construct(){
		// item, lister Avatar, Admin panel Image upload.
		add_action("wp_ajax_nopriv_image_uploader", Array($this, "image_uploader"));
		add_action("wp_ajax_image_uploader", Array($this, "image_uploader"));

		// item search on the map Ajax.
		add_action("wp_ajax_nopriv_get_map", Array($this, "get_map"));
		add_action("wp_ajax_get_map", Array($this, "get_map"));

		// lister contact mail
		add_action("wp_ajax_nopriv_send_mail", Array($this, "send_mail"));
		add_action("wp_ajax_send_mail", Array($this, "send_mail"));

		// Add item
		add_action("wp_ajax_nopriv_add_item", Array($this, "add_item"));
		add_action("wp_ajax_add_item", Array($this, "add_item"));

		// Add Review
		add_action("wp_ajax_nopriv_add_review", Array($this, "add_review"));
		add_action("wp_ajax_add_review", Array($this, "add_review"));

		// Add Event
		add_action("wp_ajax_nopriv_add_event", Array($this, "add_event"));
		add_action("wp_ajax_add_event", Array($this, "add_event"));

		// Delete item
		add_action("wp_ajax_nopriv_trash_item", Array($this, "trash_item"));
		add_action("wp_ajax_trash_item", Array($this, "trash_item"));

		// Link Mail
		add_action("wp_ajax_nopriv_emailme", Array($this, "emailme"));
		add_action("wp_ajax_emailme", Array($this, "emailme"));

		// Publish item
		add_action("wp_ajax_nopriv_publish_item", Array($this, "publish_item"));
		add_action("wp_ajax_publish_item", Array($this, "publish_item"));

		// Pause item
		add_action("wp_ajax_nopriv_pause_item", Array($this, "pause_item"));
		add_action("wp_ajax_pause_item", Array($this, "pause_item"));

		add_action("wp_ajax_nopriv_get_detail_images", Array($this, "get_detail_images"));
		add_action("wp_ajax_get_detail_images", Array($this, "get_detail_images"));
	}
	public function get_detail_images(){
		ob_start();
		$javo_query = new javo_array($_POST);
		$javo_this_post_id = $javo_query->get('post_id');
		$javo_this_detail_images = @unserialize(get_post_meta($javo_this_post_id, "detail_images", true));
		if(!empty($javo_this_detail_images)){
			foreach($javo_this_detail_images as $index => $image){
				$img_src = wp_get_attachment_image($image, 'medium', 1, Array( 'class'=> 'img-responsive'));
				printf("<li>%s</li>",$img_src);
					
			};
		};

		$javo_this_content = ob_get_clean();
		echo json_encode(Array(
			'result'=> $javo_this_content
		));
		exit;
	}	
	public function pause_item(){

		$return_args = Array();

		if((int)$_POST['post'] > 0 ){
			$this_post_args = Array('ID'=> (int)$_POST['post']);

			if(isset($_POST['publish']) && $_POST['publish'] == "true"){
				$this_post_args['post_status'] = "publish";
			}else{
				$this_post_args['post_status'] = "pending";
			};
			$post_id = wp_update_post($this_post_args);
			$return_args['state'] = "success";
		}else{
			$return_args['state'] = "fali";
			$return_args['comment'] = "Post id not found.";
		}
		echo json_encode($return_args);
		exit;
	}

	public function publish_item(){
		$javo_query = new javo_array($_POST);
		$javo_pj_return = Array();

		if( (int)$javo_query->get('post_id') > 0){
			if( (int)$javo_query->get('user_id') > 0){
				if( (int)$javo_query->get('item_id') > 0){

					$javo_pay_meta = new javo_get_meta( $javo_query->get('item_id') );
					$jav_pay_cnt_cur = (int)$javo_pay_meta->_get('pay_cnt_post');
					$jav_pay_day_cur = (int)$javo_pay_meta->_get('pay_expire_day');

					if($jav_pay_cnt_cur > 0){

						$post_id = wp_update_post(Array(
							"ID"=> (int)$javo_query->get('post_id')
							, "post_status"=> "publish"
						));
						// Use items
						$jav_pay_cnt_cur--;
						update_post_meta($javo_query->get('item_id'), "pay_cnt_post", $jav_pay_cnt_cur);
						update_post_meta($post_id, "item_expired", date('YmdHis', strtotime($jav_pay_day_cur.' days')));

						$javo_pj_return['expired'] = date('Y-m-d', strtotime('2014-05-05'));
						$javo_pj_return['status'] = 'success';
						$javo_pj_return['permalink'] = get_permalink($post_id);

					}else{
						$javo_pj_return['status'] = 'fail';
						$javo_pj_return['comment'] = __('Not have items in payment item', 'javo_fr');
					};
				}else{
					$javo_pj_return['status'] = 'fail';
					$javo_pj_return['comment'] = __('Not found payment', 'javo_fr');
				};
			}else{
				$javo_pj_return['status'] = 'fail';
				$javo_pj_return['comment'] = __('Not found user', 'javo_fr');
			};
		}else{
			$javo_pj_return['status'] = 'fail';
			$javo_pj_return['comment'] = __('Not found item posting', 'javo_fr');
		};
		echo json_encode($javo_pj_return);
		exit(0);
	}

	public function emailme(){
		$email		= $_POST['from_emailme_email'];
		$sender		= $_POST['to_emailme_email'];
		$link		= $_POST['emailme_link'];
		$content	= $_POST['emailme_memo'];
		$headers = Array();
		$headers[] = 'From: <'.$sender.'>';
		$sendok		= wp_mail($email, "Share mail", "Link: <a href='".$link."' target='_blank'>".$link."</a><br>Memo: ".$content, $headers);
		$args = Array( "result" => $sendok );
		echo json_encode($args);
		exit(0);
	}
	public function trash_item(){
		$post_id = (int)$_POST['post'];
		$cur = get_current_user_id();
		if((int)get_post($post_id)->post_author == (int)$cur){
			wp_delete_post($post_id, true);
			$state = "success";
		}else{
			$state = "reject";
		};
		echo json_encode(Array(
			'result'=> $state
			,'post'=> $post_id
		));
		exit(0);
	}
	public function add_item(){

		global $javo_tso;

		$paid = $javo_tso->get('item_publish', '') != ''? true : false;

		$javo_query = new javo_array($_POST);
		$map_latlng = $_POST['javo_location'];
		$args = Array(
			"post_title"=> $_POST['txt_title']
			, "post_content"=> $_POST['txt_content']
			, "post_author"=> get_current_user_id()
			, "post_type"=> "item"
		);
		$edit = $_POST['edit'] ? get_post($_POST['edit']) : false;
		if($edit){
			$args["ID"] = $edit->ID;
		}else{
			$args['post_status'] = $paid ? 'pending' : 'publish';
		};
		$post_id = ($edit)? wp_update_post($args) : wp_insert_post($args);

		// Featured Image Setup
		set_post_thumbnail($post_id, $_POST['javo_featured_url']);

		// Set categories.
		wp_set_post_terms($post_id, $javo_query->get('sel_category'), "item_category");
		wp_set_post_terms($post_id, $javo_query->get('sel_location'), "item_location");

		if($post_id){
			//
			$src =  isset($_POST['javo_featured_file'])?$_POST['javo_featured_file']:NULL;
			$detail = Array();
			if(isset($_POST['javo_dim_detail']) && is_Array($_POST['javo_dim_detail'])){
				foreach($_POST['javo_dim_detail'] as $item => $value ) $detail[] = $value;
			};

			$detail = @serialize($detail);

			// Google Maps LatLng
			$latlng = @serialize($map_latlng);
			update_post_meta($post_id, "latlng", $latlng);

			
			$javo_directory_meta = $javo_query->get('javo_meta');
			$javo_directory_meta = $javo_directory_meta != null? @serialize($javo_directory_meta) : null;
			update_post_meta($post_id, 'directory_meta', $javo_directory_meta);
			update_post_meta($post_id, "detail_images", $detail);
			update_post_meta($post_id, "page_backgrounds", $javo_query->get('javo_page_bg'));
		};

		echo json_encode(Array(
			"result"=> ((int)$post_id > 0 ? true : false)
			, "link"=> get_permalink($post_id)
			, "status"=> ($edit ? "edit" : "new")
			, "post_id"=> $post_id
			, 'paid'=> $paid
		));
		exit(0);
	}
	public function add_review(){
		global $javo_tso;

		$javo_query = new javo_array($_POST);

		$args = Array(
			"post_title"=> $_POST['txt_title']
			, "post_content"=> $_POST['txt_content']
			, "post_author"=> get_current_user_id()
			, "post_type"=> "review"
		);
		$edit = !empty($_POST['edit']) ? get_post($_POST['edit']) : false;
		if($edit){
			$args["ID"] = $edit->ID;
		}else{
			$args['post_status'] = 'publish';
		};
		$post_id = ($edit)? wp_update_post($args) : wp_insert_post($args);
		set_post_thumbnail($post_id, $javo_query->get('img_featured', ''));

		update_post_meta($post_id, 'parent_post_id', $javo_query->get('txt_parent_post_id'));

		echo json_encode(Array(
			"result"=> ((int)$post_id > 0 ? true : false)
			, "link"=> get_permalink($post_id)
			, "status"=> ($edit ? "edit" : "new")
			, "post_id"=> $post_id
		));
		exit(0);
	}
	public function add_event(){
		global $javo_tso;

		$javo_query = new javo_array($_POST);

		$args = Array(
			"post_title"=> $_POST['txt_title']
			, "post_content"=> $_POST['txt_content']
			, "post_author"=> get_current_user_id()
			, "post_type"=> "jv_events"
		);
		$edit = !empty($_POST['edit']) ? get_post($_POST['edit']) : false;
		if($edit){
			$args["ID"] = $edit->ID;
		}else{
			$args['post_status'] = 'publish';
		};
		$post_id = ($edit)? wp_update_post($args) : wp_insert_post($args);
		set_post_thumbnail($post_id, $javo_query->get('img_featured', ''));
		update_post_meta($post_id, 'parent_post_id', $javo_query->get('txt_parent_post_id'));
		update_post_meta($post_id, 'brand', $javo_query->get('txt_brand'));

		echo json_encode(Array(
			"result"=> ((int)$post_id > 0 ? true : false)
			, "link"=> get_permalink($post_id)
			, "status"=> ($edit ? "edit" : "new")
			, "post_id"=> $post_id
		));
		exit(0);
	}
	public function send_mail(){
		$meta = Array(
			'to'=> $_POST['to']
			, 'subject'=> $_POST['subject']
			, 'from'=> sprintf("From: <%s>", $_POST['from'])
			, 'content'=> $_POST['content']
		);
		$mailer = wp_mail($meta['to'], $meta['subject'], $meta['content'], $meta['from']);
		$result = Array("result"=>$mailer);
		echo json_encode($result);
		exit(0);
	}

	##############################################################
	##############################################################
	##############################################################
	##############################################################
	##############################################################
	##############################################################
	##############################################################
	##############################################################

	public function image_uploader(){
		require_once ABSPATH."wp-admin".'/includes/file.php';
		require_once ABSPATH.'wp-admin/includes/image.php';

		// Variable Initialize
		$args = Array("post_content"=> "", "post_type"=> "attachment");

		if($_POST['featured'] == "true" )
		{
			// Featured Image Upload
			$file = wp_handle_upload($_FILES["javo_featured_file"], Array("test_form"=>false));
			$args['post_title'] = $_FILES['javo_featured_file']['name'];
		}
		else if( $_POST['featured'] == "false" )
		{
			// Detail Image Upload
			$file = wp_handle_upload($_FILES['javo_detail_file'], Array("test_form"=>false));
			$args['post_title'] = sprintf("%s Upload to %s"
				, (( is_user_logged_in() )? get_userdata( get_current_user_id() )->user_login : "Guest")
				, $_FILES['javo_detail_file']['name']
			);
		};

		$args['post_mime_type'] = $file['type'];
		$args['guid'] = $file['url'];
		$img_id = wp_insert_attachment($args, $file['file']);
		$attach_data = wp_generate_attachment_metadata( $img_id, $file['file'] );
		wp_update_attachment_metadata( $img_id, $attach_data );
		$url = wp_get_attachment_image_src($img_id, 'javo-large');
		$url = $url[0];
		$json_output = Array(
			"result"=> "success",
			"file_id"=> $img_id,
			"file"=>$url
		);
		echo json_encode($json_output);
		//header("Content-Type: application/json");
		exit(0);
	}

	##############################################################
	##############################################################
	##############################################################
	##############################################################
	##############################################################
	##############################################################
	##############################################################
	##############################################################


	public function get_map(){
		global $javo_tso;

		$lang = $_POST['lang'] != "" ? $_POST['lang'] : "en";

		// Post Types
		$post_type = $_POST['post_type'];

		// Taxonomy
		$tax = $_POST['tax'];

		// Terms
		$term = $_POST['term'];

		// Taxonomy2
		$tax2 = isset($_POST['tax2']) ? $_POST['tax2'] : null;

		// Terms2
		$term2 = isset($_POST['term2']) ? $_POST['term2'] : null;

		// Pagination
		$page = isset($_POST['page'])? $_POST['page']:1;

		// City Parent
		$parent = isset($_POST['parent'])?$_POST['parent']:null;

		// Location Area
		$location = isset($_POST['location'])?$_POST['location']:null;

		// Keywords
		$keyword = !empty($_POST['keyword'])?$_POST['keyword']:null;

		// Posts per page
		$ppp = ($_POST['ppp'])? $_POST['ppp'] : 10;

		// Get City terms id
		if(isset($_POST['city'])):
			$args = Array(
				"parent"=>$term,
				"hide_empty"=>false
			);
			$terms = get_terms($tax, $args);
			$content = "";
			foreach($terms as $item):
				$content .="<option value=".$item->term_id.">".$item->name."</option>";
			endforeach;
			$result = Array(
				"result"=> "success",
				"options"=> $content
			);
			echo json_encode($result);
			exit();
		endif;

		// Category list output
		function javo_get_p_cate($post_id = NULL, $tax = NULL, $default = "None"){
			if($post_id == NULL && $tax == NULL) return;

			// Output Initialize
			$output = "";
			// Get Terms
			$terms = wp_get_post_terms($post_id, $tax);
			// Added string
			foreach($terms as $item){
				$output .= $item->name.", ";
			};
			$output = substr(trim($output), 0, -1);
			return ($output != "")? $output : $default;
		}

		// Google map infoWindow Body
		function infobox($post=NULL){
			if($post == NULL) return;
			global $javo_tso;
			$javo_list_str = new get_char($post);
			// HTML in var
			ob_start();?>
			<div class="javo_somw_info">
				<div class="des">
					<ul>
						<li><?php printf('%s : %s', __('Type', 'javo_fr'), $javo_list_str->__cate('item_category', 'No type', true));?></li>
						<li>
						<?php
						if($javo_tso->get('hidden_lister_email') != 'hidden'){
							echo $javo_list_str->author->user_email;
						};?>
						&nbsp;
						</li>
					</ul>
					<hr />
					<div class="lister">
						<span class="thumb">
							<?php printf("<a href='%s'>%s</a>"
								, $javo_list_str->lister_page
								, $javo_list_str->get_avatar()
							); ?>
						</span>
						<ul>
							<li><?php echo $javo_list_str->author_name;?></li>
							<li><?php echo $javo_list_str->a_meta('phone');?></li>
							<li><?php echo $javo_list_str->a_meta('mobile');?></li>
						</ul>
					</div> <!-- lister -->
				</div> <!-- des -->

				<div class="pics">
					<div class="thumb">
						<a href="<?php echo get_permalink($post->ID);?>" target="_blank"><?php echo get_the_post_thumbnail($post->ID, "javo-map-thumbnail"); ?></a>
					</div> <!-- thumb -->
					<div class="img-in-text"><?php echo $javo_list_str->price;?></div>
					<div class="javo-left-overlay">
						<div class="javo-txt-meta-area"><?php echo $javo_list_str->__hasStatus();?></div> <!-- price-text -->
						<div class="corner-wrap">
							<div class="corner"></div>
							<div class="corner-background"></div>
						</div> <!-- corner-wrap -->
					</div> <!-- javo-left-overlay -->
				</div> <!-- pic -->

				<div class="row">
					<div class="col-md-12">
						<div class="btn-group btn-group-justified pull-right">
							<a href="javascript:" class="btn btn-accent btn-sm javo-item-brief" data-id="<?php echo $post->ID;?>" onclick="javo_show_brief(this);"><i class="fa fa-user"></i> <?php _e("Brief", "javo_fr"); ?></a>
							<a href="<?php echo get_permalink($post->ID);?>" class="btn btn-accent btn-sm"><i class="fa fa-group"></i> <?php _e("Detail", "javo_fr"); ?></a>
							<a href="javascript:" onclick="javo_show_contact(this);" class="btn btn-accent btn-sm javo-lister-contact" data-to="<?php echo $javo_list_str->author->user_email;?>"> <?php _e("Contact", "javo_fr"); ?></a>
						 </div><!-- btn-group -->
					</div> <!-- col-md-12 -->
				</div> <!-- row -->
			</div> <!-- javo_somw_info -->
		<?php
			return ob_get_clean();
		};

		// Posts Query Args
		$args = Array(
			"post_type" => $post_type
			, "post_status" => "publish"
			//, "posts_per_page" => $ppp
			, "posts_per_page" => -1
			//, "paged"=> $page
		);

		// Set category
		if($tax && $term){
			$args['tax_query'] = Array(
				Array(
					"taxonomy" => $tax,
					"field" => "term_id",
					"terms" => $term
				)
			);
		};

		if($tax2 && $term2){
			$args['tax_query']['relation'] = "AND";
			$args['tax_query'][] = Array(
					"taxonomy" => $tax2,
					"field" => "term_id",
					"terms" => $term2
				);
		};
		if(!empty($_POST['tax3']) && !empty($_POST['term3'])){
			$args['tax_query']['relation'] = "AND";
			$args['tax_query'][] = Array(
					"taxonomy" => $_POST['tax3'],
					"field" => "term_id",
					"terms" => $_POST['term3']
				);
		};

		if(!empty($location)){
			$args['tax_query']['relation'] = "AND";
			$args['tax_query'][] = Array(
					"taxonomy" => $_POST['tax4'],
					"field" => "term_id",
					"terms" => $location
				);
		};

		if(!empty($_POST['tax5']) && !empty($_POST['term5'])){
			$args['tax_query']['relation'] = "AND";
			$args['tax_query'][] = Array(
				"taxonomy" => $_POST['tax5'],
				"field" => "term_id",
				"terms" => $_POST['term5']
			);
		};

		if(!empty($_POST['tax6']) && !empty($_POST['term6'])){
			$args['tax_query']['relation'] = "AND";
			$args['tax_query'][] = Array(
				"taxonomy" => $_POST['tax6'],
				"field" => "term_id",
				"terms" => $_POST['term6']
			);
		};

		if(!empty($_POST['tax7']) && !empty($_POST['term7'])){
			$args['tax_query']['relation'] = "AND";
			$args['tax_query'][] = Array(
				"taxonomy" => $_POST['tax7'],
				"field" => "term_id",
				"terms" => $_POST['term7']
			);
		};


	if($keyword){
		$args['s'] = $keyword;
	};

	if( (int)$javo_tso->get('date_filter') > 0 ){
		$args['date_query'] = Array(
			Array(
				'column' => 'post_date_gmt',
				'after'=> '30 day ago'
			)
		);
	};

	// Post List HTML
	$output = Array();
	global $wp_query;
	//$posts = query_posts($args);
	$posts = new wp_query($args);
	$posts_count = $posts->post_count;

	// Results Json encode
	ob_start();?>
	<div class=''>
	<?php
	while($posts->have_posts()):
		$posts->the_post();
		$post = get_post(get_the_ID());
		if(isset($_POST['latlng'])){
			$latlng = get_post_meta($post->ID, $_POST['latlng'], true);
			$add = "";
			$latlng = @unserialize($latlng);
		};
		$javo_map_str = new get_char($post);
		$javo_marker_term_id = wp_get_post_terms($post->ID, "item_location");
		wp_reset_query();
		$javo_set_icon = $javo_tso->get('map_marker', '');
		if(!empty($javo_marker_term_id[0])){
			$javo_set_icon = get_option('javo_item_location_'.$javo_marker_term_id[0]->term_id.'_marker', '');
		};
		$output[] = Array(
			"post_id"=> $post->ID
			, "ibox"=> infobox($post)
			, "lat"=>(($latlng['lat'])? $latlng['lat'] : "")
			, "lng"=>(($latlng['lng'])? $latlng['lng'] : "")
			, "icon"=> $javo_set_icon
		);
		printf("
			<div class='row javo_somw_list_inner'>
				<div class='col-md-3 thumb-wrap'>
					%s
				</div><!-- col-md-3 thumb-wrap -->

				<div class='cols-md-9 meta-wrap'>
					<div class='javo_somw_list'><a href='%s' data-lat='%s' data-lng='%s'>%s</a></div>
				</div><!-- col-md-9 meta-wrap -->
			</div><!-- row -->"
			, get_the_post_thumbnail($post->ID, Array(50, 50))
			, get_permalink($post->ID), $latlng['lat'], $latlng['lng'], $post->post_title
		);
	endwhile; ?>


	</div>
	<?php
	$big = 999999999; // need an unlikely integer
	echo paginate_links( array(
		'base' => "%_%",
		'format' => '?page=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'prev_text'    => __('< Prev' , 'javo_fr'),
		'next_text'    => __('Next >' , 'javo_fr'),
		'total' => $wp_query->max_num_pages
	) );
	// Reset Wordpress Query
	wp_reset_query();

	$content = ob_get_clean();
	// Post List HTML end

	// Result Json
	$args = Array(
		"result"=>"succress"
		, "marker"=>$output
		, "html"=>$content
		, "count"=>$posts_count
	);

	// Output results
	echo json_encode($args);
	exit(0);
	}

};
new javo_ajax_propcess();