<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Javo_Directory
 * @since Javo Themes 1.0
 */
get_header(); ?>
<div class="container error-page-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1><?php _e("Oops!", "javo-fr") ?></h1>
                <h2><?php _e("404 Not Found", "javo-fr") ?></h2>
                <div class="error-details">
                    <?php _e("Sorry, an error has occured, Requested page not found!", "javo-fr") ?>
                </div>
                <div class="error-actions">
                    <a href="" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span><?php _e(" Take Me Home", "javo-fr") ?></a>
					<a href="" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span>&nbsp; <?php _e("Contact Support", "javo-fr") ?> </a>
                </div>
				<div>
					<?php get_search_form(); ?>
				</div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>