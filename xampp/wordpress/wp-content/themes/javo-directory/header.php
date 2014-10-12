<?php
/**
 * The Header template for Javo Theme
 *
 * @package WordPress
 * @subpackage Javo_Directory
 * @since Javo Themes 1.0
 */
 // Get Options 
global $javo_theme_option;
global $javo_tso;
$javo_theme_option = @unserialize(get_option("javo_themes_settings"));
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php bloginfo('name'); ?> <?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lte IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
// Custom CSS AREA
if($javo_tso->get('custom_css', '') != ''){
	printf('<style type="text/css">%s</style>', stripslashes( $javo_tso->get('custom_css', '') ) );
};?>

<?php wp_head(); ?>
</head>
<style type="text/css">
.admin-color-setting{ 
	background: <?php echo $javo_tso->get('total_button_color');?> !important;
	border: <?php echo $javo_tso->get('total_button_border_use')=='use' ? '1px solid '.$javo_tso->get('total_button_border_color').'!important;' : 'none;';?> 
}
.corner-background.admin-color-setting,
.corner.admin-color-setting{
	border:2px solid <?php echo $javo_tso->get('total_button_color');?> !important;
	border-bottom-color: transparent !important;
	border-left-color: transparent !important;
	background:none !important;
}
.admin-border-color-setting{
	border-color:<?php echo $javo_tso->get('total_button_border_color');?> !important;
}
.custom-bg-color-setting{
	background: <?php echo $javo_tso->get('total_button_color');?> !important;
}
.custom-font-color{
	color:<?php echo $javo_tso->get('total_button_color');?> !important;
}
.javo_pagination > .page-numbers.current{
	background-color:<?php echo $javo_tso->get('total_button_color');?> !important;
	color:#fff;
}
</style>
<body <?php body_class();?>>
<div id="page-style" class="<?php echo $javo_tso->get('layout_style_boxed') == "active"? "boxed":""; ?>">
	<div class="loading-page">
		<div id="status" style="background-image:url(<?php echo $javo_tso->get('logo_url', JAVO_IMG_DIR.'/javo-directory-logo-v1-3.png');?>);">
        <div class="spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>
    </div>

	</div>
<?php
require_once $javo_tso->get('header_file', 'library/header/head-directory.php'); 
if(is_singular()){
	get_template_part("library/header/post", "header");
}
	// Site map template part
	get_template_part('templates/parts/part', 'sitemap');
?>