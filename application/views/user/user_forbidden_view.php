<?php
	$this->load->view('header_view');
?>

	<script type="text/javascript">
		$ajax_get_user_relation_btn_url = '<?=site_url("relation/ajax_get_user_relation_btn/" . $user["id"] );?>';
	</script>
	
	<?=import_css('css/app/user/user_lookup.css');?>
	<?=import_js('js/app/user/user_lookup.js');?>
	
<div id="content">
	<div class="content_top">
		<div class="content_bottom align_center">
			
			<h1 style="font-size:30px;color:#AAA;text-align:center;">
				&gt;_&lt; 他不让你看...
			</h1>
			
			<div>
				<div>
					<img class="avatar" width="100" src="<?=get_user_avatar_url( $user['id'] );?>" />
				</div>
				
				<div>
					<h2 class="group_intro">
						<?=$user['name'];?> 
					</h2>
					
					<div>
						<?=kk_get_province_name( $user['province_id'] );?>
						<?=kk_get_city_name( $user['city_id'] );?>
					</div>
					
					<div class="group_intro grey">
						<div>
							<?=$user['description'];?>
						</div>
						
						<div>
							<?php
								// 获取朋友、粉丝数量
								$ci =& get_instance();
								$ci->load->model('relation_model');
								$friends_count = $ci->relation_model->get_friends_count( $user['id'] );
								$fans_count = $ci->relation_model->get_fans_count( $user['id'] );
							?>
							<?= $friends_count;?>个朋友 
							<?= $fans_count; ?>个粉丝
						</div>
						
						
					</div>
				</div>
				
				<div style="margin: 20px 0;">
					<span class="icon icon_delete">
					<?php
						if ( $user['user_privacy'] == 2 ):
					?>
						他收藏的人才能查看
					<?php
						elseif ( $user['user_privacy'] == 1 ):
					?>
						你们是朋友(互相收藏)才能查看
					<?php
						elseif( $user['user_privacy'] == 0 ):
					?>
						对方设置了个人页面不允许查看
					<?php
						endif;
					?>
					</span>
					
					<?php if ( !is_logged_in() ) : ?>
					<div class="red" style="margin-top:20px;">
						必须登录后才可以查看... 
						<a href="#" onclick="$('#login_btn').trigger('click');return false;">&gt;登录</a>
					</div>
					<?php endif; ?>
					
				</div>
				
				<div>
					<?php
						$this->load->view('general/general_user_relation_btn_view', 
											array( 'to_user_id'=>$user['id'] )
										);
					?>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="sidebar">
	<div class="sidebar_top">
		<div class="sidebar_bottom">
			<?php
				$this->load->view('sidebar/sidebar_user_view', array(
					'user' => $user,
				));
				
				$this->load->view('sidebar/sidebar_ad_pic');
			?>
		</div>
	</div>
</div>


<?php
	$this->load->view('footer_view');
?>