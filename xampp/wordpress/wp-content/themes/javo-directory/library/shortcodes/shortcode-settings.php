<?php
class javo_vb_shortcodes{

	public function __construct(){
		add_action('init', Array($this, 'javo_vb_shortcodes_callback'), 11);
		add_shortcode_param('javo_image', Array($this, 'javo_image_upload_param_callback'));
		add_shortcode_param('javo_bg', Array($this, 'javo_bg_param_callback'));
		add_shortcode_param('javo_onoff_input', Array($this, 'javo_input_onoff_param_callback'));		
	}

	public function javo_vb_shortcodes_callback(){

		// javo-banner
		vc_map(array(
			'base'=> 'javo_banner'
			, 'name'=> __('banner', 'javo_fr')
		    , 'icon' => 'javo_carousel_news'
			, 'category'=> __('Javo', 'javo_fr')
			, 'admin_enqueue_css' => array(get_template_directory_uri().'/css/vs.css')
			, 'wp_enqueue_css' => array(get_template_directory_uri().'/css/vs.css')
			, 'description' => __('javo_banner.', 'javo_fr')
			, 'params'=> Array(
				Array(
					'type'=>'attach_image'
					, 'heading'=> __('Select Image', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'attachment_id'
					, 'value' => ''
				),Array(
					'type'=>'textfield'
					, 'heading'=> __('Link', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'link'
					, 'value' => '#'
				), Array(
					'type'=>'textfield'
					, 'heading'=> __('Width', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'width'
					, 'value' => '500'
				), Array(
					'type'=>'textfield'
					, 'heading'=> __('Height', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'height'
					, 'value' => '400'
				), Array(
					'type'=>'textfield'
					, 'heading'=> __('Border - Weight', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'bdweight'
					, 'value' => '1'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Border - color', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'bdcolor'
					, 'value' => '#efefef'
				)
			)
		));

		// javo_events
		vc_map(array(
			'base'=> 'javo_events'
			, 'name'=> __('Events', 'javo_fr')
		    , 'icon' => 'javo_carousel_news'
			, 'category'=> __('Javo', 'javo_fr')
			, 'admin_enqueue_css' => array(get_template_directory_uri().'/css/vs.css')
			, 'wp_enqueue_css' => array(get_template_directory_uri().'/css/vs.css')
			, 'description' => __('Display Events by categories.', 'javo_fr')
			, 'params'=> Array(
				Array(
					'type'=>'textfield'
					, 'heading'=> __('Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'title'
					, 'value' => ''
				),Array(
					'type'=>'textfield'
					, 'heading'=> __('Sub Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'sub_title'
					, 'value' => ''
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Sub Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'sub_title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Header Linear Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'line_color'
					, 'value' => '#fff'
				), Array(
					'type'=>'dropdown'
					, 'heading'=> __('Listing Style', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'type'
					, 'value' => Array(
						__('Single Slide', 'javo_fr')=> 'single'
						, __('2 Cols Slide', 'javo_fr')=> 'two-cols'
						, __('3 Cols Slide', 'javo_fr')=> 'three-cols'
						, __('4 Cols Slide', 'javo_fr')=> 'four-cols'						
					)
				), Array(
					'type'=>'dropdown'
					, 'heading'=> __('Category', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'category'
					, 'value' => $this->__cate('jv_events_category')				
				), Array(
					'type'=>'textfield'
					, 'heading'=> __('Show Lists count', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'page'
					, 'value' => __('4', 'javo_fr')
				), Array(
					'type'=>'dropdown'
					, 'heading'=> __('Order by', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'order'
					, 'value' => Array(
						'DESC'=> 'DESC'
						, 'ASC'=> 'ASC'
					)
				)
			)
		));		
					
		// Javo slide search bar
		vc_map(array(
			'base'=> 'javo_slide_search'
			, 'name'=> __('item slide with search bar', 'javo_fr')
		    , 'icon' => 'javo_carousel_news'
			, 'category'=> __('Javo', 'javo_fr')
			, 'admin_enqueue_css' => array(get_template_directory_uri().'/css/vs.css')
			, 'wp_enqueue_css' => array(get_template_directory_uri().'/css/vs.css')
			, 'description' => __('javo slide with search bar', 'javo_fr')
			, 'params'=> Array(
				Array(
					'type'=>'textfield'
					, 'heading'=> __('Subject', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'title'
					, 'value' => __('Title', 'javo_fr')
				), Array(
					'type'=>'dropdown'
					, 'heading'=> __('Search Type', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'search_type'
					, 'value' => Array(
						__('Vertical', 'javo_fr')		=> 'vertical'
						, __('Horizontal', 'javo_fr')	=> 'horizontal'						
					)
				)
			)
		));

		// Javo item_price
		vc_map(array(
			'base'=> 'javo_item_price'
			, 'name'=> __('item_price', 'javo_fr')
		    , 'icon' => 'javo_carousel_news'
			, 'category'=> __('Javo', 'javo_fr')
			, 'admin_enqueue_css' => array(get_template_directory_uri().'/css/vs.css')
			, 'wp_enqueue_css' => array(get_template_directory_uri().'/css/vs.css')
			, 'description' => __('javo_item_price.', 'javo_fr')
			, 'params'=> Array(
				Array(
					'type'=>'textfield'
					, 'heading'=> __('Subject', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'title'
					, 'value' => __('Title', 'javo_fr')
				)
			)
		));

		// Javo Event Masonry
		vc_map(array(
			'base'=> 'javo_events_masonry'
			, 'name'=> __('Javo Events Masonry', 'javo_fr')
			, 'category'=> __('Javo', 'javo_fr')
			, 'icon' => 'javo_carousel_news'
			, 'description' => __('Javo Events Masonry Portfolio.', 'javo_fr')
			, 'params'=> Array(
				Array(
					'type'=>'textfield'
					, 'heading'=> __('Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'title'
					, 'value' => ''
				), Array(	
					'type'=>'textfield'
					, 'heading'=> __('Sub Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'sub_title'
					, 'value' => ''
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Sub Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'sub_title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Header Linear Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'line_color'
					, 'value' => '#fff'
				)
			)
		));


		// Javo
		vc_map(array(
			'base'=> 'javo_faq'
			, 'name'=> __('javo faq', 'javo_fr')
			, 'category'=> __('Javo', 'javo_fr')
			, 'icon' => 'javo_carousel_news'
			, 'description' => __('Description', 'javo_fr')
			, 'params'=> Array(
				Array(
					'type'=>'textfield'
					, 'heading'=> __('Subject', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'title'
					, 'value' => __('', 'javo_fr')
				), Array(
					'type'=>'textfield'
					, 'heading'=> __('Item Count', 'javo_fr')
					, 'description'=> __('( 0 = ALL )', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'items'
					, 'value' => __('0', 'javo_fr')
				)
			)
		));


		// Javo grid open
		vc_map(array(
			'base'=> 'javo_grid_open'
			, 'name'=> __('javo grid open', 'javo_fr')
			, 'category'=> __('Javo', 'javo_fr')
			, 'icon' => 'javo_carousel_news'
			, 'description' => __('Display items Grid style', 'javo_fr')
			, 'params'=> Array(
				Array(
					'type'=>'textfield'
					, 'heading'=> __('Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'title'
					, 'value' => ''
				), Array(	
					'type'=>'textfield'
					, 'heading'=> __('Sub Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'sub_title'
					, 'value' => ''
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Sub Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'sub_title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Header Linear Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'line_color'
					, 'value' => '#fff'
				), Array(
					'type'=>'textfield'
					, 'heading'=> __('Display item count', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'count'
					, 'value' => '7'
				)
			)
		));
			
		// Javo categories
		vc_map(array(
			'base'=> 'javo_categories'
			, 'name'=> __('javo categories', 'javo_fr')
			, 'category'=> __('Javo', 'javo_fr')
			, 'icon' => 'javo_carousel_news'
			, 'description' => __('Description', 'javo_fr')
			, 'params'=> Array(
				Array(
					'type'=>'textfield'
					, 'heading'=> __('Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'title'
					, 'value' => ''
				),Array(
					'type'=>'textfield'
					, 'heading'=> __('Sub Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'sub_title'
					, 'value' => ''
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Sub Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'sub_title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Header Linear Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'line_color'
					, 'value' => '#fff'
				), Array(
					'type'=>'textfield'
					, 'heading'=> __('Item count for One line', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'oneline'
					, 'value' => __('6', 'javo_fr')
				)
			)
		));

		// Javo Rating list
		vc_map(array(
			'base'=> 'javo_rating_list'
			, 'name'=> __('javo rating_list', 'javo_fr')
			, 'category'=> __('Javo', 'javo_fr')
			, 'icon' => 'javo_carousel_news'
			, 'description' => __('Description', 'javo_fr')
			, 'params'=> Array(
				Array(
					'type'=>'textfield'
					, 'heading'=> __('Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'title'
					, 'value' => ''
				), Array(	
					'type'=>'textfield'
					, 'heading'=> __('Sub Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'sub_title'
					, 'value' => ''
				), Array(	
					'type'=>'textfield'
					, 'heading'=> __('Display Rating count', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'count'
					, 'value' => ''
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Sub Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'sub_title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Header Linear Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'line_color'
					, 'value' => '#fff'
				)
			)
		));

		// Javo Rating list
		vc_map(array(
			'base'=> 'javo_recent_ratings'
			, 'name'=> __('Javo Recent Ratings', 'javo_fr')
			, 'category'=> __('Javo', 'javo_fr')
			, 'icon' => 'javo_carousel_news'
			, 'description' => __('Description', 'javo_fr')
			, 'params'=> Array(
				Array(
					'type'=>'textfield'
					, 'heading'=> __('Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'title'
					, 'value' => ''
				), Array(	
					'type'=>'textfield'
					, 'heading'=> __('Sub Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'sub_title'
					, 'value' => ''
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Sub Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'sub_title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Header Linear Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'line_color'
					, 'value' => '#fff'
				), Array(	
					'type'=>'textfield'
					, 'heading'=> __('Display Rating count', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'items'
					, 'value' => ''
				)
			)
		));


			// Javo fancy title
		vc_map(array(
			'base'=> 'javo_fancy_titles'
			, 'name'=> __('Fancy Title', 'javo_fr')
			, 'category'=> __('Javo', 'javo_fr')
			, 'icon' => 'javo_carousel_news'
			, 'description' => __('Fancy titles', 'javo_fr')
			, 'params'=> Array(
				Array(
					'type'=>'textfield'
					, 'heading'=> __('Display Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'title'
					, 'value' => __('Title', 'javo_fr')
				), Array(
					'type'=>'dropdown'
					, 'heading'=> __('Header Type', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'type'
					, 'value' => Array(
						__('Red Line (Defalut)', 'javo_fr') => ''
						, __('Gray Circle Line', 'javo_fr') => 'gray_circle'
					)
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'text_color'
					, 'value' => __('#000000', 'javo_fr')
				), Array(
					'type'=>'textfield'
					, 'heading'=> __('Line Spacing', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'line_spacing'
					, 'value' => __('20', 'javo_fr')
				), Array(
					'type'=>'textfield'
					, 'heading'=> __('Font Size', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'font_size'
					, 'value' => __('12', 'javo_fr')
				), Array(
					'type'=>'textfield'
					, 'heading'=> __('Description', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'description'
					, 'value' => ''
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Description Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'description_color'
					, 'value' => __('#000000', 'javo_fr')
				)
			)
		));

		// Member Register & Login
		vc_map(array(
			'base'=> 'javo_register_login'
			, 'name'=> __('Javo Member Register/Login', 'javo_fr')
			, 'category'=> __('Javo', 'javo_fr')
			, 'icon' => 'javo_carousel_news'
			, 'description' => __('Description', 'javo_fr')
			, 'params'=>Array(
				Array(
					'type'=>'textfield'
					, 'heading'=> __('Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'title'
					, 'value' => ''
				), Array(	
					'type'=>'textfield'
					, 'heading'=> __('Sub Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'sub_title'
					, 'value' => ''
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Sub Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'sub_title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Header Linear Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'line_color'
					, 'value' => '#fff'
				), Array(
					'type'=>'textfield'
					, 'heading'=> __('Login information Box Title', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'login_info_box_title'
					, 'value' => __(' ', 'javo_fr')
				), Array(
					'type'=>'textarea'
					, 'heading'=> __('Login information Box Content', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'login_info_box'
					, 'value' => __(' ', 'javo_fr')
				), Array(
					'type'=>'textfield'
					, 'heading'=> __('Register information Box Title', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'register_info_box_title'
					, 'value' => __(' ', 'javo_fr')
				), Array(
					'type'=>'textarea'
					, 'heading'=> __('Register information Box', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'register_info_box'
					, 'value' => __(' ', 'javo_fr')
				), Array(
					'type'=>'textfield'
					, 'heading'=> __('Forget Password information Box Title', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'forget_info_box_title'
					, 'value' => __(' ', 'javo_fr')
				), Array(
					'type'=>'textarea'
					, 'heading'=> __('Forget Password information Box', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'forget_info_box'
					, 'value' => __(' ', 'javo_fr')
				)
			)
		));		

		// Javo Gallery
		vc_map(array(
			'base'=> 'javo_gallery'
			, 'name'=> __('Javo Gallery', 'javo_fr')
			, 'category'=> __('Javo', 'javo_fr')
			, 'icon' => 'javo_carousel_news'
			, 'description' => __('Description', 'javo_fr')
			, 'params'=> Array(
				Array(
					'type'=>'textfield'
					, 'heading'=> __('Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'title'
					, 'value' => ''
				), Array(	
					'type'=>'textfield'
					, 'heading'=> __('Sub Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'sub_title'
					, 'value' => ''
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Sub Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'sub_title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Header Linear Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'line_color'
					, 'value' => '#fff'
				)
			)
		));

		// Javo Events Gallery
		vc_map(array(
			'base'=> 'javo_event_gallery'
			, 'name'=> __('Javo Events Gallery', 'javo_fr')
			, 'category'=> __('Javo', 'javo_fr')
			, 'icon' => 'javo_carousel_news'
			, 'description' => __('Description', 'javo_fr')
			, 'params'=> Array(
				Array(
					'type'=>'textfield'
					, 'heading'=> __('Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'title'
					, 'value' => ''
				),Array(
					'type'=>'textfield'
					, 'heading'=> __('Sub Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'sub_title'
					, 'value' => ''
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Sub Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'sub_title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Header Linear Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'line_color'
					, 'value' => '#fff'
				)
			)
		));

		// Javo Featured Items
		vc_map(array(
			'base'=> 'javo_featured_items'
			, 'name'=> __('Javo Featured Items', 'javo_fr')
			, 'category'=> __('Javo', 'javo_fr')
			, 'icon' => 'javo_carousel_news'
			, 'description' => __('Description', 'javo_fr')
			, 'params'=> Array(
				Array(
					'type'=>'textfield'
					, 'heading'=> __('Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'title'
					, 'value' => ''
				),Array(
					'type'=>'textfield'
					, 'heading'=> __('Sub Title', 'javo_fr')
					, 'holder' => 'div'
					, 'class'=> ''
					, 'param_name'=> 'sub_title'
					, 'value' => ''
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Sub Title Text Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'sub_title_text_color'
					, 'value' => '#000'
				), Array(
					'type'=>'colorpicker'
					, 'heading'=> __('Header Linear Color', 'javo_fr')
					, 'holder' => 'div'
					, 'param_name'=> 'line_color'
					, 'value' => '#fff'
				)
			)
		));
				
		// javo one page id
		vc_add_param("vc_row", array(
			"type" => "textfield",
			"class" => "javo_one_page_id",
			"heading" => __("One Page ID : Only for one page style. except #", 'javo_fr'),
			"param_name" => "javo_one_page_id",
			"value" => ''
		)); 


		// fullwidth
		vc_add_param("vc_row", array(
			"type" => "checkbox",
			"class" => "javo-full-width",
			"heading" => __("Content FULL-WIDTH Layout", 'javo_fr'),
			"param_name" => "javo_full_width",
			"value" => array(
				"" => "1"
			)
		)); 

		// ! Adding animation to columns
		vc_add_param("vc_column", array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Animation", 'javo_fr'),
			"admin_label" => true,
			"param_name" => "animation",
			"value" => array(
				"None" => "",
				"Left" => "right-to-left",
				"Right" => "left-to-right",
				"Top" => "bottom-to-top",
				"Bottom" => "top-to-bottom",
				"Scale" => "scale-up",
				"Fade" => "fade-in"
			)
		));

		// Javo VC-Row Append Attributes.

		vc_add_param("vc_row", array(
			"type" => "attach_image",
			"heading" => __("Background Image (Full Width)", 'javo_fr'),
			"group"=> __('Javo', 'javo_fr'),
			"param_name" => "bg_src",
			"value" => ''
		));

		vc_add_param("vc_row", array(
			"type" => "colorpicker",
			"heading" => __("Background Color (Full Width)", 'javo_fr'),
			"group"=> __('Javo', 'javo_fr'),
			"param_name" => "background_color",
			"value" => ''
		));

		vc_add_param("vc_row", array(
			"type" => "checkbox",
			"heading" => __("Enable Section Shadow (Full Width)", 'javo_fr'),
			"group"=> __('Javo', 'javo_fr'),
			"param_name" => "box_shadow",
			"value" => Array( ''=> 'use')
		));

		vc_add_param("vc_row", array(
			"type" => "colorpicker",
			"heading" => __("Section Shadow Color (Full Width)", 'javo_fr'),
			"group"=> __('Javo', 'javo_fr'),
			"param_name" => "box_shadow_color",
			"value" => '#000'
		));

		vc_add_param("vc_row", array(
			"type" => "dropdown",
			"heading" => __("Background Type (Full Width)", 'javo_fr'),
			"group"=> __('Javo', 'javo_fr'),
			"param_name" => "background_type",
			"value" => array(
				__('Default', 'javo_fr') => "",
				__('Video( Coming Soon )', 'javo_fr') => "video",
				__('Parallax', 'javo_fr') => "parallax"
			)
		));

		vc_add_param("vc_row", array(
			"type" => "textfield",
			"heading" => __("Parallax Delay (Only Number)(Full Width)", 'javo_fr'),
			"group"=> __('Javo', 'javo_fr'),
			"param_name" => "parallax_delay",
			"value" => '0.1'
		));


	} //javo_vb_shortcodes_callback

	public function __cate($tax_name){
		//$tax_name = "category";
		$javo_get_tax = get_terms($tax_name, Array('hide_empty'=>0));
		if( !is_wp_error( $javo_get_tax ) ){
			$javo_get_tax_return = Array(__('No Select', 'javo_fr') => "");
			foreach($javo_get_tax as $tax){
				$javo_get_tax_return[ $tax->name ] = $tax->term_id;
			};
		};
		return !empty($javo_get_tax_return)? $javo_get_tax_return : null;
	}
	
	public function __get_p_type(){
		$javo_get_post_types = get_post_types();
		$javo_excluedes_post_types = Array( 'attachment', 'page', 'payment');
		$javo_get_post_types_return = Array();
		foreach($javo_excluedes_post_types as $post_type){
			if( in_array( $post_type , $javo_get_post_types ) ){
				unset( $javo_get_post_types[ $post_type ] );
			};
		};
		foreach($javo_get_post_types as $post_type){
			$javo_get_post_type = get_post_type_object($post_type);
			$javo_get_post_types_return[$javo_get_post_type->labels->name] = $post_type;
		
		}
		return $javo_get_post_types_return;	
	}


	function javo_image_upload_param_callback($settings, $value) {
		$dependency = vc_generate_dependencies_attributes($settings);
		ob_start();?>
		<div class="javo_image_upload">
			<input type="text" name="<?php echo $settings['param_name'];?>" value="<?php echo $value;?>" <?php echo $dependency;?>>
			<button class="button javo-"><?php _e('Select Image', 'javo_fr');?></button>
		</div>


		<?php
		return ob_get_clean();
	}
	public function javo_bg_param_callback($settings, $value){
		$dependency = vc_generate_dependencies_attributes($settings);
		ob_start();?>
		<div class="javo_image_upload">
			<select class="javo_select_parametter">
				<option value=""><?php _e('None', 'javo_fr');?></option>
				<option value="video" data-inputs="javo_input_Video"><?php _e('Video', 'javo_fr');?></option>
				<option value="parallax" data-inputs="javo_input_parallax"><?php _e('Parallax', 'javo_fr');?></option>
			</select>
		</div>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			"use strict";

			$('body').on('change', '.javo_select_parametter', function(){
				alert('');
			});
		
		
		});
		</script>
		<?php
		return ob_get_clean();
	}

	public function javo_input_onoff_param_callback($settings, $value){
		$dependency = vc_generate_dependencies_attributes($settings);
		ob_start();?>
		<div class="<?php echo $settings['input_type'];?>">
			<input name="">
		</div>
		
		<?php
		return ob_get_clean();
	}

};
new javo_vb_shortcodes();