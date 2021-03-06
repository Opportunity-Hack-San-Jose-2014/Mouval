<?php
	// bootstrap navigation walker for menus
	require_once JAVO_SYS_DIR.'/functions/wp_bootstrap_navwalker.php';
	require_once JAVO_SYS_DIR."/functions/class-tgm-plugin-activation.php"; // intergrated plugins TGM
	require_once JAVO_SYS_DIR."/active_plugins.php"; // get plugins

	/** Feature Listings / Processing part / Ajax **/
	require_once JAVO_FUC_DIR.'/process.php';
	require_once JAVO_FUC_DIR.'/list-main-map.php';
	require_once JAVO_FUC_DIR.'/callback-post-list.php';
	require_once JAVO_FUC_DIR.'/callback-javo-map.php';
	require_once JAVO_FUC_DIR.'/callback-get-map-brief.php';
	require_once JAVO_FUC_DIR.'/callback-javo-review.php';


	/** Shortcodes **/
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if(is_plugin_active( 'js_composer/js_composer.php')){
		/** vs **/
		require_once JAVO_SCS_DIR.'/shortcode-settings.php';  /* setting */
		require_once JAVO_SCS_DIR.'/item-price/javo-item-price.php';
		require_once JAVO_SCS_DIR.'/banner/javo-banner.php';
		require_once JAVO_SCS_DIR.'/faq/javo-faq.php';
		require_once JAVO_SCS_DIR.'/javo-item-time-line/javo-item-time-line.php';
		require_once JAVO_SCS_DIR.'/fancy-titles/javo-fancy-titles.php';
		require_once JAVO_SCS_DIR.'/events/javo-events.php';
		require_once JAVO_SCS_DIR.'/slide-search/slide-search.php';
		require_once JAVO_SCS_DIR.'/categories/javo-categories.php';
		require_once JAVO_SCS_DIR.'/rating-list/javo-rating-list.php';
		require_once JAVO_SCS_DIR.'/grid-open/javo-grid-open.php';
		require_once JAVO_SCS_DIR.'/recent-ratings/recent-ratings.php';
		require_once JAVO_SCS_DIR.'/register/sc-register.php';
		require_once JAVO_SCS_DIR.'/gallery/javo-gallery.php';
		require_once JAVO_SCS_DIR.'/events-gallery/events-gallery.php';
		require_once JAVO_SCS_DIR.'/featured-items/javo-featured-items.php';
		require_once JAVO_SCS_DIR.'/masonry/javo-masonry.php';
	}

	/** Widgets **/
	require_once JAVO_WG_DIR.'/wg-javo-recent-post.php';
	require_once JAVO_WG_DIR.'/wg-javo-recent-photos.php';
	require_once JAVO_WG_DIR.'/wg-javo-contact-us.php';
	//require_once JAVO_WG_DIR.'/wg-javo-mailchimp.php';

	/** Admin Panel **/
	require_once JAVO_ADM_DIR.'/post-meta-box.php';
	require_once JAVO_ADM_DIR.'/edit-post-list-column.php';
	require_once JAVO_ADM_DIR.'/javo-custom-tax.php';
	require_once JAVO_ADM_DIR.'/javo-custom-fileds.php';

	/** Classes **/

	require_once JAVO_CLS_DIR.'/list-view-button.php';
	require_once JAVO_CLS_DIR.'/javo-post-class.php';
	require_once JAVO_CLS_DIR.'/javo-array.php';
	require_once JAVO_CLS_DIR.'/javo-get-option.php';
	require_once JAVO_CLS_DIR.'/javo-directory-meta.php';
	require_once JAVO_CLS_DIR.'/javo-ratings.php';
	require_once JAVO_CLS_DIR.'/javo-author.php';
	require_once JAVO_CLS_DIR.'/javo-favorite.php';