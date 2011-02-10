<?php 
	$this->load->view('header_view'); 
	$ci =& get_instance();
?>
	
	<div id="content" class="two_columns">
		<div class="content_top">
			<div class="content_bottom">
				<h2><?=$topic['title'];?></h2>
				<div>
					<?=$topic['content'];?>
				</div>
				
				
				<!-- ajax 评论 -->
				<ul class="chats_container no_scroll" style="margin-left:10px; max-height:none;">
				
				</ul>
				
				<script>
					$(function(){
						$('.chats_container').load('<?=site_url("chat/ajax_get_chats/group_topic/" . $topic["id"] );?>');
					});
				</script>
			</div>
		</div>
	</div>
	
	






	<div id="aside">
	
	</div>
<?php $this->load->view('footer_view'); ?>