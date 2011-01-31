<?php
	$this->load->view('header_view');
	
?>
	
<?=import_css('css/app/user/user_lookup.css');?>



	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				
				<?php
					$this->load->view('general/general_user_relation_view', array('to_user_id'=>$user['id']));
				?>
            	
            	
				<div id="user_profile">
					<div id="user_action">
						<div id="user_profile_avatar">
							<a class="lightbox" href="<?=get_user_avatar_url( $user['id'], 'big' );?>">
								<img class="avatar" width="150" src="<?=get_user_avatar_url( $user['id'] );?>" />
							</a>
						</div>
						
						
						
						<div id="user_links">
							<?php if ( isset( $user['renren_url'] ) ): ?>
							<a target="_blank" href="<?=$user['renren_url'];?>">
								<img width="16" src="<?=static_url() . 'img/websites/renren.gif' ;?>" />
								到他人人
							</a>
							<?php endif; ?>
							<?php if ( $user['website'] ): ?>
							<a target="_blank" href="<?=$user['website'];?>">
								<img width="16" src="<?=static_url() . 'img/websites/blog.gif' ;?>" />
								到他博客
							</a>
							<?php endif; ?>
							<?php if ( $user['t_sina_url'] ): ?>
							<a target="_blank" href="<?=$user['t_sina_url'];?>">
								<img width="16" src="<?=static_url() . 'img/websites/t_sina.gif' ;?>" />
								到他微博
							</a>
							<?php endif; ?>
						</div>
					</div>
					
					
					<div id="user_profile_detail">
						<h2><?=$user['name'];?></h2>
						
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
					
					
					<br class="clearboth" />
				</div>



				<div>
					<h2>聊天</h2>
					<ul class="chats_container">
						
					</ul>
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
				<div class="kk_tabs user_relation_tabs">
					<ul>
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
								拥趸(<?=$ci->relation_model->get_user_fans_count( $user['id'] );?>)
							</a>
						</li>
					</ul>
					
					<div id="user_friends" class="hidden">
						<?php
							$user_friends = $ci->relation_model->get_friends( $user['id'] );
							//print_r( $user_friends );
							foreach( $user_friends as $friend ):
						?>
							<a href="<?=site_url('user/'.$friend['id']);?>">
								<?=$friend['realname'];?>
							</a>
						<?php
							endforeach;
						?>
					</div>
					
					<div id="user_fans" class="hidden">
						粉丝们...  更多
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