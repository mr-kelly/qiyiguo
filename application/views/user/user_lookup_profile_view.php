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
						
						<ul>
						
							<?php if ( $user['realname'] ): ?>
							<li>
								<span class="profile_label">真实姓名: </span>
								
								<?=$user['realname'];?>
								
							</li>
							<?php endif; ?>
							
						
							<?php if ( $user['nickname'] ): ?>
							<li>
								<span class="profile_label">昵称: </span>
								<?=$user['nickname'];?>
							</li>
							<?php endif; ?>
							
							
							
							<?php if ( $user['gender'] ): ?>
							<li>
								<span class="profile_label">性别: </span>
								<?=$user['gender'] == 'male' ? '男' : '女';?>
							</li>
							<?php endif; ?>
							
							<?php if ( $user['birth'] ): ?>
							
							<li>
								<span class="profile_label">年龄: </span>
								
								<?=$user['age']; ?>
							</li>
							
							<li>
								<span class="profile_label">生日: </span>
								<?=$user['birth'];?>
							</li>
							
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
				<?php $this->load->view('sidebar/sidebar_user_view');?>
			</div>
		</div>
	</div>
<?php
	$this->load->view('footer_view');
?>