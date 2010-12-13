<?php $this->load->view('header_view'); ?>



		<div class="float_right" style="width:400px;">
			<h2>更改你的头像</h2>
			<a href="<?=site_url('user/avatar');?>">上传头像</a>
	<?php
		// 头像更改设置
		if ( $user_avatars != null ):
	?>
			
			
			<?php
				
			
				foreach( $user_avatars as $avatar ):
				
				// 头像更改时同时提交 ajax form, 以确保用户修改资料后，未保存按修改头像资料丢失
			?>
				<a onclick="$('#user_profiles_form').submit();" href="<?=site_url('user/avatar_set' . '/' . $avatar['id'] );?>">
					<img width="50" src="<?=static_url();?>upload/avatars/<?=$this->tank_auth->get_user_id();?>/<?=$avatar['avatar_thumb'];?>" />
				</a>
			<?php
				endforeach;
			?>
			
			
	<?php
		endif;
	?>	
			
		</div>

	
	

	
	<div style="width:50%;">
	

		<script>$(function(){ $('#user_setting_tabs').tabs();});</script>
		
		<form id="user_profiles_form" method="post" action="<?=site_url('user/setting');?>">
		<div id="user_setting_tabs">
		
			<ul style="height:30px;">
				<li><a href="#base_setting_tab">资料设置</a></li>
				<li><a href="#privacy_setting_tab">隐私设置</a></li>
			</ul>
			
			<div id="base_setting_tab">
				<div class="form_div">
					
						<p>
							<label>真实姓名</label>
							<input name="realname" type="text" value="<?=get_current_user_profile('realname');?>" />
						</p>
						
						<p>
							<label>昵称</label>
							<input name="nickname" type="text" value="<?=get_current_user_profile('nickname');?>"  />
						</p>
						
						<p>
							<label>生日</label>
							<input class="datepicker" name="birth" type="text" value="<?=get_current_user_profile('birth');?>" />

							
						</p>
						
      					<p>
                			<label>所在省份</label>
                			<select class="dict_province" name="province_id">
							<?php
								$ci =& get_instance();
								$provinces =  $ci->dict_model->get_provinces();
								$user_province = get_current_user_profile('province_id'); // 用户当前设置的省份
								foreach ( $provinces as $prov ):
							?>
								<option value="<?=$prov['id'];?>"<?=( $user_province == $prov['id'] ) ? ' selected="selected"' : '' ; ?>><?=$prov['province_name'];?></option>
							
							<?php endforeach; ?>
                			</select>
                		</p>
                		
                		<p>
                			<label>常驻城市</label>
                			<select class="dict_city" name="city_id">
							<?php
								$ci =& get_instance();
								$cities =  $ci->dict_model->get_cities($user_province);
								$user_city = get_current_user_profile('city_id');
								foreach ( $cities as $city ):
							?>
								<option value="<?=$city['id'];?>"<?=( $user_city == $city['id'] ) ? ' selected="selected"' : '' ; ?>><?=$city['city_name'];?></option>
							
							<?php endforeach; ?>
                			</select>
                		</p>
                		
                		
						
						<p>
							<label>个人网站</label>
							<input name="website" type="text" value="<?=get_current_user_profile('website');?>"  />
						</p>
						
						<p>
							<label>常用电子邮箱</label>
							<input name="email_1" type="text" value="<?=get_current_user_profile('email_1');?>"  />
						</p>
						
						<p>
							<label>第二电子邮箱</label>
							<input name="email_2" type="text" value="<?=get_current_user_profile('email_2');?>"  />
						</p>
						
						<p>
							<label>第三电子邮箱</label>
							<input name="email_3" type="text" value="<?=get_current_user_profile('email_3');?>"  />
						</p>
						
						<p>
							<label>人人网ID号</label>
							<input name="link_renren" type="text" value="<?=get_current_user_profile('link_renren');?>"  />
							<a href="<?=base_url();?>wiki/获得人人网的id号">
								如何知道自己的人人网的ID号？
							</a>
						</p>
						
						<p>
							<label>个人描述</label>
							<textarea name="description"><?=get_current_user_profile('description');?></textarea>
						</p>
						
						
					<?php
						// 如果用户是使用新浪微博帐号登录，那么不允许设置绑定新浪微博
						$ci =& get_instance();
						if ( $ci->user_t_sina_model->is_bind_user_t_sina( $this->tank_auth->get_user_id(),'by_id' ) != 't_sina' ):
					?>
						<p>
							<label>新浪微博帐号</label>
							<input type="text" name="t_sina_login" value="<?= @ $user_t_sina['t_sina_login'];?>" />
						</p>
						
						<p>
							<label>新浪微博密码</label>
							<input class="input_text" type="password" name="t_sina_password" value="<?= @ $user_t_sina['t_sina_password'];?>" />
						</p>
						<input type="submit" />
						
					<?php
						endif;
					?>
					
				</div>
				
				<div class="session_message hidden"></div>
			</div>

			
			<div id="privacy_setting_tab">
				隐私设置页
			</div>
			
		</div>
		
		
		<div class="center">
			<a class="awesome medium blue" id="submit_user_profiles_form" href="#">
				确认
			</a>
		</div>
		</form>


	</div>
	
	

	
				<script>
					$(function(){
						$('#submit_user_profiles_form').click(function(){
							$("#user_profiles_form").submit();
							return false;
						});
						
						$('#user_profiles_form').ajaxForm({
							dataType: 'json',
							success: function(data) {
								if ( data.status == 1 ) {
								
									session_message(data.info, 'normal');
									
								} else {
									session_message(data.info, 'error');
								}
							}
						});
					});
				</script>

<?php $this->load->view('footer_view'); ?>