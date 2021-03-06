<?php
	$this->load->view('general/general_header_view');
	
	// 用于每页面的register_box
?>
			<script>
			var $user_register_action = '<?=base_url();?>user/register';
			var $user_home = '<?=base_url();?>';
			var $get_cities_url = '<?=site_url("user/ajax_get_cities/");?>';
			var $redirect = '<?=site_url( $this->input->get("redirect") );?>';
			</script>
			<!--<js href="<?=static_url();?>js/app/user/register.js" /> -->
			<?=import_js('js/app/user/register.js');?>
			<?=import_css('css/app/user/register.css');?>
			

			<div class="kk_tabs">
				<ul class="tab_menu">
					<li>
						<a href="#register_tab">
							<span>快速注册</span>
						</a>
					</li>
				</ul>
				
				
				<div id="register_tab" class="hidden tab_div">
				
					<div id="register_general">
						<h2>注册</h2>
						<div class="session_message hidden"></div>
						
						<div class="form_div">
							<form id="user_register_form" method="post" action="<?=site_url('user/register');?>">
								<p>
									<label for="login">电邮</label>
									<input title="输入你的电子邮箱/Email" class="input_text tipsy_sw email required" id="user_register_email" name="email" type="text" />
								</p>
								
								<p>
									<label for="login">真实姓名</label>
									<input title="您的真实姓名、中文名字，如“李雷”、“张三丰”" class="required input_text tipsy_sw" id="user_register_username" name="realname" type="text" minlength="2" />
								</p>
								<p>
									<label>昵称</label>
									<input title="您的称呼/称谓" class="required input_text tipsy_sw" id="user_register_nickname" name="nickname" type="text" minlength="1" />
								</p>
								
								<p>
									<label>性别</label>
									<span>
										<input type="radio" class="" name="gender" value="male" />男
										<input type="radio" class="" name="gender" value="female" />女
									</span>
								</p>
			
								<p>
									<label for="password">密码</label>
									<input title="请设置您的密码" class="required input_text tipsy_sw" id="user_register_password" name="password" type="password" minlength="4" />
								</p>
						
								<p>
									<label>所在地</label>
									<select id="user_register_province_id" name="province_id" class="location_select">
									<?php
										$ci =& get_instance();
										$provinces =  $ci->dict_model->get_provinces();
										foreach ( $provinces as $prov ):
									?>
										<option value="<?=$prov['id'];?>"><?=$prov['province_name'];?></option>
									
									<?php endforeach; ?>
									</select>
									<select id="user_register_city_id" name="city_id" class="location_select required">
									<?php
										$ci =& get_instance();
										$cities =  $ci->dict_model->get_cities();
										foreach ( $cities as $city ):
									?>
										<option value="<?=$city['id'];?>"><?=$city['city_name'];?></option>
									
									<?php endforeach; ?>
									</select>
								</p>

								<input class="form_key" name="form_key" type="hidden" value="<?=$form_key_token['form_key'];?>" />
								<input class="form_key_token" name="form_key_token" type="hidden" />
								
								<br />
								
								<div class="align_center">
									<a class="kk_btn" id="user_register_submit" type="submit" href="#">
										<span><span>开始奇异果！</span></span>
									</a>
								</div>
								
							</form>
	
						</div><!-- end form div-->
					

                	</div>
					
					<div id="register_more">
						
						<h3>已注册?</h3>
						
						<div class="other_login_item">
							<a title="转到登录页面，进行正常登录" class="btn tipsy_se" href="<?=site_url('user/iframe_login');?>?redirect=<?=$this->input->get('redirect');?>">
								<span><span>去登录</span></span>
							</a>
						</div>
						
						<div class="other_login_item">
							<a target="_parent" href="<?=site_url('user/login_by_t_sina?redirect=' . $this->input->get("redirect") );?>" class="tipsy_se" title="使用「新浪微博」的帐号登录">
								<img src="<?=static_url('img/button_t_sina_connect.png');?>" />
							</a>
						</div>
						
						
						<div class="other_login_item">
							<a target="_parent" href="<?=site_url('user/login_by_t_douban?redirect=' . $this->input->get("redirect") );?>" class="tipsy_se" title="使用「豆瓣网」帐号登录">
								<img src="<?=static_url('img/button_douban_connect.png');?>" />
							</a>
						</div>
						

					</div>
					
					
					<div class="clearboth"></div>
					
				</div>
				
				
				
				
				
			</div>
			
		
			
		
		




<?php
	$this->load->view('general/general_footer_view');
?>