<?php
/*
* Template Name: item List
*/
$javo_query			= new javo_Array( $_POST );
$javo_list_query	= new javo_Array( $javo_query->get('filter', Array()));

get_header();?>
<div class="javo-page-variable-area">
	<?php
	$javo_item_filter_taxonomies = @unserialize(get_post_meta( get_the_ID() , "javo_item_tax", true));
	$javo_item_filter_terms = @unserialize(get_post_meta( get_the_ID() , "javo_item_terms", true));
	if(!empty($javo_item_filter_taxonomies)){
		foreach($javo_item_filter_taxonomies as $index=> $tax){
			if(!empty($javo_item_filter_terms[$index]) && !empty($tax) ){
				printf("<input type='hidden' class='javo_filter' data-tax='%s' data-term='%s'>",
						$tax, $javo_item_filter_terms[$index]);
			};
		}
	};?>
</div>




<div class="item-list-page-wrap" id="main-content">
	<div class="navbar navbar-default" role="navigation">
		<div class="collapse navbar-collapse" id="nav-col">
			<form class="navbar-form" role="search">
				<div class="container">
					<ul class="nav navbar-nav navbar-left">
						<li>									
							<div class="input-group input-group-md">
								<input type="text" class="form-control javo-listing-search-field" placeholder="<?php _e('Search', 'javo_fr');?>">
								<div class="input-group-btn">
									<button class="btn btn-default javo-listing-submit"><i class="glyphicon glyphicon-search"></i></button>
								</div>
							</div>
						</li>				
						<li>
							<!-- Category Filter -->
							<div class="btn-group">
								<div class="sel-box">
									<div class="sel-container">
										<i class="sel-arraow"></i>
										<input type="text" readonly value="<?php echo $javo_list_query->get('location', __("All Category","javo_fr")); ?>" class="form-control input-md">
										<input type="hidden" name="filter[item_category]" value="<?php echo $javo_list_query->get('location', null); ?>" data-filter data-category="item_category">
									</div><!-- /.sel-container -->
									<div class="sel-content">
										<ul>
											<li class="item_category" value="" data-filter><?php _e('All Category', 'javo_fr');?></li>
											<?php
											$javo_get_this_terms = get_terms('item_category', Array('hide_empty'=>0));
											foreach($javo_get_this_terms as $term){
												printf('<li class="item_category" value="%s" data-filter>%s</li>', $term->term_id, $term->name);
											}; ?>
										</ul>
									</div><!-- /.sel-content -->
								</div><!-- /.sel-box -->
							</div><!-- /.btn-group -->

							<!-- Location Filter -->
							<div class="btn-group">
								<div class="sel-box">
									<div class="sel-container">
										<i class="sel-arraow"></i>
										<input type="text" readonly value="<?php echo $javo_list_query->get('location', __("All Locaiton","javo_fr")); ?>" class="form-control input-md">
										<input type="hidden" name="filter[item_location]" value="<?php echo $javo_list_query->get('location', null); ?>" data-filter data-category="item_location">
									</div><!-- /.sel-container -->
									<div class="sel-content">
										<ul>
											<li class="item_location" value="" data-filter><?php _e('All Location', 'javo_fr');?></li>
											<?php
											$javo_get_this_terms = get_terms('item_location', Array('hide_empty'=>0));
											foreach($javo_get_this_terms as $term){
												printf('<li class="item_location" value="%s" data-filter>%s</li>', $term->term_id, $term->name);
											}; ?>
										</ul>
									</div><!-- /.sel-content -->
								</div><!-- /.sel-box -->
							</div><!-- /.btn-group -->

							<!-- Display Post -->
							<div class="btn-group">
								<div class="sel-box">
									<div class="sel-container">
										<i class="sel-arraow"></i>
										<input type="text" readonly value="<?php _e("Views","javo_fr"); ?>" class="form-control input-md">
										<input type="hidden" name="type">
									</div><!-- /.sel-container -->
									<div class="sel-content">
										<ul>
											<li data-javo-hmap-ppp data-value='' value=''><?php _e('Views' ,'javo_fr');?></li>
											<li data-javo-hmap-ppp data-value='5' value='5'><?php _e('5 views' ,'javo_fr');?></li>
											<li data-javo-hmap-ppp data-value='10' value='10'><?php _e('10 views' ,'javo_fr');?></li>
											<li data-javo-hmap-ppp data-value='15' value='15'><?php _e('15 views' ,'javo_fr');?></li>
											<li data-javo-hmap-ppp data-value='30' value='30'><?php _e('30 views' ,'javo_fr');?></li>
											<li data-javo-hmap-ppp data-value='60' value='60'><?php _e('60 views' ,'javo_fr');?></li>
											<li data-javo-hmap-ppp data-value='100' value='100'><?php _e('100 views' ,'javo_fr');?></li>
										</ul>
									</div><!-- /.sel-content -->
								</div><!-- /.sel-box -->
							</div>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-dark btn-sm active">
								<input type="radio" name="javo_btn_item_list_type" value="2" checked>
								<i class="glyphicon glyphicon-th"></i>
							</label>
							<label class="btn btn-dark btn-sm">
								<input type="radio" name="javo_btn_item_list_type" value="4">
								<i class="glyphicon glyphicon-th-list"></i>
							</label>
						</div>
					</ul>
				</div><!-- /.container -->
			</form><!-- /.nav-form -->
		</div><!-- /.navbar-collapse -->
	</div><!-- /.navbar-->

	<div class="container main-content-wrap">
	<?php
	if(have_posts()){
		the_post();
		$post_id = get_the_ID();
		printf('<div class="row"><div class="javo_output"></div></div>');
	};?>
	</div>
