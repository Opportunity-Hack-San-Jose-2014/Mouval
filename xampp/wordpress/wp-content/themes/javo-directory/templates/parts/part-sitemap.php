<?php global $javo_tso; ?>
<div id="javo-sitemap">
    <button type="button" class="close">x</button>


      <a class="navbar-brand" href="<?php echo home_url('/');?>"><img src="<?php echo $javo_tso->get('logo_url', JAVO_IMG_DIR.'/javo-directory-logo-v1-3.png');?>"></a>



	<div class="container sitemap-intro text-center">

		<div class="des">

		</div> <!-- des -->	
	</div>

	

	<div class="container sitemap-list">
		<div class="row">
			<div class="sitemap-cate col-md-6 text-right">
				<h3><?php _e('Categories', 'javo_fr'); ?></h3>
				<ul>
				<?php
				$args = array(
					'type'                     => 'item',
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 1,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => 'item_category',
					'pad_counts'               => false 
				  );
				$categories = get_categories($args);
				  foreach($categories as $category) { 
					echo '<li><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( '%s %s', __('View all posts in ', 'javo_fr'), $category->name ) . '" ' . '>' . $category->name.' ('. $category->count . ')</a> </li> ';
					//echo '<p> Description:'. $category->description . '</p>';			
					} 
				?>
				</ul>
			</div> <!-- sitemap-cate -->

			<div class="sitemap-cate col-md-6 text-left">
				<h3><?php _e('Location', 'javo_fr'); ?></h3>
				<ul>
				<?php
				$args = array(
					'type'                     => 'item',
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 1,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => 'item_location',
					'pad_counts'               => false 
				  );
				$categories = get_categories($args);
				  foreach($categories as $category) { 
					echo '<li><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf('%s %s', __( 'View all posts in ', 'javo_fr'), $category->name ) . '" ' . '>' . $category->name.' ('. $category->count . ')</a> </li> ';
					//echo '<p> Description:'. $category->description . '</p>';			
					} 
				?>
				</ul>
			</div> <!-- sitemap-cate -->
		</div><!-- row -->
	</div> <!--  sitemap-list -->

	<form class="search-in-menu" role="search" method="post" action="<?php echo get_permalink($javo_tso->get('page_item_result'));?>">
		 <input type="search" value="" placeholder="type keyword(s) here" />
		 <button type="submit" class="btn btn-primary admin-color-setting" onclick="this.form.submit();" >Search</button>
	 </form>


	<!-- <form class="search-in-menu" role="search" method="post" action="<?php echo get_permalink($javo_tso->get('page_item_result'));?>">
		<div class="slider-search-part-wrap">
			<div class="form-group">
				<input type="text" class="form-control input-large" placeholder="type keyword(s) here">
			</div>
			Large button group
			<div class="search-part-inner-text"><?php _e('Search your location and categories to display on maps', 'javo_fr'); ?></div>
			<input type="submit" class="btn btn-primary admin-color-setting" onclick="this.form.submit();" value="<?php _e('Submit', 'javo_fr');?>">
		</div>slider-search-part-wrap
	</form> -->
   
</div><!-- javo-sitemap -->