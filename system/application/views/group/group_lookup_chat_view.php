<?php
	$this->load->view('header_view');
?>

	<?=import_css('css/app/group/group_lookup.css');?>
	
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<div id="lookup_head">
				
					<div class="lookup_avatar">
						<img class="avatar" width="100" height="100" src="<?= get_group_logo_url( $group['id'] ); ?>" />
					</div>
					
					<div class="lookup_easy_profile">
						<h2>
							<span class="icon icon_group tipsy_s" title="这是一个果群"></span>
							<?=$group['name'];?>
						</h2>
					</div>
				
				</div>
				
				
				
				<div id="lookup_main">
				
					<div class="kk_tabs">
						<ul>
							<li>
								<a href="<?=site_url('group/' . $group['id'] );?>">
									首页
								</a>
							</li>
							<li>
								<a class="" href="<?=site_url('group/' . $group['id'] . '/topic');?>">
									话题
								</a>
							</li>
							<li>
								<a class="selected" href="#group_topic_chat">
									聊天
								</a>
							</li>
							<li>
								<a href="<?=site_url('group/' . $group['id'] . '/stream');?>">
									新闻台
								</a>
							</li>
						</ul>
						
						<div id="group_topic_chat">

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
	</div>

<?php
	$this->load->view('footer_view');
?>