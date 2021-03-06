<?php
	// 正式登录页面
?>

<?php $this->load->view('header_view'); ?>

<?=import_css('css/app/user/login.css');?>

            <div id="sidebar">
				<div class="sidebar_top">
					<div class="sidebar_bottom">
					
						<div class="sidebar_widget center">
							<?php
								// Google 广告
							?>
							
							<script type="text/javascript"><!--
							google_ad_client = "pub-9928587148743461";
							/* on kiwiguo.net */
							google_ad_slot = "3982629330";
							google_ad_width = 200;
							google_ad_height = 200;
							//-->
							</script>
							<script type="text/javascript"
							src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
							</script>
						</div>
					</div>
				</div>
            </div>
            
            
            <div id="content">
            	<div class="content_top">
            		<div class="content_bottom">
						
						<div>
							<img src="<?=static_url('img/login_required.png');?>" />
						</div>
						
						<div id="login_left">
							<h2>果断注册!</h2>
							
							<script type="text/javascript">
								$redirect = '<?=site_url( $this->input->get("redirect") );?>';
							</script>
							
							<?=import_js('js/app/user/register.js');?>
							
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
										<label for="password">密码</label>
										<input title="请设置您的密码" class="required input_text tipsy_sw" id="user_register_password" name="password" type="password" minlength="4" />
									</p>
									
									<p>
										<label>性别</label>
										<span>
											<input type="radio" class="" name="gender" value="male" />男
											<input type="radio" class="" name="gender" value="female" />女
										</span>
									</p>
									
									<p>
										<label>所在省份</label>
										<select id="user_register_province_id" name="province_id" class="required">
										<?php
											$ci =& get_instance();
											$provinces =  $ci->dict_model->get_provinces();
											foreach ( $provinces as $prov ):
										?>
											<option value="<?=$prov['id'];?>"><?=$prov['province_name'];?></option>
										
										<?php endforeach; ?>
										</select>
									</p>
									
									<p>
										<label>常驻城市</label>
										<select id="user_register_city_id" name="city_id" class="required">
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
										<a class="kk_btn" id="user_register_submit" type="submit">
											<span><span>开始奇异果！</span></span>
										</a>
									</div>
								</form>
		
							</div><!-- end form div-->
						</div><!-- END login_left -->
						
						<div id="login_right">

							<h2>或者...</h2>
							<div>
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
							
							
							<h2>注册过了?</h2>
							<div class="other_login_item">
								<a href="#" class="kk_btn" onclick="$('#login_btn').trigger('click');return false;">登录</a>
							</div>
							
							<script>
								$(function(){
									//$('#login_btn').trigger('click');
								});
							</script>
							
						</div>
					</div>
				</div>
            </div>

<?php $this->load->view('footer_view'); ?>