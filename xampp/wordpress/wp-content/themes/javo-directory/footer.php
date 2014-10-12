<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage Javo_Directory
 * @since Javo Themes 1.0
 */
?>
<?php global $javo_theme_option, $javo_tso; ?>
	<?php if( is_active_sidebar('footer-level1-1') || is_active_sidebar('footer-level1-2')  ) : ?>
<!-- SUPPORT & NEWSLETTER SECTION ================================================ -->
<div class="row footer-top-full-wrap">
	<div class="container footer-top">
		<section>
		  <div id="support">
			<div class="row">
			  <div class="col-md-3">
				<?php
				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-level1-1')): 
				endif;
				?>
			  </div>
			  
			  <div class="col-md-8 col-md-offset-1">
				<?php
				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-level1-2')): 
				endif;
				?>
			  </div>
			</div><!--end row-->
		  </div><!--end support-->
		</section>
	</div><!-- container-->
</div> <!-- footer-top-full-wrap -->
<!--END SUPPORT & NEWSLETTER SECTION-->
<?php endif; ?>

<footer class="footer-wrap">
	<div class="container">
		<div class="row">
			<div class="col-md-3"><?php if( is_active_sidebar('sidebar-foot1') ) : ?><?php dynamic_sidebar("Footer Sidebar1");?><?php endif; ?></div> <!-- col-md-3 -->
			<div class="col-md-3"><?php if( is_active_sidebar('sidebar-foot2') ) : ?><?php dynamic_sidebar("Footer Sidebar2");?><?php endif; ?></div> <!-- col-md-3 -->
			<div class="col-md-3"><?php if( is_active_sidebar('sidebar-foot3') ) : ?><?php dynamic_sidebar("Footer Sidebar3");?><?php endif; ?></div> <!-- col-md-3 -->
			<div class="col-md-3"><?php if( is_active_sidebar('sidebar-foot4') ) : ?><?php dynamic_sidebar("Footer Sidebar4");?><?php endif; ?></div> <!-- col-md-3 -->
		</div> <!-- container -->
	</div> <!-- row -->
</footer>

<div class="footer-bottom">
    <div class="container">
		<p><?php echo $javo_theme_option['copyright'];?></p>
    </div> <!-- container -->
</div> <!-- footer-bottom -->
	<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top javo-dark admin-color-setting" role="button" title="Go to top"><span class="glyphicon glyphicon-chevron-up"></span></a>
	<a class="btn btn-primary btn-lg javo-quick-contact-us javo-dark admin-color-setting"><span class="glyphicon glyphicon-envelope"></span></a>
	<div class="javo-quick-contact-us-content">
		<form role="form">
			<h4 class="javo-accent bold-string margin-4-6 border-bottom-dashed-1px-9c9c9c padding-b2"><?php _e('Contact', 'javo_fr');?></h4>
			<div class="row">
				<div class="col-md-12">
					<span class="glyphicon glyphicon-user"></span><input id="javo_rb_contact_name" class="form-control" placeholder="<?php _e('Name', 'javo_fr');?>">
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<span class="glyphicon glyphicon-envelope"></span><input id="javo_rb_contact_from" class="form-control" placeholder="<?php _e('Email', 'javo_fr');?>">
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<span class="glyphicon glyphicon-comment"></span><textarea rows="5" id="javo_rb_contact_content" class="form-control" placeholder="<?php _e('Content', 'javo_fr');?>"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<input type="button" id="javo_rb_contact_submit" class="btn btn-primary javo-dark javo-accent margin-10-0" value="<?php _e('Submit', 'javo_fr');?>">
				</div>
			</div>
		</form>
	</div>
	<?php
	$mail_alert_msg = Array(
		'to_null_msg'			=> __('Please, type email address.', 'javo_fr')
		, 'from_null_msg'		=> __('Please, type your email adress.', 'javo_fr')
		, 'subject_null_msg'	=> __('Please, type your name.', 'javo_fr')
		, 'content_null_msg'	=> __('Please, type your message', 'javo_fr')
		, 'failMsg'				=> __('Sorry, failed to send your message', 'javo_fr')
		, 'successMsg'			=> __('Successfully sent!', 'javo_fr')
		, 'confirmMsg'			=> __('Do you want to send this email ?', 'javo_fr')
	);
	$javo_favorite_alerts = Array(
		"nologin"=> __('if you wan`t favorite, please login.', 'javo_fr')
		, "save"=> ''
		, "unsave"=> ''
		, "error"=> __('Sorry, server error.', 'javo_fr')
		, "fail"=> __('favorite regist fail.', 'javo_fr')
	);
	if( is_user_logged_in() ){
		printf('<input type="hidden" class="javo-this-logged-in" value="use">');
	
	}
	?>

	<script type="text/javascript">
	jQuery(document).ready(function($){
		"use strict";
		jQuery("#javo_rb_contact_submit").on("click", function(){
			var options = {
				subject: $("#javo_rb_contact_name")
				, to:"<?php bloginfo('admin_email');?>"
				, from: $("#javo_rb_contact_from")
				, content: $("#javo_rb_contact_content")
				, to_null_msg: "<?php echo $mail_alert_msg['to_null_msg'];?>"
				, from_null_msg: "<?php echo $mail_alert_msg['from_null_msg'];?>"
				, subject_null_msg: "<?php echo $mail_alert_msg['subject_null_msg'];?>"
				, content_null_msg: "<?php echo $mail_alert_msg['content_null_msg'];?>"
				, successMsg: "<?php echo $mail_alert_msg['successMsg'];?>"
				, failMsg: "<?php echo $mail_alert_msg['failMsg'];?>"
				, confirmMsg: "<?php echo $mail_alert_msg['confirmMsg'];?>"
				, url:"<?php echo admin_url('admin-ajax.php');?>"
			};
			$.javo_mail(options);
		});
		$("a.javo_favorite").javo_favorite({
			url:"<?php echo admin_url('admin-ajax.php');?>"
			, user: "<?php echo get_current_user_id();?>"
			, str_nologin: "<?php echo $javo_favorite_alerts['nologin'];?>"
			, str_save: "<?php echo $javo_favorite_alerts['save'];?>"
			, str_unsave: "<?php echo $javo_favorite_alerts['unsave'];?>"
			, str_error: "<?php echo $javo_favorite_alerts['error'];?>"
			, str_fail: "<?php echo $javo_favorite_alerts['fail'];?>"
			, before: function(){
				if( !( $('.javo-this-logged-in').length > 0 ) ){
					$('#login_panel').modal();
					return false;				
				};
				return;			
			}
		});		
	});
</script>


<?php
get_template_part('templates/parts/modal', 'login'); //modal login
get_template_part('templates/parts/modal', 'contact-us'); //modal contact us
get_template_part('templates/parts/modal', 'map-brief'); //Map Brief
get_template_part("templates/parts/modal", "emailme"); // Link address send to me
get_template_part("templates/parts/modal", "reviews"); // reviews
echo stripslashes($javo_tso->get('analytics'));
?>
<?php wp_footer(); ?>
</div>
</body>
</html>