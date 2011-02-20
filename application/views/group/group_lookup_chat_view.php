<?php
	$this->load->view('header_view');
?>

	<?=import_css('css/app/group/group_lookup.css');?>
	
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
			
				<div id="lookup_head">
					<?php $this->load->view('group/general_group_lookup_head');?>
				</div>
				
				
				
				<div id="lookup_main">
			
					<div id="group_topic_chat" class="tab_div">
	
						<h2>群聊</h2>
						
						<!-- ajax 评论 -->
						<ul class="chats_container no_scroll" style="margin-left:10px; max-height:none;">
						
						</ul>
						
						<script>
							// 开关， 是否自动刷新群聊记录~  
							// 当用户聚焦输入框时，应该不自动刷新
							//  10秒自动刷新群聊记录
							var $chat_refresh_switch = setInterval( chat_refresh, $chat_refresh_time );
							
							function chat_refresh() {
								$('.chats_container').load('<?=site_url("chat/ajax_get_chats/group/" . $group["id"] );?>');
							}
							
							$(function(){
								chat_refresh();
							});
						</script>
	
					</div>

						
				</div>
			</div>
		</div>
	</div>


	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php $this->load->view('sidebar/sidebar_group_view'); ?>
			</div>
		</div>
	</div>
	
	
<?php
	$this->load->view('footer_view');
?>