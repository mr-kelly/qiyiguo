<?php
	$this->load->view('general/general_header_view');
?>
		<script>
		var $user_login_action = '<?=site_url("user/login");?>';
		var $user_home = '<?=base_url();?>';
		var $redirect = '<?=site_url( $this->input->get("redirect") );?>';
		</script>
		<!--<js href="<?=static_url();?>js/app/user/login.js" />-->
		<?=import_js('js/app/user/login.js');?>
		<?=import_css('css/app/user/login.css');?>
		
		<div class="kk_tabs">
		
			<ul class="tab_menu">
				<li>
					<a href="#login_tab">
						<span>登录</span>
					</a>
				</li>
				<li>
					<a target="_blank" href="<?=site_url('auth/forgot_password');?>">
						<span>忘记密码?</span>
					</a>
				</li>
				<li>
					<a href="#login_forget_email_tab">
						<span>忘记电邮?</span>
					</a>
				</li>
			</ul>
			
			<div id="login_tab" class="hidden tab_div">
				
				<div id="other_login" class="form_div">
					<h2>直接登录</h2>
					
					<div class="other_login_item">
						<a target="_parent" href="<?=site_url('user/login_by_t_sina?redirect=' . $this->input->get("redirect") );?>" class="tipsy_sw" title="使用「新浪微博」的帐号登录">
							<img src="<?=static_url('img/button_t_sina_connect.png');?>" />
						</a>
					</div>
					
					
					<div class="other_login_item">
						<a target="_parent" href="<?=site_url('user/login_by_douban?redirect=' . $this->input->get("redirect") );?>" class="tipsy_sw" title="使用「豆瓣网」帐号登录">
							<img src="<?=static_url('img/button_douban_connect.png');?>" />
						</a>
					</div>
				</div>
				
				
				<div id="general_login" class="form_div">
					
					<h2>正常登录</h2>
					
					<form id="user_login_form" method="post" action="<?=site_url('user/login');?>">
	
						
						<div class="session_message hidden"></div>
						
							<p>
								<label for="user_login_login">电 邮</label>
								<input title="输入注册时所使用的Email电子邮箱/或你的果号" class="input_text tipsy_se required" id="user_login_login" name="login" type="text" />
							</p>
							
							<p>
								<label for="user_login_password">密 码</label>
								<input title="输入注册时所使用的密码" class="input_text tipsy_se required"  id="user_login_password" name="password" type="password" />
							</p>
		
		
							<div class="user_login_remember_div align_center"><!-- 居中-->
								<input type="checkbox" name="remember" value="1" id="user_login_remember" style="margin:0;padding:0" />
								<label for="user_login_remember">下次自动登录</label>
							</div>
		
							

							<div class="user_login_submit_div">
								<a class="kk_btn" href="#" id="user_login_submit">
									开始奇异果!
								</a>
								
								<br />
								
								<?php
								/*
								<a href="#" onclick="$('#register_box').fadeIn();$('#login_box').fadeOut();">
									还没有注册!
								</a>
								*/
								?>
								<a href="<?=site_url('user/iframe_register');?>?redirect=<?=$this->input->get("redirect");?>">还没有注册?</a>
								
							</div>
						

					</form>
				</div>
				

				
				<div class="clearboth"></div>
				
			</div><!-- END login_tab -->
			
			
			
			<div id="login_forget_password_tab" class="hidden tab_div">
				<h2>忘记了注册密码?</h2>
				<p>
					怎么做
				</p>
			</div>
			
			<div id="login_forget_email_tab" class="hidden tab_div">
				<h2>忘记了注册邮箱?</h2>
				<div>
					<p>阿、忘记了邮箱？</p>
					<p>你可以通过以下方法登录奇异果哦:</p>
					<ul>
						<li>你可以通过你的「果号」(如: 10000) 登录</li>
						<li>如果帐号绑定了新浪微博，那么「用微博帐号登录」</li>
						<li>如果帐号绑定了豆瓣，那么「用豆瓣登录」</li>
						
					</ul>
					
					
					<p>...全都忘了？</p>
					<p>
						发邮件给我，我帮你！<a href="mailto:chepy.v@gmail.com">chepy.v@gmail.com</a>
					</p>
				</div>
			</div>
			
		</div>




<?php

	/*
		<div class="clearboth"></div>
		
		
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
						<img src="http://t.sina.com.cn/favicon.ico" width="16" />
						用新浪微博帐号登录
					</a>
				</li>
			</ul>
		
				
					   
			<div id="general_login_tab" class="form_div center">
				<form id="user_login_form" method="post" action="<?=base_url();?>user/login">
					<h2>登录</h2>
					
					<div class="session_message hidden"></div>
					
						<p>
							<label for="user_login_login">电邮</label>
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
*/
?>	
		

				

				
<?php
	$this->load->view('general/general_footer_view');
?>