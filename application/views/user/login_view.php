<?php
	// 正式登录页面
?>

<?php $this->load->view('header_view'); ?>


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
						你需要登录才可以看到内容
						
						<h2>果断注册</h2>
						
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
						
								<br />
								
							
								<a class="large blue awesome" id="user_register_submit" type="submit">
									<span><span>开始奇异果！</span></span>
								</a>
							</form>
	
						</div><!-- end form div-->
						
						
						<script>
							$(function(){
								$('#login_btn').trigger('click');
							});
						</script>
					</div>
				</div>
            </div>

<?php $this->load->view('footer_view'); ?>