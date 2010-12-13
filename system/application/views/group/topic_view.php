<?php 
	$this->load->view('header_view'); 
	$ci =& get_instance();
?>
	
	<div id="content" class="two_columns">
		<h2><?=$topic['title'];?></h2>
		<p>
			<?=$topic['content'];?>
		</p>
		
		
		<!-- ajax 评论 -->
		<ul class="chats_container no_scroll" style="margin-left:10px; max-height:none;">
		
		</ul>
		
		
	</div>
	
	
	<script>
		$(function(){
			$('.chats_container').load('<?=site_url("chat/ajax_get_chats/group_topic/" . $topic["id"] );?>');
		});
	</script>





	<div id="aside">
	
	</div>
<?php $this->load->view('footer_view'); ?>