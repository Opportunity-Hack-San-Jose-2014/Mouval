<?php
$javo_directory_query			= new javo_get_meta( get_the_ID() );
$javo_rating					= new javo_Rating( get_the_ID() );
global $javo_custom_field, $post;
$javo_this_author				= get_userdata($post->post_author);
$javo_this_author_avatar_id		= get_user_meta($javo_this_author->ID, 'avatar', true);
$javo_directory_query			= new javo_get_meta( get_the_ID() );
$javo_rating = new javo_Rating( get_the_ID() );
?>

<div class="tabs-wrap">
    <ul id="single-tabs" class="nav nav-pills nav-justified" data-tabs="single-tabs">
        <li class="active"><a href="#single-tab-detail" data-toggle="tab"><span class="glyphicon glyphicon-home"></span>&nbsp;<?php _e('About us', 'javo_fr'); ?></a></li>
        <li><a href="#single-tab-location" data-toggle="tab"><span class="glyphicon glyphicon-map-marker"></span>&nbsp;<?php _e('Location', 'javo_fr'); ?></a></li>
        <li><a href="#single-tab-events" data-toggle="tab"><span class="glyphicon glyphicon-heart-empty"></span>&nbsp;<?php _e('Events', 'javo_fr'); ?></a></li>
        <li><a href="#single-tab-ratings" data-toggle="tab"><span class="glyphicon glyphicon-star"></span>&nbsp;<?php _e('Ratings', 'javo_fr'); ?></a></li>
        <li><a href="#single-tab-reviews" data-toggle="tab"><span class="glyphicon glyphicon-comment"></span>&nbsp;<?php _e('Reviews', 'javo_fr'); ?></a></li>
    </ul>
    <div id="javo-single-tab" class="tab-content">
        <div class="tab-pane active" id="single-tab-detail">
           	<?php get_template_part('templates/parts/part', 'single-detail-tab');?>
        </div>
        <div class="tab-pane" id="single-tab-location">
            <?php get_template_part('templates/parts/part', 'single-maps');?>
			<p>&nbsp;</p>
			<?php get_template_part('templates/parts/part', 'single-contact');?>
        </div>
        <div class="tab-pane" id="single-tab-events">
          	<?php get_template_part('templates/parts/part', 'single-events');?>						
        </div>
        <div class="tab-pane" id="single-tab-ratings">
			<?php get_template_part('templates/parts/part', 'single-ratings-tab');?>
        </div>
        <div class="tab-pane" id="single-tab-reviews">
			<?php get_template_part('templates/parts/part', 'single-reviews');?>
        </div>
    </div>
</div> <!-- tabs-wrap -->
 
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#single-tabs').tab();
		// link to specific single-tabs
		var hash = location.hash
		  , hashPieces = hash.split('?')
		  , activeTab = $('[href=' + hashPieces[0] + ']');
		activeTab && activeTab.tab('show');
    });
</script>    




		<?php

// This post exists to latlng meta then,
if( !empty($latlng['lat']) && !empty($latlng['lng'])){ ?>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		"use strict";
		var option = {
			map:{
				options:{
					center: new google.maps.LatLng(<?php echo $latlng['lat'];?>, <?php echo $latlng['lng'];?>),
					zoom:15,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					mapTypeControl: false,
					navigationControl: true,
					scrollwheel: false,
					streetViewControl: true
				}
			},
			marker:{
				latLng:[<?php echo $latlng['lat'];?>, <?php echo $latlng['lng'];?>],
				draggable:true
			}
		};
		var header_option = {
				map:{
					options:{
						center: new google.maps.LatLng(<?php echo $latlng['lat'];?>, <?php echo $latlng['lng'];?>),
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						navigationControl: true,
						streetViewControl: true
					}
				}, streetviewpanorama:{
					options:{
						container: $(".map_area.header")
						, opts:{
							position: new google.maps.LatLng(<?php echo $latlng['lat'];?>, <?php echo $latlng['lng'];?>)
							,pov: { heading: 34, pitch:10, zoom:1 }
						}
					}
				}
			};
		$(".javo-single-map-area").css("height", $(".javo-single-map-area").parent().outerHeight() + 'px').gmap3(option);
	});
	</script>


	<?php }; ?>