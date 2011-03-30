<?php
	$ci =& get_instance();
?>

				<div class="topis_container">

					
					
					
						<ul class="topics_list">
					<?php
						// 群组话题不为空，显示
						if ( !empty($topics) ) : 
					?>
						<?php
							foreach ( $topics as $key=>$topic ) :
								if ( !isset( $topic['User'] ) || !isset( $topic['Group'] ) ) {
									$topic['User'] = kk_get_user( $topic['user_id'] );
									$topic['Group'] = kk_get_group( $topic['model_id'] );
								}
								
								$user_url = get_user_url( $topic['User']['id'] );
						?>
							<li class="topic">
								<div class="topic_user">
									<?php
										// 用户头像、名字、 topic的作者 
										if ( isset( $show_group_logo ) && $show_group_logo ) :
											$group_url = get_group_url( $topic['model_id'] );
									?>
									
									<a class="tipsy_s" title="来自群组「<?=$topic["Group"]['name'];?>」" href="<?=$group_url;?>">
										<img width="50" src="<?=get_group_logo_url( $topic['model_id'] );?>" />
									</a>
									
									<?php else: 	// 照旧显示人的头像吧?>
									
									<a href="<?=$user_url;?>">
										<img width="50" src="<?=get_user_avatar_url(  $topic['User']['id'], false );?>" />
									</a>
									
									<?php endif; ?>
				
								</div>
								
								<div class="topic_detail">
				
				
										
									<div class="topic_topic"><? // 话题的主题: 标题和人名 ?>
										<?php
											$ci =& get_instance();
											$ci->load->library('humanize');
											// 人性化的日期时间..几天前...
											// datetime
										?>
										<span class="small topic_date">
											<?=$ci->humanize->datetime( $topic['created'] );?>
										</span>
										
				
										
										
										<?php if ( $topic['title'] != '' ) : //标题可用？ ?>
											<span class="topic_title">
												<a href="<?=site_url('topic/' . $topic['id']);?>">
													<?=$topic['title'];?>
												</a>
											</span>
											
												<span class="small">
													-
												</span>
										<?php endif; ?>
				
										<span>
											<?php // 显示来源群？
												if ( isset( $show_group_logo ) && $show_group_logo ) : 
											?>
											来自 
											<a href="<?=$group_url;?>">
												<?=$topic['Group']['name'];?> 
											</a> 的 
											<?php endif; ?>
											<a href="<?=$user_url;?>">
												<span>

													<?=$topic['User']['name'];?>
												</span>
											</a>
										</span>
									</div>
									
									<div class="topic_content">
				
										<div>
											<?php
												//$content = strip_tags();
											?>
											<?= kk_content_preview( $topic['content'], 402, site_url('topic/' . $topic['id']) );?>
										</div>
										
										<?php if ( isset( $topic['Attach_Img'] ) ) : ?>
										<div class="topic_attach_img">
											<a class="sexybox" href="<?=site_url('static/upload/attach_img' . $topic['Attach_Img']['file']);?>">
												<img width="80" src="<?=site_url('static/upload/attach_img' . $topic['Attach_Img']['file']);?>" />
											</a>
											
											
										</div>
										<?php endif; ?>
										
										<?php if ( isset( $topic['Attach_File'] ) ) : ?>
										<div class="topic_attach_file">
											<span class="icon icon_<?=substr( $topic['Attach_File']['file_ext'], 1);?>">
												
												<a target="_blank" href="<?=site_url('attach/download/' . $topic['attach_file_id'] );?>">
													<?=$topic['Attach_File']['file_name'];?>
												</a>
											</span>
										</div>
										<?php endif; ?>
										
										
									</div>
									
				
								</div>
								
								
				
								
								<div class="topic_panel">
									<div class="topic_controller">
										<?php
										if ( !isset( $group ) ) { // 在群组的页
											$group = kk_get_group( $topic['model_id'] );
										}
										?>
										
										<?php
											// 发布者可以修改
											if ( $topic['user_id'] == get_current_user_id() ) :
										?>
										<a href="<?=site_url('topic/edit/' . $topic['id'] );?>" class="icon icon_edit">
											修改
										</a>
										<?php
											endif;
										?>
										<?php
										
											// 管理员、发布的用户可以删除
											if ( is_group_admin( $group['id'] , get_current_user_id() ) 
													|| $topic['user_id'] == get_current_user_id() 
													):
										?>
										<a href="#" onclick="return delete_btn(this);" class="icon icon_delete" ajax="<?=site_url('topic/ajax_delete/' . $topic['id']);?>">
											删除
										</a>
										<?php
											endif;
										?>
										<a href="<?=site_url('chat/ajax_get_chats/topic/' . $topic['id']);?>?ajax=<?=rand();?>&chat_width=<?= isset( $chat_width ) ? $chat_width : ''; ?>" class="btn chat_button">
											
											<?php
												// 获取评论数目
												$ci =& get_instance();
												$ci->load->model('chat_model');
												$chat_count = $ci->chat_model->get_chats_count('topic', $topic['id']);
											?>
											
											<span><span><?= ( $chat_count ) ? $chat_count . '条评论' : '评 论';?></span></span>
										</a>
									</div>
									
									<ul class="hidden topic_chats chats_container">
										
									</ul>
									
				
				
									<?php
									// 存在最后一条评论，那么显示最后一条评论
									if ( !empty( $topic['latest_chat'] ) ):
										$latest_chat = $topic['latest_chat'];
												
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
					<?php
						else: 
							// 群组为空？显示没有
					?>
						<div class="align_center grey">
							<b>还没有发布话题呢</b>
						</div>
					
					<?php endif; ?>
					
					
						</ul>
						
						
					
						
							
								
				</div><!-- END Topics Container -->
				
