<?php
	// 用于每页面的register_box
?>

			<h2>注册</h2>
				<div class="session_message hidden"></div>
                <div class="form_div center">
                	
						<p>
							<label for="login">Email</label>
							<input class="input_text" id="user_register_email" name="email" type="text" />
						</p>
						
						<p>
							<label for="login">姓名</label>
							<input class="input_text" id="user_register_username" name="username" type="text" />
						</p>
	
						<p>
							<label for="password">密码</label>
							<input class="input_text" id="user_register_password" name="password" type="password" />
						</p>
                
                		<p>
                			<label>所在省份</label>
                			<select id="user_register_province_id" name="province_id">
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
                			<select id="user_register_city_id" name="city_id">
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
						
					<form method="post">
						<a class="large blue awesome" id="user_register_submit" type="submit">
							<span><span>完成注册</span></span>
						</a>
					</form>
                </div>
                
                
            
            
                <script>
                var $user_register_action = '<?=base_url();?>user/register';
                var $user_home = '<?=base_url();?>';
                var $get_cities_url = '<?=site_url("user/ajax_get_cities/");?>';
                </script>
                <!--<js href="<?=static_url();?>js/app/user/register.js" /> -->
				<?=import_js('js/app/user/register.js');?>
