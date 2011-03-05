<?php 
	$this->load->view('header_view'); 
	$ci =& get_instance();
	
?>



			<?=import_css('css/app/stream/ajax_get_stream.css');?>

            <?=import_css('css/app/group/group_lookup.css');?>
            
            <?=import_js('js/app/group/group_lookup.js');?>
            
            <div id="content" class="two_columns">
				<div class="content_top">
            		<div class="content_bottom">
            		
						<div id="lookup_head">
							<?php // 群组简介 ?>
							<?php $this->load->view('group/general_group_lookup_head');?>
						</div>
						
					
            			
            			<div id="lookup_main">
            			
							<?php
								// 判断用户是否属于该群组，属于，可以发文章
								if ( $ci->group_model->is_group_user( $group['id'], $this->tank_auth->get_user_id() ) ):
							?>
								<div class="add_btn_div">
									<a onclick="$('.add_topic_div').toggle();$('.add_event_div').hide();return false;" title="对果群发话~" class="tipsy_s kk_btn add_topic_btn" href="#">
										发话▼
									</a>
									
									<a onclick="$('.add_event_div').toggle();$('.add_topic_div').hide();return false;" href="#" title="对果群发话~" class="add_event_btn tipsy_s kk_btn">
										<span><span>新活动▼</span></span>
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
								endif;  // 以上显示。，能发布友群文章时
							?>
					
					
							<div id="lookup_aside">

								<div id="group_events_div">
									<h2>活动</h2>
									<?php $this->load->view('event/general_events_list', array( 'dateonly' => true, ) ); ?>
									
									<div>
										<a href="<?=site_url('group/' . $group['id'] . '/event' );?>">
											&gt;更多活动
										</a>
									</div>
								</div>
							</div>
							
							<div id="lookup_content">
								
								<div id="group_topics_div">
									<h2>话题</h2>
									<?php $this->load->view('topic/general_topics_list', array(
										'chat_width' => 350, // 聊天窗口寬度~因為group_home右邊比較窄
									)); ?>
									<a href="<?=site_url('group/' . $group['id'] . '/topic');?>">
										&gt;更多话题
									</a>
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
       
