<?php 
	$this->load->view('header_view'); 
	$ci =& get_instance();
?>



			<?=import_css('css/app/stream/ajax_get_stream.css');?>

            
            
            <div id="content" class="two_columns">
				<div class="content_top">
            		<div class="content_bottom">
            		
            			<div class="kk_tabs">
            				<ul>
            					<li>
            						<a href="#group_home">
            							首页
            						</a>
            					</li>
            					<li>
            						<a href="<?=site_url('group/' . $group['id'] . '/topic');?>">
            							话题
            						</a>
            					</li>
            					<li>
            						<a href="<?=site_url('group/' . $group['id'] . '/stream');?>">
            							新闻台
            						</a>
            					</li>
            				</ul>
            				
            				
            				<div id="group_home" class="hidden">
            					群组首页
            				</div>
            				
            				
            			</div>
            			
            			
						<?php if ( $this->tank_auth->is_logged_in() ) { ?>
							<!--<iframe iframeborder="0" src="<?=site_url('group/join_group/'.$group['id'])?>"></iframe>-->
						<?php } ?>
						
						<?php
							// 点击加入后
							// post 到join_group,
							// 若返回错误
							// 出现消息框，输入验证信息
						?>
						
						<?php
							
							// 未加入
							if ( !$ci->group_model->is_group_user($group['id'], get_current_user_profile('id')) ) {
							
						?>
		
						
						<?php
								// 未加入，但在审核,显示审核中		
								if ( $ci->request_model->is_request_group( $group['id'], $this->tank_auth->get_user_id() )) {
									echo '审核中';
								} elseif( $group['verify'] == 'closed' ) {
									// 未加入，但该group拒绝加入，私密group
									echo '拒绝加入';
									
								} else {
									// 未加入，不在审核, 显示加入按钮
						?>
									<a class="medium blue awesome join_group_btn" href="<?=site_url("group/join_group/". $group["id"]);?>">
										<span><span>加入</span></span>
									</a>
									
									
									<script>
										$(function(){
											$('.join_group_btn').click(function(){
												$.post(
													$(this).attr('href'),
													{
														message: $('#group_message').val()
													},
													function(data) {
														alert(data);
														data = $.parseJSON(data);
														
														if ( data.status == 0 ) {
															// 返回失败，并且data提示信息为message，那么显示输入message
															if ( data.data == 'message') {
																$('#join_group_box').fadeIn();	
															}
															//alert($('#group_message').val());
														}
														
														if ( data.status == 1 ) {
															// 成功添加请求
															window.location = '';
														}
												});
												return false;
											});
										});
									</script>
						<?php
									
								}
							} else {
								// 已经加入该group
								echo '已加入';
								
								if ($ci->group_model->is_group_admin($group['id'], get_current_user_profile('id'))):
						?>
									,还是管理员<a href="<?=site_url('group/setting/'.$group['id']);?>">友群设置</a>
						<?php
								endif;
							}
		
						?>
						
						<script>
							$(function(){
								$('.tabs').tabs();
							});
						</script>
						
						
						<!-- Start Tab -->
						<div class="tabs">
							<ul>
								<li><a href="#topic_container_tab">话题</a></li>
								<li>
									<a href="<?=site_url('group/ajax_get_group_t_sina/' . $group['id']);?>">
										成员微博
									</a>
								</li>
							</ul>
							
							<div id="topic_container_tab" class="topic_container">


								<?php
									// 判断用户是否属于该群组，属于，可以发文章
									if ( $ci->group_model->is_group_user( $group['id'], $this->tank_auth->get_user_id() ) ):
								?>
								<a class="large awesome" href="#" onclick="$('#topic_publisher').slideToggle();return false;">发表话题</a>
								<div id="topic_publisher" class="hidden">
									<div class="form_div">
										<form method="post" action="<?=site_url('group/topic/');?>">
			
											<p>
												<span>主题</span>
												<input type="text" name="topic_title" />
											</p>
											
												<span>正文</span>
												
												<div>
													<textarea rows="1" id="topic_editor" name="topic_content"></textarea>
												</div>
												
			
											
											
												<?//import_js('ckeditor/adapters/jquery.js');?>
												<script>
													CKEDITOR.replace('topic_editor');
												</script>
												
												
											<input type="hidden" name="topic_group_id" value="<?=$group['id'];?>" />
											
											<p>
												<button type="submit" class="awesome blue small">
													发布
												</button>
											</p>
										
										</form>
									</div>			
								</div>
								<?php
									endif;  // 以上显示。，能发布友群文章时
								?>
								
								
								
								<ul class="group_topics_list">
								<?php foreach ( $topics as $key=>$topic ) : ?>
									<li class="group_topic">
										<div class="group_topic_user">
											<? // 用户头像、名字、 topic的作者 ?>
											<img width="50" src="<?=get_user_avatar_url(  $topic['User']['id'], false );?>" />
			
										</div>
										
										<div class="group_topic_detail">
										
											<?php
												$ci =& get_instance();
												$ci->load->library('humanize');
												// 人性化的日期时间..几天前...
												// datetime
											?>
											<span class="small group_topic_date">
												<?=$ci->humanize->datetime( $topic['created'] );?>
											</span>
											
											
											<span class="group_topic_title">
												<a href="<?=site_url('group/topic/' . $topic['id']);?>">
													<?=$topic['title'];?>
												</a>
											</span>
			
											
											<div>
												<span class="small">
													-
												</span>
												<a href="<?=site_url('user/'.$topic['User']['id']);?>">
													<span class="small">
														<?=$topic['User']['name'];?>
													</span>
												</a>
											</div>
											
											<div>
												<?php
													$content = strip_tags($topic['content']);
													echo $content;
												?>
											</div>
										</div>
										
										
			
										
										<div class="group_topic_panel">
											<div class="group_topic_controller">
												<a href="<?=site_url('chat/ajax_get_chats/group_topic/' . $topic['id']);?>?ajax=<?=rand();?>" class="btn chat_button">
													
													<?php
														// 获取评论数目
														$ci =& get_instance();
														$ci->load->model('chat_model');
														$chat_count = $ci->chat_model->get_chats_count('group_topic', $topic['id']);
													?>
													
													<span><span><?= ( $chat_count ) ? $chat_count . '条评论' : '评 论';?></span></span>
												</a>
											</div>
											
			<!-- 
											<div>
												<form class="chat_form" method="post" action="<?=site_url('chat/add/group_topic/'. $topic['id'] . '?redirect=' . uri_string() );?>">
													<input style="width:250px;" type="text" name="chat_content" />
													<input type="hidden" name="chat_parent_id" value="0" />
													
													<input type="submit" class="awesome small" />
													
													<div class="red target_message"></div>
													
												</form>
												
											</div>
			 -->
											
											<ul class="hidden group_topic_chats chats_container">
												
											</ul>
											
		
		
		<?php
			// 存在最后一条评论，那么显示最后一条评论
			$latest_chat = $topic['latest_chat'];
			if ( $latest_chat ) :	
		?>
											<!-- Chat Preview -->
											<div class="chats_preview">
											
												<div class="chat_item">
		
													<div class="chat_avatar">
														<a target="_top" href="<?=site_url( 'user/' . $latest_chat['User']['id']);?>">
															<img class="avatar" width="30" src="<?=get_user_avatar_url($latest_chat['User']['id']);?>" />
														</a>
													</div>
													
													<div class="chat_detail">
									
									
														
														<?php
															$ci =& get_instance();
															$ci->load->library('humanize');
														?>
														<span class="chat_date float_right">
									
															<?=$ci->humanize->datetime( $latest_chat['created'] );?>
														</span>
														
														
														
														
														
														<a target="_top" href="<?=site_url( 'user/' . $latest_chat['User']['id']);?>">
															<?=$latest_chat['User']['name'];?>
														</a>
														
														
														
														<div class="chat_content">
															
															
															
															
															<?=$latest_chat['content'];?>
															
															
														</div>
														<a href="#" class="latest_chat_reply"> &nbsp;[查看所有回复]</a>
														
													</div>
													
												</div>
												
												
											</div> <?php // Chat Preview End ?>
		
		<?php endif; // End Chat Preview ?>								
											
			
										</div>
										
		
										
			
										
									</li>
								<?php endforeach; ?>
								</ul>
								
								<?=import_js('js/app/group/group_lookup.js');?>
								
										<script>
			
										</script>
							</div>
							
							
						</div><!-- End Tab -->
     
					</div><!--content bottom-->
     			</div><!-- content top-->
            </div>
            
            <div id="sidebar">
            	<div class="sidebar_top">
            		<div class="sidebar_bottom">
						<?php $this->load->view('aside/aside_group_view'); ?>
					</div>
				</div>
				
            </div>
<?php $this->load->view('footer_view'); ?>

<!-- Join Group Box 用于输入加入小组的验证信息 -->


        <div id="join_group_box" class="hidden"> 
			<div class="ui-overlay">
				<div class="ui-widget-overlay"></div>
				<div class="ui-widget-shadow ui-corner-all" style="width: 422px; height: 322px; position: absolute; left: 30%; top: 20%;"></div>
	
			</div>
			<div style="position: absolute; width: 400px; height: 300px;left: 30%; top: 20%; padding: 10px;" class="ui-widget ui-widget-content ui-corner-all">
					<div class="ui-dialog-content ui-widget-content" style="background: none; border: 0;">
						
						<textarea id="group_message" name="group_message"></textarea>
						<a class="btn join_group_btn" href="<?=site_url("group/join_group/". $group["id"]);?>">
							<span><span>加入</span></span>
						</a>

						<a href="#" onclick="$('#join_group_box').fadeOut();return false;">Close</a>
					</div>
			</div>
        </div>
       
