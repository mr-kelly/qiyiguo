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