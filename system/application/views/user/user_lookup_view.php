<?php
	$this->load->view('header_view');
	
?>
	
<?=import_css('css/app/user/user_lookup.css');?>



	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				

            	
            	<div id="lookup_head">
					<div class="lookup_avatar">
						<a class="sexybox" href="<?=get_user_avatar_url( $user['id'], 'big' );?>">
							<img class="avatar" width="100" src="<?=get_user_avatar_url( $user['id'] );?>" />
						</a>
						
					</div>
					
					<div class="lookup_easy_profile">
						<h2>
							<span class="icon icon_user tipsy_s" title="这是一个人"></span>
							<?=get_user_name( $user['nickname'], $user['realname'] );?>
							<span class="small grey">
								&nbsp;&nbsp;果号:<?=$user['id'];?>
							</span>
						</h2>
						
						<div>
									<?php
										$ci =& get_instance();
										$ci->load->model('dict_model');
									?>
									所在地:  <?=$ci->dict_model->get_province_name( $user['province_id' ] );?> <?=$ci->dict_model->get_city_name( $user['city_id' ] );?>
									,
									籍贯: <?=$ci->dict_model->get_province_name( $user['hometown_province_id' ] );?> <?=$ci->dict_model->get_city_name( $user['hometown_city_id' ] );?>
						</div>
					</div>
					
				<?php
					// 朋友关注
					$this->load->view('general/general_user_relation_view', array('to_user_id'=>$user['id']));
				?>
					
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
											到他新浪微博
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
							
							<div class="lookup_aside_widget">
								<h2>特别关系</h2>
							</div>
							
						</div>
						
						<div id="lookup_content">
							<?php
								$ci =& get_instance();
								$ci->load->library('t_sina');
								$weibo = $ci->t_sina->getUserWeibo( get_current_user_id() );
								//print_r( $weibo->verify_credentials() );
							?>
							
							<div id="user_profile_detail">
								<h2><?=get_user_name($user['nickname'], $user['realname']);?><? //$user['name'];?></h2>
								
								<ul>
								
									<?php if ( $user['realname'] ): ?>
									<li>真实姓名: <?=$user['realname'];?></li>
									<?php endif; ?>
									
									<?php if ( $user['gender'] ): ?>
									<li>性别: <?=$user['gender'];?></li>
									<?php endif; ?>
									
									<?php if ( $user['birth'] ): ?>
									
									<li>
										<?php
											$ci =& get_instance();
											$ci->load->library('humanize');
											
										?>
										年龄: <?=$ci->humanize->age( $user['birth'] ) ; ?>
									</li>
									
									<li>生日: <?=$user['birth'];?></li>
									
									<li>
										<?php
											$ci =& get_instance();
											$ci->load->library('humanize');
										?>
										星座: <?=$ci->humanize->constellation( $user['birth'] );?>
									</li>
									<?php endif; ?>
									
									<?php if ( $user['qq'] ): ?>
									<li>QQ: <?=$user['qq'];?></li>
									<?php endif; ?>
									
									
									
									<li>
										<?php
											$ci =& get_instance();
											$ci->load->model('dict_model');
										?>
										所在地:  <?=$ci->dict_model->get_province_name( $user['province_id' ] );?> <?=$ci->dict_model->get_city_name( $user['city_id' ] );?>
									</li>
									
									
									
									<li>个人描述: <?=$user['description'];?></li>
					
									
								</ul>
								
							</div>				
						
						</div>
						
						<div class="clearboth"></div>
						
						
					</div>
					
						<div class="clearboth"></div>
						
					</div>
						
						
						
            		
            		<div class="clearboth"></div>
            		
						<div>
							<h2>聊天</h2>
							<ul class="chats_container">
								
							</ul>
						</div>


				</div>
	

			
					<script>
						$(function(){
							$('.chats_container').load('<?=site_url("chat/ajax_get_chats/user/" . $user["id"] );?>');
						});
					</script>
				
				
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