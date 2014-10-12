<?php

class javo_item_price{
	public function __construct(){
		add_shortcode("javo_item_price", Array($this, "javo_item_price_callback"));
	}
	public function javo_item_price_callback($atts, $content=""){
		global $javo_tso;
		extract(shortcode_atts(
			Array(
				"items"=>4
			), $atts)
		);
		ob_start();?>
	<div class="sc-wrap"><div class="container">
		<div class="javo-item-price row">
			<div class="col-md-12 sc-pro-title">
				<div class="line-title-bigdots">
					<h2><span><?php _e('items publish items prices', 'javo_fr'); ?></span></h2>
				</div> <!-- icon-title -->
			</div>
			<div class="col-sm-3 javo-item-price-items">
				<div class="panel panel-default text-center">
					<div class="panel-heading">
						<h3 class="panel-title"><?php _e('Basic', 'javo_fr');?></h3>
					</div>
					<div class="panel-body">
						<h3 class="panel-title price"><?php printf('$%s', number_format($javo_tso->get('pay_item1_price', 0)))?></span></h3>
					</div>
					<ul class="list-group">
						<li class="list-group-item"><?php printf('%s %s', $javo_tso->get('pay_item1_cnt', 0), __('items', 'javo_fr'))?></li>
						<li class="list-group-item"><?php printf('%s %s', $javo_tso->get('pay_item1_expired', 0), __('Expired', 'javo_fr'))?></li>
						<li class="list-group-item">
							<?php
							$paypal_page = get_permalink($javo_tso->get('page_items_active'));
							$paypal_page_part = Array(
								"cancel_return"=> $paypal_page."?cancel",
								"notify_url"=> $paypal_page."?notify",
								"return"=> $paypal_page,
							);
							$paypal_custom = "user=".get_current_user_id()."&item_id=1&items=".$javo_tso->get('pay_item1_cnt', 0)."&expired=".$javo_tso->get('pay_item1_expired', 0);?>
							<form method="post" action="https://www.sandbox.paypal.com/cgi-bin/webscr">
								<input type="hidden" name="custom" value="<?php echo $paypal_custom;?>">
								<input type="hidden" name="notify_url" value="<?php echo $paypal_page_part['notify_url'];?>">
								<input type="hidden" name="cancel_return" value="<?php echo $paypal_page_part['cancel_return'];?>">
								<input type="hidden" name="return" value="<?php echo $paypal_page_part['return'];?>">
								<input type="hidden" name="item_name" value="items">
								<input type="hidden" name="business" value="freeace00@gmail.com">
								<input type="hidden" name="rm" value="2">
								<input type="hidden" name="cmd" value="_xclick">
								<input type="hidden" name="amount" value="<?php echo $javo_tso->get('pay_item1_price', 0);?>">
								<input type="hidden" name="currency_code" id="currency_code" value="USD">
								<input class="btn btn-default" type="submit" value="Sign Up Now!">
							</form>
						</li>
					</ul>
				</div><!-- Panel Close -->
			</div><!-- 3 Columns Close -->

			<div class="col-sm-3 javo-item-price-items">
				<div class="panel panel-warning text-center">
					<div class="panel-heading">
						<h3 class="panel-title"><?php _e('Plus', 'javo_fr');?></h3>
					</div>
					<div class="panel-body">
						<h3 class="panel-title price"><?php printf('$%s', number_format($javo_tso->get('pay_item2_price', 0)))?></span></h3>
					</div>
					<ul class="list-group">
						<li class="list-group-item"><?php printf('%s %s', $javo_tso->get('pay_item2_cnt', 0), __('items', 'javo_fr'))?></li>
						<li class="list-group-item"><?php printf('%s %s', $javo_tso->get('pay_item2_expired', 0), __('Expired', 'javo_fr'))?></li>
						<li class="list-group-item">
							<?php
							$paypal_page = get_permalink($javo_tso->get('page_items_active'));
							$paypal_page_part = Array(
								"cancel_return"=> $paypal_page."?cancel",
								"notify_url"=> $paypal_page."?notify",
								"return"=> $paypal_page,
							);
							$paypal_custom = "user=".get_current_user_id()."&item_id=2&items=".$javo_tso->get('pay_item2_cnt', 0)."&expired=".$javo_tso->get('pay_item2_expired', 0);?>
							<form method="post" action="https://www.sandbox.paypal.com/cgi-bin/webscr">
								<input type="hidden" name="custom" value="<?php echo $paypal_custom;?>">
								<input type="hidden" name="notify_url" value="<?php echo $paypal_page_part['notify_url'];?>">
								<input type="hidden" name="cancel_return" value="<?php echo $paypal_page_part['cancel_return'];?>">
								<input type="hidden" name="return" value="<?php echo $paypal_page_part['return'];?>">
								<input type="hidden" name="item_name" value="item posting publish">
								<input type="hidden" name="business" value="freeace00@gmail.com">
								<input type="hidden" name="rm" value="2">
								<input type="hidden" name="cmd" value="_xclick">
								<input type="hidden" name="amount" value="<?php echo $javo_tso->get('pay_item2_price', 0);?>">
								<input type="hidden" name="currency_code" id="currency_code" value="USD">
								<input class="btn btn-warning" type="submit" value="Sign Up Now!">
							</form>
						</li>
					</ul><!-- info list end -->
				</div><!-- Panel Close -->
			</div><!-- 3 Columns Close -->
			<div class="col-sm-3 javo-item-price-items">
				<div class="panel panel-primary text-center">
					<div class="panel-heading">
						<h3 class="panel-title"><?php _e('Premium', 'javo_fr');?></h3>
					</div>
					<div class="panel-body">
						<h3 class="panel-title price"><?php printf('$%s', number_format($javo_tso->get('pay_item1_price', 0)))?></span></h3>
					</div>
					<ul class="list-group">
						<li class="list-group-item"><?php printf('%s %s', $javo_tso->get('pay_item1_cnt', 0), __('items', 'javo_fr'))?></li>
						<li class="list-group-item"><?php printf('%s %s', $javo_tso->get('pay_item1_expired', 0), __('Expired', 'javo_fr'))?></li>
						<li class="list-group-item">
							<?php
							$paypal_page = get_permalink($javo_tso->get('page_items_active'));
							$paypal_page_part = Array(
								"cancel_return"=> $paypal_page."?cancel",
								"notify_url"=> $paypal_page."?notify",
								"return"=> $paypal_page,
							);
							$paypal_custom = "user=".get_current_user_id()."&item_id=1&items=".$javo_tso->get('pay_item1_cnt', 0)."&expired=".$javo_tso->get('pay_item1_expired', 0);?>
							<form method="post" action="https://www.sandbox.paypal.com/cgi-bin/webscr">
								<input type="hidden" name="custom" value="<?php echo $paypal_custom;?>">
								<input type="hidden" name="notify_url" value="<?php echo $paypal_page_part['notify_url'];?>">
								<input type="hidden" name="cancel_return" value="<?php echo $paypal_page_part['cancel_return'];?>">
								<input type="hidden" name="return" value="<?php echo $paypal_page_part['return'];?>">
								<input type="hidden" name="item_name" value="items">
								<input type="hidden" name="business" value="freeace00@gmail.com">
								<input type="hidden" name="rm" value="2">
								<input type="hidden" name="cmd" value="_xclick">
								<input type="hidden" name="amount" value="<?php echo $javo_tso->get('pay_item1_price', 0);?>">
								<input type="hidden" name="currency_code" id="currency_code" value="USD">
								<input class="btn btn-primary" type="submit" value="Sign Up Now!">
							</form>
						</li>
					</ul>
				</div><!-- Panel Close -->
			</div><!-- 3 Columns Close -->

			<div class="col-sm-3 javo-item-price-items">
				<div class="panel panel-danger text-center">
					<div class="panel-heading">
						<h3 class="panel-title"><?php _e('Ultimate', 'javo_fr');?></h3>
					</div>
					<div class="panel-body">
						<h3 class="panel-title price"><?php printf('$%s', number_format($javo_tso->get('pay_item2_price', 0)))?></span></h3>
					</div>
					<ul class="list-group">
						<li class="list-group-item"><?php printf('%s %s', $javo_tso->get('pay_item2_cnt', 0), __('items', 'javo_fr'))?></li>
						<li class="list-group-item"><?php printf('%s %s', $javo_tso->get('pay_item2_expired', 0), __('Expired', 'javo_fr'))?></li>
						<li class="list-group-item">
							<?php
							$paypal_page = get_permalink($javo_tso->get('page_items_active'));
							$paypal_page_part = Array(
								"cancel_return"=> $paypal_page."?cancel",
								"notify_url"=> $paypal_page."?notify",
								"return"=> $paypal_page,
							);
							$paypal_custom = "user=".get_current_user_id()."&item_id=2&items=".$javo_tso->get('pay_item2_cnt', 0)."&expired=".$javo_tso->get('pay_item2_expired', 0);?>
							<form method="post" action="https://www.sandbox.paypal.com/cgi-bin/webscr">
								<input type="hidden" name="custom" value="<?php echo $paypal_custom;?>">
								<input type="hidden" name="notify_url" value="<?php echo $paypal_page_part['notify_url'];?>">
								<input type="hidden" name="cancel_return" value="<?php echo $paypal_page_part['cancel_return'];?>">
								<input type="hidden" name="return" value="<?php echo $paypal_page_part['return'];?>">
								<input type="hidden" name="item_name" value="item posting publish">
								<input type="hidden" name="business" value="freeace00@gmail.com">
								<input type="hidden" name="rm" value="2">
								<input type="hidden" name="cmd" value="_xclick">
								<input type="hidden" name="amount" value="<?php echo $javo_tso->get('pay_item2_price', 0);?>">
								<input type="hidden" name="currency_code" id="currency_code" value="USD">
								<input class="btn btn-danger" type="submit" value="Sign Up Now!">
							</form>
						</li>
					</ul><!-- info list end -->
				</div><!-- Panel Close -->
			</div><!-- 3 Columns Close -->
		</div><!-- javo-item-Prices Close -->
	</div> <!-- container --> </div> <!-- sc-wrap -->
		<script type="text/javascript">
		(function($){
			"use strict";
			var javo_item_load = false;
			$(window).on('scroll', function(){
				if((($(this).outerHeight() + $(this).scrollTop()) >=
				$(".javo-item-price").offset().top) && !javo_item_load){
					javo_item_load = true;
					$(".javo-item-price-items").each(function(k, e){
						$(this).delay(k * 800).animate({ marginLeft:'0px', opacity:1 }, 500);
					});
				};
			});
		})(jQuery);
		</script>




		<?php
		$content = ob_get_clean();
		return $content;
	}
}
new javo_item_price();