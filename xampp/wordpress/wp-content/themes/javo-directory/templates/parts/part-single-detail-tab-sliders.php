<?php
global $post;
$detail_images = @unserialize(get_post_meta($post->ID, "detail_images", true));
if(!empty($detail_images)):
	echo '<div class="javo_detail_slide">';
		echo '<ul class="slides list-unstyled">';
		foreach($detail_images as $index => $image):
			$img_src = wp_get_attachment_image_src($image, 'full');
			if( !empty( $img_src ) ){
				printf('<li><i href="%s" style="cursor:pointer">%s</i></li>'
					, $img_src[0]
					, wp_get_attachment_image($image, 'javo-item-detail')
				);
			};
		endforeach;
		echo '</ul>';
	echo '</div>';
endif;
?>

<script type="text/javascript">
(function($){
	"use strict";
	$(".javo_detail_slide_cnt").flexslider({
		animation:"slide",
		controlNav:false,
		slideshow:false,
		animationLoop: false,
		itemWidth:80,
		itemMargin:2,
		asNavFor: ".javo_detail_slide"
	});

	$(".javo_detail_slide").flexslider({
		animation:"slide",
		controlNav:false,
		slideshow:true,
		sync: ".javo_detail_slide_cnt"
	}).magnificPopup({ 
		gallery:{ enabled: true }
		, delegate: 'i'
		, type: 'image'
	});

})(jQuery);
</script>
<!-- slide end -->