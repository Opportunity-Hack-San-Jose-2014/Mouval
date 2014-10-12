<?php
add_action('wp_enqueue_scripts', 'javo_load_scripts');
function javo_load_scripts(){
	global $javo_theme_option;

	$javo_general_styles = Array();
	$javo_assets_styles = Array(
		'home-map-layout.css'							=> 'javo-home-map-template-layout'
		, '../bootstrap/bootstrap-select.css'			=> 'bootstrap-select'
		, 'footer-top.css'								=> 'Footer-top'
		, 'register-component.css'						=> 'register-component'
		, 'register-base.css'							=> 'register-base'
		, 'magnific-popup.css'							=> 'magnific-popup'
		, 'pace-theme-big-counter.css'					=> 'pace-theme-big-counter'
		, 'bootstrap-markdown.min.css'					=> 'bootstrap-markdown'
		, 'spectrum.css'								=> 'jquery-spectrum'
	);
	$javo_single_assets_styles = Array(
		'wide-gallery-component.css'					=> 'wide-gallery-component'
		, 'wide-gallery-base.css'						=> 'wide-gallery-base'
		, 'wide-gallery-normalize.css'					=> 'wide-gallery-normalize'
		, 'single-reviews-style.css'					=> 'single-reviews-style'	

	);
	$javo_assets_header_scripts = Array(
		'gmap3.js'										=> 'gmap3'
		, 'common.js'									=> 'Javo-common-script'
		, 'jquery.parallax.min.js'						=> 'jQuery-Parallax'
		, 'jquery.favorite.js'							=> 'jQuery-javo-Favorites'
		, 'jquery_javo_search.js'						=> 'jQuery-javo-search'
		, 'jquery.flexslider-min.js'					=> 'jQuery-flex-Slider'
		, 'google.map.infobubble.js'					=> 'Google-Map-Info-Bubble'
		, 'pace.min.js'									=> 'Pace-Script'
		, 'single-reviews-modernizr.custom.79639.js'	=> 'single-reviews-modernizr.custom'
		, 'jquery.magnific-popup.js'					=> 'jquery.magnific-popup'
	);
	$javo_assets_scripts = Array(
		'bootstrap.min.js'								=> 'bootstrap'
		, 'bootstrap.hover.dropmenu.min.js'				=> 'bootstrap-hover-dropdown'
		, 'jquery.easing.min.js'						=> 'jQuery-Easing'
		, 'jquery.form.js'								=> 'jQuery-Ajax-form'
		, 'sns-link.js'									=> 'sns-link'
		, 'jquery.raty.min.js'							=> 'jQuery-Rating'
		, 'jquery.spectrum.js'							=> 'jQuery-Spectrum'
		, 'jquery.parallax.min.js'						=> 'jQuery-parallax'
		, 'jquery.javo.mail.js'							=> 'jQuery-javo-Emailer'
		, 'common.js'									=> 'javo-assets-common-script'
		, '../bootstrap/bootstrap-select.js'			=> 'bootstrap-select-script'
		, 'javo-footer.js'								=> 'javo-Footer-script'
		, 'bootstrap-markdown.js'						=> 'bootstrap-markdown'
		, 'bootstrap-markdown.fr.js'					=> 'bootstrap-markdown-fr'
		, 'smoothscroll.js'								=> 'smoothscroll'
		, 'jquery.quicksand.js'							=> 'jQuery-QuickSnad'
	);

	$javo_single_assets_scripts = Array(
		'single-reviews-slider.js'						=> 'single-reviews-slider'
		, 'common-single-item.js'						=> 'common-single-item'

	);

	wp_enqueue_script('jquery');
	wp_enqueue_script("google_map_API", "http://maps.google.com/maps/api/js?sensor=false&amp;language=en", null, "0.0.1", false);

	foreach( $javo_general_styles as $src => $id){ javo_get_style($src, $id); };
	foreach( $javo_assets_styles as $src => $id){ javo_get_asset_style($src, $id); };
	if( is_single() ){
		foreach( $javo_single_assets_styles as $src => $id){ javo_get_asset_style($src, $id); };
	}
	foreach( $javo_assets_header_scripts as $src => $id){ javo_get_asset_script($src, $id, null, false); }
	foreach( $javo_assets_scripts as $src => $id){ javo_get_asset_script($src, $id); }
	if( is_single() ){
		foreach( $javo_single_assets_scripts as $src => $id){ javo_get_asset_script($src, $id, null, false); }
	}

	wp_enqueue_style( 'javo-style', get_stylesheet_uri(), array(), '1.0' );

	// Custom css - Javo themes option
	$javo_upload_path = wp_upload_dir();
	if(
		get_option("javo_themes_settings_css") != "" &&
		file_exists( $javo_upload_path['url']."/".basename(get_option("javo_themes_settings_css") ) )
	){
		wp_enqueue_style( "javo_drt_custom_style", $javo_upload_path['url']."/".basename(get_option("javo_themes_settings_css")));
	};

	// Google Fonts
	$protocol = is_ssl() ? 'https' : 'http';
	$javo_load_fonts = Array("basic_font", "h1_font", "h2_font", "h3_font", "h4_font", "h5_font", "h6_font");
	foreach($javo_load_fonts as $index=>$font)
		if($javo_theme_option[$font] != "")
			wp_enqueue_style( 'javo-opensans', "$protocol://fonts.googleapis.com/css?family=$javo_theme_option[$font]");	
};