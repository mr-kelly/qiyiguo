<?php
	$this->load->view('header_view');
	
?>
	
<?=import_css('css/app/user/user_lookup.css');?>

<script type="text/javascript">
	$ajax_get_user_relation_btn_url = '<?=site_url("relation/ajax_get_user_relation_btn/" . $user["id"] );?>';
</script>
<?=import_js('js/app/user/user_lookup.js');?>


	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				

            	
            	<div id="lookup_head">
            		<?php $this->load->view('user/general_user_lookup_head');?>
            	</div>
            	
            	<div id="lookup_main">
            		
						
					<div id="lookup_home">
						<div id="lookup_aside"><?php // lookup页，用户详情的边栏 ?>
						
							<div class="lookup_aside_widget">
								<ul class="vertical_links sidebar_links">
									
									<li>
										<a class="tipsy_s" href="<?=site_url('mail?' . 'send_to=' . $user['id'] );?>" title="向<?=$user['name'];?>发送电邮">
											<span class="hover"></span>
											<span class="icon icon_email"></span>
											发电邮
										</a>
										
										
									</li>
									
									<?php if ( $user['website'] ): ?>
									<li>
										<a target="_blank" href="<?=$user['website'];?>">
											<span class="hover"></span>
											<span class="icon icon_blog"></span>
											个人网站
										</a>
									</li>
									<?php endif; ?>
									
									<?php if ( isset( $user['renren_url'] ) ): ?>
									<li>
										<a target="_blank" href="<?=$user['renren_url'];?>">
											<span class="hover"></span>
											<span class="icon icon_renren"></span>
											
											到他人人网
										</a>
									</li>
									<?php endif;?>

									<?php if ( $user['t_sina_url'] ): ?>
									<li>
										<a target="_blank" href="<?=$user['t_sina_url'];?>">
											<span class="hover"></span>
											<span class="icon icon_t_sina"></span>
											到他的新浪微博
										</a>
									</li>
									<?php endif; ?>
									
									<?php if ( $user['douban_url'] ): ?>
									<li>
										<a target="_blank" href="<?=$user['douban_url'];?>">
											<span class="hover"></span>
											<span class="icon icon_douban"></span>
											到他的豆瓣
										</a>
									</li>
									<?php endif; ?>
									<?php if ( $user['qq'] ): ?>
									<li>
										<a target="_blank" href="http://user.qzone.qq.com/<?=$user['qq'];?>">
											<span class="hover"></span>
											<span class="icon icon_qzone"></span>
											到他的QQ空间
										</a>
									</li>
									<li>
										<a class="tipsy_w" title="直接跟他QQ聊天" target="_blank" href="http://wpa.qq.com/msgrd?V=1&Uin=<?=$user['qq'];?>&Site=http://qiyiguo.cc&Menu=yes">
											<span class="hover"></span>
											<span class="icon icon_qq"></span>
											QQ聊天
										</a>
									</li>
									<?php
										endif;
									?>
									
									<? if ( !empty( $user['msn'] ) ) : ?>
									<li>
										<a class="tipsy_w" target="_blank" href="msnim:chat?contact=<?=$user['msn'];?>" title="他的MSN地址是<?=$user['msn'];?>">
											<span class="hover"></span>
											<span class="icon icon_msn"></span>
											MSN聊天
										</a>
									</li>
									<?php endif; ?>
									
									<? if ( !empty( $user['gtalk'] ) ) : ?>
									<li>
										<a onclick="return false;" class="tipsy_w" target="_blank" href="#" title="他的Gtalk地址是<?=$user['gtalk'];?>">
											<span class="hover"></span>
											<span class="icon icon_gtalk"></span>
											Gtalk聊天
										</a>
									</li>
									<?php endif; ?>
									
								</ul>
							</div>
							
							<?php 
								//$current_user_profile = get_current_user_profile();
								$this_love_status = $user['love_status'];
								
								if ( !empty($this_love_status) && $this_love_status !='single' && $lover ) :
									// 恋人user profile
									//$lover = kk_get_user( $current_user_profile['lover_id'] );
									
							?>
							<div class="lookup_aside_widget">
								<h2>另一半</h2>
								<ul class="users_list">
									<li>
										<div class="user_avatar">
											
											<img width="35" height="35" src="<?=get_user_avatar_url( $lover['id'] );?>" />
										</div>
										
										<div class="user_detail">
											<div>
												<a href="<?=site_url('u/' . $lover['id'] );?>">
													<?=$lover['name'];?>
												</a>
											</div>
											
											<div>
												<?php if ( $this_love_status == 'married' && $current_user_profile['gender'] == 'male' ): ?>
													<?= '妻子' ; ?>
												<?php elseif ( $this_love_status == 'married' && $current_user_profile['gender'] == 'female'  ) : ?>
													<?= '丈夫' ; ?>
												<?php elseif ( $this_love_status == 'inlove' ) : ?>
													<?= '恋人' ; ?>
												<?php elseif ( $this_love_status == 'persue' ) : ?>
													<?= '追求中' ; ?>
												<?php endif;?>
											</div>
										</div>
									</li>
								</ul>
								<?php //print_r( $lover ); ?>
							</div>
							<div class="clearboth"></div>
							
							<?php
								endif;
							?>
							
							
							<?php if ( !empty( $user_recommends ) ) : ?>
							<div class="lookup_aside_widget">
								<h2>推荐好友</h2>
								
								<? //print_r( $user_recommends ); ?>
								
								<ul class="users_list">
								<?php foreach ( $user_recommends as $user_recommend ) : ?>
									<li class="user">
									
										<div class="user_avatar">
											<img width="35" src="<?=get_user_avatar_url( $user_recommend['id'] );?>" />
										</div>
										
										<div class="user_detail">
											<div>
												<a href="<?=site_url('u/' . $user_recommend['id'] );?>">
													<?=$user_recommend['name'];?>
												</a>
											</div>
											
											<div>
												<!--为什么要推荐...-->
											</div>
										</div>
										
									</li>
								<?php endforeach; ?>
								</ul>
							</div>
							<?php endif; ?>
					
							
						</div>
						
						<div id="lookup_content">
							<?php
								$this->load->view('stream/general_stream_list', array(
									'stream' => $user_stream,
								));
							?>
							
							<?php
								// 用户没有stream时...
								if ( empty( $user_stream ) ):
							?>
								<div class="align_center grey">
									<h2>他在奇异果还是一动不动的</h2>
								</div>
							<?php endif; ?>
						
						</div>
						
						<div class="clearboth"></div>
						
						
					</div>
					
						
						
						
            		
            		<div class="clearboth"></div>
            		

				</div>
	

			

				
				
			</div>
		</div>

		
	</div>
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php $this->load->view('sidebar/sidebar_user_view');?>
			</div>
		</div>
	</div>
	

<?php
	$this->load->view('footer_view');
?>
