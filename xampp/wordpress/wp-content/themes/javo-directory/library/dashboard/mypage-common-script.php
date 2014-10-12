<script type="text/javascript">
jQuery(function($){
	"use strict";
	var javo_mypage_script = {
		ajax:{}
		, events:function(){
			var $object = this;
			var $this;

			$("body")
			.on("click", ".javo_this_trash", function(e){
				e.preventDefault();
				$this = $(this);
				$object.ajax.data			= {}
				$object.ajax.data.post		= $this.data("post");
				$object.ajax.data.action	= "trash_item";
				$object.ajax.success		= function(d){

					if( d.result == "success" ){
						alert("<?php _e('Item Trash Success.', 'javo_fr');?>");
						$this.closest('.row.content-panel-wrap-row').remove();
					}else{
						alert("<?php _e('Delete failed. only need author permission.', 'javo_fr');?>");
					};

				};
				if(!confirm("Selected item item delete?")) return false;
				$.ajax( $object.ajax );
			})
			.on("click", ".javo-this-publish", function(e){
				e.preventDefault();
				$this = $(this);
				$object.ajax.data			= {}
				$object.ajax.data.post		= $this.data("post");
				$object.ajax.data.publish	= !( $this.hasClass('active') );
				$object.ajax.data.action	= "pause_item";
				$object.ajax.success		= function(d){
								
					if( d.state == "success"){
						if( $this.hasClass('active') ){
							$this
								.removeClass('active')
								.find('i')
								.prop('class', 'glyphicon glyphicon-play');
						}else{
							$this
								.addClass('active')
								.find('i')
								.prop('class', 'glyphicon glyphicon-pause');;
						};
					}else{
						alert( d.comment );
					};
					$this
						.removeClass('disabled')
						.prop('disabled', false);
				};
				$this
					.addClass('disabled')
					.prop('disabled', true);
				$.ajax( $object.ajax );
			}).on('click', '.toggle-full-mode', function(){
				$('body').toggleClass('content-full-mode');
			});
		} //-- Close Events();
		, init:function(){

			// Initialize Ajax Variable
			this.ajax.url		= "<?php echo admin_url('admin-ajax.php');?>";
			this.ajax.type		= "post";
			this.ajax.dataType	= "json";

			// Event handler
			this.events();

			// Initialize Active Plugins
			$('.mypage-tooltips').tooltip();
		
		
		
		}
	};
	javo_mypage_script.init();
});
</script>