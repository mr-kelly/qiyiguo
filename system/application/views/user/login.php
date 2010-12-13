<?php
	// 用于每页面的login_box
?>

		<div id="login_tabs">
		
			<ul>
				<li>
					<a href="#general_login_tab">
						<img src="<?=static_url();?>img/favicon.gif" width="16" />
						正常登录
					</a>
				</li>
				<li>
					<a href="#t_sina_login_tab">
						<img src="http://t.sina.com.cn/favicon.ico" />
						用新浪微博帐号登录
					</a>
				</li>
			</ul>
		
				
					   
			<div id="general_login_tab" class="form_div center">
				<form id="user_login_form" method="post" action="<?=base_url();?>user/login">
					<h2>登录</h2>
					
					<div class="session_message hidden"></div>
					
						<p>
							<label for="user_login_login">Email</label>
							<input class="input_text" id="user_login_login" name="login" type="text" />
						</p>
						
						<p>
							<label for="user_login_password">密    码</label>
							<input class="input_text"  id="user_login_password" name="password" type="password" />
						</p>
	
	
						<p>
							<input type="checkbox" name="remember" value="1" id="user_login_remember" style="margin:0;padding:0" />
							<label for="user_login_remember">下次自动登录</label>
						</p>
	
						
						<br />
						
						<a class="awesome large blue" href="#" id="user_login_submit">
							<span><span>登录</span></span>
						</a>
					
					<br />
					
					<a href="#" onclick="$('#register_box').fadeIn();$('#login_box').fadeOut();">
						还没有注册!
					</a>
				</form>
			</div>
			
			
			<div id="t_sina_login_tab" class="form_div center">
			<form id="t_sina_login_form" action="<?=site_url('user/login_with_t_sina');?>" method="post">
				<p>
					<label>帐号</label>
					<input id="user_t_sina_login" name="login" type="text" />
				</p>
				<p>
					<label>密码</label>
					<input class="input_text" id="user_t_sina_password" name="password" type="password" />
				</p>
				
				<p>
					<input type="checkbox" name="remember" value="1" id="user_login_remember" style="margin:0;padding:0">
					<label for="remember">下次自动登录</label>
				</p>
				
				<p>
					<input type="submit" />
					
				</p>
				
				<div class="session_message"></div>
				
			</form>
			</div>
			
			<script>
				$(function(){
					$('#t_sina_login_form').ajaxForm({
						dataType: 'json',
						success: function(data){
						
							
							if ( data.status == 1) {
								session_message( data.info, 'normal');
								window.location = $redirect;
							} else {
								session_message( data.info, 'error');
							}
						}
					});
				});
			</script>
			
		</div>
		
		
				<script>
				var $user_login_action = '<?=base_url();?>user/login';
				var $user_home = '<?=base_url();?>';
				var $redirect = '<?=site_url( $this->input->get("redirect") );?>';
				</script>
				<!--<js href="<?=static_url();?>js/app/user/login.js" />-->
				<?=import_js('js/app/user/login.js');?>