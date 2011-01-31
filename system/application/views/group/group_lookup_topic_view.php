<?php 
	$this->load->view('header_view'); 
	$ci =& get_instance();
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<div class="kk_tabs">
					<ul>
						<li>
							<a href="<?=site_url('group/' . $group['id'] );?>">
								首页
							</a>
						</li>
						<li>
							<a class="selected" href="#group_topic_tab">
								话题
							</a>
						</li>
						<li>
							<a href="<?=site_url('group/' . $group['id'] . '/stream');?>">
								新闻台
							</a>
						</li>
					</ul>
					
					
					<div id="group_topic_tab">
					

								<?php
									// 判断用户是否属于该群组，属于，可以发文章
									if ( $ci->group_model->is_group_user( $group['id'], $this->tank_auth->get_user_id() ) ):
								?>
								<a href="#">发表话题</a>
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
									

									
									
									<?php if ( $topic['title'] != '' ) : //标题可用？ ?>
										<span class="topic_title">
											<a href="<?=site_url('group/topic/' . $topic['id']);?>">
												<?=$topic['title'];?>
											</a>
										</span>
										
											<span class="small">
												-
											</span>
									<?php endif; ?>

									<span>
										<a href="<?=site_url('user/'.$topic['User']['id']);?>">
											<span class="small">
												<?=$topic['User']['name'];?>
											</span>
										</a>
									</span>
									
									
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
						
						
					</div>
					
					
				</div>
				<?=import_js('js/app/group/group_lookup.js');?>
				
				
					
			</div>
		</div>
	</div>

<?php 
	$this->load->view('footer_view'); 
?>