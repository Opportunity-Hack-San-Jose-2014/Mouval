<?php
/**
*** Sidebar Menu
***/
?>
	<div class="col-xs-6 col-sm-2 sidebar-offcanvas main-content-left my-page-nav" id="sidebar" role="navigation">
		<p class="visible-xs">
			<button type="button" class="btn btn-primary btn-xs" data-toggle="mypage-offcanvas">
				<i class="glyphicon glyphicon-chevron-left"><?php _e('Close', 'javo_fr');?></i>
			</button>
		</p>
		<div class="well sidebar-nav mypage-left-menu">
			<ul class="nav nav-sidebar">
				<li class="titles"><?php _e('PROFILE', 'javo_fr');?></li>
				<li><a href="<?php echo home_url('member/'.wp_get_current_user()->user_login);?>"><i class="glyphicon glyphicon-cog"></i>&nbsp;<?php _e('Home', 'javo_fr');?></a></li>
				<li><a href="<?php echo home_url('profile/'.wp_get_current_user()->user_login);?>"><i class="glyphicon glyphicon-cog"></i>&nbsp;<?php _e('Edit My Profile', 'javo_fr');?></a></li>
				<li><a href="<?php echo home_url('loast-password/'.wp_get_current_user()->user_login);?>"><i class="glyphicon glyphicon-cog"></i>&nbsp;<?php _e('Change Password', 'javo_fr');?></a></li>
			</ul>
			<ul class="nav nav-sidebar">
				<li class="titles"><?php _e('My Shops', 'javo_fr');?></li>
				<li><a href="<?php echo home_url('favorite/'.wp_get_current_user()->user_login);?>"><i class="glyphicon glyphicon-cog"></i>&nbsp;<?php _e('Saved Shops', 'javo_fr');?></a></li>
				<li><a href="<?php echo home_url('review/'.wp_get_current_user()->user_login);?>"><i class="glyphicon glyphicon-cog"></i>&nbsp;<?php _e('My Reviews', 'javo_fr');?></a></li>
				<li><a href="<?php echo home_url('rating/'.wp_get_current_user()->user_login);?>"><i class="glyphicon glyphicon-cog"></i>&nbsp;<?php _e('My Ratings', 'javo_fr');?></a></li>
				<li><a href="<?php echo home_url('add-review/'.wp_get_current_user()->user_login);?>"><i class="glyphicon glyphicon-pencil"></i>&nbsp;<?php _e('Add Review', 'javo_fr');?></a></li>
			</ul>
			<ul class="nav nav-sidebar">
				<li class="titles"><?php _e('Lister Menu', 'javo_fr');?></li>
				<li><a href="<?php echo home_url('add-item/'.wp_get_current_user()->user_login);?>"><i class="glyphicon glyphicon-pencil"></i>&nbsp;<?php _e('Add My Shops', 'javo_fr');?></a></li>
				<li><a href="<?php echo home_url('add-event/'.wp_get_current_user()->user_login);?>"><i class="glyphicon glyphicon-pencil"></i>&nbsp;<?php _e('Add Events', 'javo_fr');?></a></li>
				<li><a href="<?php echo home_url('shop/'.wp_get_current_user()->user_login);?>"><i class="glyphicon glyphicon-cog"></i>&nbsp;<?php _e('My Shops List', 'javo_fr');?></a></li>
				<li><a href="<?php echo home_url('events/'.wp_get_current_user()->user_login);?>"><i class="glyphicon glyphicon-cog"></i>&nbsp;<?php _e('My Event List', 'javo_fr');?></a></li>
				<li><a href="<?php echo home_url('payment/'.wp_get_current_user()->user_login);?>"><i class="glyphicon glyphicon-cog"></i>&nbsp;<?php _e('Payment History', 'javo_fr');?></a></li>
			</ul>
		</div><!--/.well -->
	</div><!--/col-xs-->