<?php 
	$this->load->view('header_view'); 
	$ci =& get_instance();
	
?>



			<?=import_css('css/app/stream/ajax_get_stream.css');?>

            <?=import_css('css/app/group/group_lookup.css');?>
            
            <?=import_js('js/app/group/group_lookup.js');?>
            
            <?=import_js('js/app/topic/general_topics_list.js');?>
            

            
            <div id="content" class="two_columns">
				<div class="content_top">
            		<div class="content_bottom">
            		
						<div id="lookup_head">
							<?php // 群组简介 ?>
							<?php $this->load->view('group/general_group_lookup_head');?>
						</div>
						
					
            			
            			<div id="lookup_main">
            			
							<?php
								// 普通用户非统治模式、 管理员统治模式可发话
								
								if ( 
									( is_group_user( $group['id'], get_current_user_id() ) && !$group['admin_mode'] )
									||
									( is_group_admin( $group['id'], get_current_user_id() ) && $group['admin_mode'] )
								   ) :
								?>
									<div class="add_btn_div">
										<a onclick="$('.add_topic_div').toggle();$('.add_event_div').hide();return false;" title="向果群发话" class="tipsy_s btn add_topic_btn" href="#">
											发话▼
										</a>
										
										<a onclick="$('.add_event_div').toggle();$('.add_topic_div').hide();return false;" href="#" title="创建一个新<?= $group['privacy'] == 'public' ? '活动' : '任务';?>" class="add_event_btn tipsy_s btn">
											<span><span>新<?= $group['privacy'] == 'public' ? '活动' : '任务';?>▼</span></span>
										</a>
										
										<div class="clearboth"></div>
									</div>
									
									
									<div class="add_event_btn_div">								
	
									</div>
									
									<? // 放置 填写主题层 ?>
									<?php
										$this->load->view('topic/ajax_add_topic_view', array(
											'model' => 'group',
											'model_id' => $group['id'],
											'hidden' => true,
										));
									?>
									
									<? // 发布活动、人物层 ?>
									<div class="add_event_btn_div">
										<?php
											$this->load->view('event/ajax_add_event_view', array(
												'model' => 'group',
												'model_id' => $group['id'],
												'hidden' => true,
											));
										?>
									</div>
								
								<?php
								   
								else:
									if ( $group['admin_mode'] ) :
										// 统治模式..
								?>
									<div class="grey">
										统治模式的群。管理者才可以发话和创建活动
									</div>
								<?php
									else:
								?>
									<div class="grey">
										...关注/加入群获得发言权
									</div>
								<?php
									endif;
								endif;
								
// 								if ( ! $group['admin_mode'] ) :
// 									// 不是统治模式时
// 									if ( is_group_user( $group['id'] , get_current_user_id() ):
// 									
// 									else:
// 										// 不能发布
// 									endif;
// 								else:
// 									if ( is_group_admin( $group['id'], get_current_user_id() ) :
// 									
// 									else:
// 										// 管理员only
// 									endif;
								
								
//								if ( is_group_user( $group['id'], $this->tank_auth->get_user_id() ) ):
									
							?>
<!-- 
								<div class="add_btn_div">
									<a onclick="$('.add_topic_div').toggle();$('.add_event_div').hide();return false;" title="向果群发话" class="tipsy_s btn add_topic_btn" href="#">
										发话▼
									</a>
									
									<a onclick="$('.add_event_div').toggle();$('.add_topic_div').hide();return false;" href="#" title="创建一个新<?= $group['privacy'] == 'public' ? '活动' : '任务';?>" class="add_event_btn tipsy_s btn">
										<span><span>新<?= $group['privacy'] == 'public' ? '活动' : '任务';?>▼</span></span>
									</a>
									
									<div class="clearboth"></div>
								</div>
								
								
								<div class="add_event_btn_div">								

								</div>
 -->
								
								<? // 放置 填写主题层 ?>
								<?php
//									$this->load->view('topic/ajax_add_topic_view', array(
//										'model' => 'group',
//										'model_id' => $group['id'],
//										'hidden' => true,
//									));
								?>
								
								<? // 发布活动、人物层 ?>
								<!--
								<div class="add_event_btn_div">
									<?php
//										$this->load->view('event/ajax_add_event_view', array(
//											'model' => 'group',
//											'model_id' => $group['id'],
//											'hidden' => true,
//										));
									?>
								</div>-->
							
							
							<?php
//								else:
									// 不能发布时~
							?>
							<!--
								<div class="grey">
									...关注/加入群获得发言权
								</div>
								-->
							<?php
//								endif;  // 以上显示。，能发布友群文章时
							?>
					
					
							<div id="lookup_aside">
								<h2>成员 <?= isset($group_users_count) ? ' <span class="small">('. $group_users_count .')</span>' :'';?></h2>
								
								<div class="lookup_aside_widget">
									
									<?php
										$this->load->view('general/general_group_users_list', array(
											'users' => $group_users,
										));
									?>
									
									<div class="align_right">
										<a href="<?=site_url('group/' . $group['id'] . '/members' );?>">
											&gt;查看成员列表
										</a>
									</div>
									
								</div>
								
						<!--
								<div id="group_events_div">
									<h2><?= $group['privacy'] == 'public' ? '活动' : '任务';?></h2>
									<?php
										$this->load->view('event/general_events_list', array( 
											'dateonly' => true, 
											'no_group_logo' => true,
										) ); 
									?>
									
									<?php if ( count( $events ) >= 10 ) : ?>
									<div>
										<a href="<?=site_url('group/' . $group['id'] . '/event?start=10' );?>">
											&gt;更多活动
										</a>
									</div>
									<?php endif; ?>
									
									
								</div>
						-->
													
								
							</div>
							
							<div id="lookup_content">
								
								<div id="group_topics_div">
									<h2><?= $group['privacy'] == 'public' ? '话题' : '议论';?></h2>
									<?php $this->load->view('topic/general_topics_list', array(
										'chat_width' => 350, // 聊天窗口寬度~因為group_home右邊比較窄
									)); ?>
									
									<?php if ( count( $topics ) >= 10  ) : ?>
									<div>
										<a href="<?=site_url('group/' . $group['id'] . '/topic?start=10');?>">
											&gt;更多话题
										</a>
									</div>
									<?php endif; ?>
								</div>
								
								<!--
								<div id="group_chat_div">
									<h2>聊天</h2>
									<p>...</p>
								</div>
								-->
								

							</div>
							
							<!--<div id="group_home" class="tab_div">
								
							</div>-->
							<div class="clearboth"></div>
							
            			</div>
            			

						
					</div><!--content bottom-->
     			</div><!-- content top-->
            </div>
            
            <div id="sidebar">
            	<div class="sidebar_top">
            		<div class="sidebar_bottom">
						<?php $this->load->view('sidebar/sidebar_group_view'); ?>
					</div>
				</div>
				
            </div>
            
            
<?php $this->load->view('footer_view'); ?>


       
