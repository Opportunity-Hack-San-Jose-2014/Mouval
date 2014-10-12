<?php global $javo_tso; ?>
<header class="main" id="header-one-line">
<nav class="navbar navbar-inverse navbar-static-top javo-main-navbar javo-navi-bright" role="navigation">
<div class="container">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#javo-navibar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo home_url('/');?>">		
		<?php // setting logos
		if ( is_singular('item'	) ) {
		  ?><img src="<?php echo $javo_tso->get('logo_url', JAVO_IMG_DIR.'/javo-directory-logo-v1-3.png');?>"><?php // show adv. #1
		} else {
  		  ?><img src="<?php echo $javo_tso->get('logo_url', JAVO_IMG_DIR.'/javo-directory-logo-v1.png');?>"><?php // show adv. #2
		}
		?>
		</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="javo-navibar">     
	  <?php
	  wp_nav_menu( array(
					'menu_class' => 'nav navbar-nav navbar-left',
					'theme_location' => 'primary',
					'depth' => 3,
					'container' => false,
					'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
					'walker' => new wp_bootstrap_navwalker()));
					?>
      <ul class="nav navbar-nav navbar-right">
			<?php if (is_user_logged_in() && $javo_tso->get('nav_show_mypage', null) == 'use' ):

			$javo_this_user					= wp_get_current_user();
			$javo_this_user_avatar_id		= get_user_meta($javo_this_user->ID, 'avatar', true);?>
			<li>
				<a href="<?php echo home_url('member/').wp_get_current_user()->user_login; ?>" class="topbar-ser-image">
					<?php 
					echo wp_get_attachment_image( $javo_this_user_avatar_id, 'javo-tiny', true, Array(
						'style'		=> 'width:25px; height:25px;'
					));?>
				</a>
			</li>
		
        <li class="dropdown right-menus">
          <a href="/submit-page/" class="dropdown-toggle nav-right-button button-icon-notice" data-toggle="dropdown" data-javo-hover-menu><span class="glyphicon glyphicon-pencil"></span></a>
          <ul class="dropdown-menu" role="menu">
			<li><a href="<?php echo home_url('add-item/'.wp_get_current_user()->user_login);?>"><?php _e('Post an Item', 'javo_fr'); ?></a></li>
			<li><a href="<?php echo home_url('add-review/'.wp_get_current_user()->user_login);?>"><?php _e('Post a Review', 'javo_fr'); ?></a></li>         
          </ul>
        </li> <!-- right-menus -->    

        <li class="dropdown right-menus">
          <a href="#" class="dropdown-toggle nav-right-button button-icon-fix" data-toggle="dropdown" data-javo-hover-menu><span class="glyphicon glyphicon-cog"></span></a>
          <ul class="dropdown-menu" role="menu">
			<li><a href="<?php echo home_url('profile/'.wp_get_current_user()->user_login);?>"><?php _e('Edit Profile', 'javo_fr'); ?></a></li>
			<li><a href="<?php echo home_url('shop/'.wp_get_current_user()->user_login);?>"><?php _e('My Items', 'javo_fr'); ?></a></li>
			<li><a href="<?php echo home_url('review/'.wp_get_current_user()->user_login);?>"><?php _e('My Reivews', 'javo_fr'); ?></a></li>
			<li><a href="<?php echo home_url('rating/'.wp_get_current_user()->user_login);?>"><?php _e('My Ratings', 'javo_fr'); ?></a></li>
          </ul>
        </li> <!-- right-menus -->
		<?php elseif( !is_user_logged_in() ): // not logged in ?>
		<li class="dropdown right-menus ">
		  <a href="#" data-toggle="modal" data-target="#login_panel" class="nav-right-button"><span class="glyphicon glyphicon-user"></span></a>
        </li> <!-- right-menus -->
		<?php endif; ?>
        <li class="dropdown right-menus">
        </li> <!-- right-menus -->
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</div> <!-- container -->
</nav>
</header>