</div> <!-- item-list-page-wrap -->




<script type="text/template" id="javo-loading-html">
	<div class="text-center">
		<img src="<?php echo JAVO_IMG_DIR.'/loading_2.gif';?>">
	</div>
</script>
<script type="text/javascript">
(function($){
	"use strict";

	var javo_listings = {
		parametter:{}
		, options:{}
		, init: function(){
			this.options.post_type = "item";
			this.options.type = 2;
			this.options.page = 1;
			this.options.ppp = $(".javo_posts_per_page").val();
			this.output = $(".javo_output");
			this.output.css('marginTop', '50px');
			this.events();
			if( $('.javo_filter').length > 0){
				$(window).on('load', function(){
					$('.javo_filter').each(function(){
						$('li.' + $(this).data('tax') + '[value="' + $(this).data('term') + '"]').trigger('click');
					});
				});
			
			}else{
				this.run();
			};
			
		}, run: function(){
			var $object = this;

			this.parametter.url					= "<?php echo admin_url('admin-ajax.php');?>";
			this.parametter.loading				= "<?php echo JAVO_IMG_DIR;?>/loading_1.gif";
			this.parametter.txtKeyword			= $('.javo-listing-search-field');
			this.parametter.btnSubmit			= $('.javo-listing-submit');
			this.parametter.param				= this.options;
			this.parametter.selFilter			= $("[name^='filter']");
			this.parametter.map					= $(".javo_map_visible");
			this.parametter.before_callback		= function(){
				$object.output.html( $('#javo-loading-html').html() );
			};
			this.parametter.success_callback	= function(){
				var i = 0;
				$object.refresh();
				while( i <= 6 ){
					$($object.output.find('.javo-animation').get(i)).addClass('loaded');
					i++;				
				};
				$('.javo_detail_slide').each(function(){
					$(this).flexslider({
						animation:"slide",
						controlNav:false,
						slideshow:true,
					}).find('ul').magnificPopup({
						gallery:{ enabled: true }
						, delegate: 'u'
						, type: 'image'
					});
				});
				$('.javo-tooltip').each(function(i, e){
					var options = {};
					if( typeof( $(this).data('direction') ) != 'undefined' ){
						options.placement = $(this).data('direction');		
					};
					$(this).tooltip(options);
				});
			}; 

			this.output.javo_search(this.parametter);

		}, events:function(){
			var $object = this;
			$('body').on('click', '.toggle-full-mode', function(){

				$(document).toggleClass('content-full-mode');

			}).on('click', 'li[data-javo-hmap-ppp]', function(){

				$object.options.ppp = $(this).data('value');
				$object.run();

			}).on('click', 'li[data-filter]', function(){
				$object.parametter.selFilter = $("[name^='filter']");
				$object.run();
			}).on('change', '[name="javo_btn_item_list_type"]', function(){
				$object.options.type = $(this).val();
				$object.options.page = 1;
				$object.run();			
			});
			$('.javo-this-filter').each( function(c, v){
				var _this = $(this);
				$(this).on('click', 'a', function(){
					$(this).closest('.btn-group').children('button:first-child').children('a').text( $(this).text() );
					$(this).closest('ul').next().val( $(this).data('term') );

					$object.parametter.selFilter = $("[name^='filter']");
					$object.run();
				});
			});
		}, refresh:function(){
			$('.javo-rating-registed-score').each(function(k,v){
				$(this).raty({					
					starOff: '<?php echo JAVO_IMG_DIR?>/star-off-s.png'
					, starOn: '<?php echo JAVO_IMG_DIR?>/star-on-s.png'
					, starHalf: '<?php echo JAVO_IMG_DIR?>/star-half-s.png'
					, half: true
					, readOnly: true
					, score: $(this).data('score')
				}).css('width', '');
			});		
		
		}
	};
	javo_listings.init();
})(jQuery);
</script>
<?php get_footer();