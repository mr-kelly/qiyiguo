<?php 
	$this->load->view('header_view'); 
	$ci =& get_instance();
?>



			<?=import_css('css/app/stream/ajax_get_stream.css');?>

            <?=import_css('css/app/group/group_lookup.css');?>
            
            <div id="content" class="two_columns">
				<div class="content_top">
            		<div class="content_bottom">
            		
						<div id="lookup_head">
						
							<div class="lookup_avatar">
								<a href="<?= get_group_logo_url( $group['id'] , 'big');?>" class="sexybox">
									<img class="avatar" width="100" height="100" src="<?= get_group_logo_url( $group['id'] ); ?>" />
								</a>
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
										<a href="<?=site_url('group/' . $group['id'] . '/event');?>">
											活动
										</a>
									</li>
									
									<li>
										<a href="<?=site_url('group/' . $group['id'] . '/chat');?>">
											聊天
										</a>
									</li>
									<li>
										<a href="<?=site_url('group/' . $group['id'] . '/album');?>">
											相簿
										</a>
									</li>
									
									<li>
										<a href="<?=site_url('group/' . $group['id'] . '/stream');?>">
											新闻台
										</a>
									</li>
								</ul>
								
								
								<div id="group_home" class="hidden">
									
									<div id="group_topics_div">
										<h2>话题</h2>
										<p>...</p>
									</div>
									
									<div id="group_chat_div">
										<h2>聊天</h2>
										<p>...</p>
									</div>
									
									<div id="group_events_div">
										<h2>活动</h2>
										<p>...</p>
									</div>
									
									
									
								</div>
								
								
							</div>
            			</div>
            			
            			
            			<?php $this->load->view('group/general_join_group_view'); ?>
						
						
						
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
       
