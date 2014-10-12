<?php
class javo_dashboard{
	var $pages;
	public function __construct(){		
		add_filter('template_include', Array($this, 'javo_dashboard_template'), 100, 1);
		add_action('init', Array($this, 'javo_rewrite_callback'));
		add_filter( 'query_vars',  Array($this, 'javo_dashboard_page_query_add_callback' ));
		$this->pages = Array(
			'member'
			, 'profile'
			, 'favorite'
			, 'loast-password'
			, 'shop'
			, 'events'
			, 'rating'
			, 'review'
			, 'add-item'
			, 'add-event'
			, 'add-review'
			, 'payment'
			, 'manage'
		);
	}
	public function javo_dashboard_template($template){
		global $wp_rewrite;

		foreach($this->pages as $key=> $val){

			if( get_query_var($val) != ""){
				add_action('wp_enqueue_scripts', Array($this, 'wp_media_enqueue_callback'));
				$javo_this_get_user = get_user_by('login', get_query_var($val));
				return !empty( $javo_this_get_user )? JAVO_DSB_DIR.'/mypage-'.$val.'.php' : locate_template('404.php');
			};
		};
		return $template;
	}
	static function wp_media_enqueue_callback(){
		wp_enqueue_media();	
	}
	public function javo_rewrite_callback(){
		foreach($this->pages as $page){
			add_rewrite_rule( $page.'/([^/]+)', 'index.php?'.$page.'=$matches[1]', 'top');
		};
	}
	public function javo_dashboard_page_query_add_callback($q){
		foreach($this->pages as $page){ $q[] = $page; };
		/*
		ob_start();
		var_dump($q);
		$content = ob_get_clean();
		$fn = @fopen($_SERVER['DOCUMENT_ROOT'].'/test.txt', 'w+');
		@fwrite($fn, $content);
		@fclose($fn);
		return $var;
		*/
		return $q;	
	}
}
new javo_dashboard();