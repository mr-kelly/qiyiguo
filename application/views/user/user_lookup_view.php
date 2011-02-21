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
									<?php
										endif;
									?>
								</ul>
							</div>
							
							<div class="lookup_aside_widget">
								<h2>推荐好友</h2>
								
								<? //print_r( $user_recommends ); ?>
								
								<div class="lookup_aside_content">
								<?php foreach ( $user_recommends as $user_recommend ) : ?>
									<div class="user">
										<div>
											<img width="50" src="<?=get_user_avatar_url( $user_recommend['id'] );?>" />
										</div>
										
										<div>
											<a href="<?=site_url('u/' . $user_recommend['id'] );?>">
												<?=$user_recommend['name'];?>
											</a>
										</div>
										
									</div>
								<?php endforeach; ?>
								</div>
							</div>
							
							<?php 
								$this_love_status = get_current_user_profile('love_status');
								if ( !empty($this_love_status) && $this_love_status !='single' ) :
							?>
							<div class="lookup_aside_widget">
								<h2>另一半</h2>
							</div>
							<?php
								endif;
							?>
							
						</div>
						
						<div id="lookup_content">
							<ul class="stream_list">
							<?php
								if ( isset( $stream ) ):
									foreach( $stream as $s ):
								//print_r( $stream );
							?>
								<li class="stream">
									<?=$s['text'];?>
								</li>
							<?php
									endforeach;
								endif;
							?>
							</ul>			
						
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
				<input value="告诉我，你今天心情如何？" />
				<div class="kk_tabs user_relation_tabs">
					<ul class="tab_menu">
						<?php
							$ci =& get_instance();
							$ci->load->model('relation_model');
						?>
						<li>
							<a href="#user_friends">
								朋友(<?=$ci->relation_model->get_friends_count( $user['id'] );?>)
							</a>
						</li>
						<li>
							<a href="#user_fans" class="tipsy_s" title="拥趸,即是粉丝的意思,是fans的意译">
								拥趸(<?=$ci->relation_model->get_fans_count( $user['id'] );?>)
							</a>
						</li>
					</ul>
					
					<div id="user_friends" class="hidden tab_div">
						<?php
							$user_friends = $ci->relation_model->get_friends( $user['id'] );
							//print_r( $user_friends );
							foreach( $user_friends as $friend ):
						?>
							<a href="<?=site_url('user/'.$friend['id']);?>">
								<img height="18" src="<?=get_user_avatar_url($friend['id']);?>" />
								<?=get_user_name( $friend['nickname'], $friend['realname'] );?>
							</a>
						<?php
							endforeach;
						?>
					</div>
					
					<div id="user_fans" class="hidden tab_div">
						<?php
							$user_fans = $ci->relation_model->get_fans( $user['id'] );
							foreach( $user_fans as $fan ):
						?>
						<a href="<?=site_url('user/'. $fan['id']);?>">
							
							<?=$fan['realname'];?>
						</a>
						<?php
							endforeach;
						?>
					</div>
					
				</div>
				
				<div class="sidebar_widget">
					<h2>所在友群</h2>
					<p>
						加入的友群在这里
					</p>
				</div>
				
				<div class="sidebar_widget">
					<h2>他的好友</h2>
					<p>
						好友列表
					</p>
				</div>
			</div>
		</div>
	</div>
	

<?php
	$this->load->view('footer_view');
?>