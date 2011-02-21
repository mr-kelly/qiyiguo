<?php $this->load->view('header_view'); ?>
			
			
		<?=import_css('css/app/home/index.css');?>
		<?=import_js('js/app/home/index.js');?>
            
            <div id="content">
        		<div class="content_top">
        			<div class="content_bottom">

						<div id="home_pic">
							<div id="home_intro" class="hidden">
								奇异果介绍
							</div>
							
						</div>
						
						<div id="home_show">
						<?php
							$ci =& get_instance();
							$ci->load->library('Douban');
							//print_r( $ci->douban->get_request_token() );
							//$douban_url =  $ci->douban->get_authorize_url( 'http://' . $_SERVER["HTTP_HOST"] . site_url('user/login_by_douban') );
							//echo $ci->douban->get_access_token( 'f6f948f992d489d6e4ebdaecb87d9d82' );
						?>

						
							<h2>奇异果的奇异之处</h2>
							<p>
								看微博 连接 新发现 创造生活
							</p>
							
							
							<div class="home_block">
								<h2>活跃群组</h2>
								<ul>
									<li>某个</li>
								</ul>
							</div>
							
							
							<div class="home_block">
								<h2 class="tipsy_s" title="这些都是奇异果的用户哦~">他们在奇异果...</h2>
								<ul>
								
								</ul>
							</div>
							
							<div class="home_block">
								<h2 class="tipsy_w" title="消息盒子整合了用户、果群的各种信息">消息盒子</h2>
								<ul>
								
								</ul>
							</div>
							
							<div class="home_block">
								<h2>活动</h2>
								<ul>
								
								</ul>
							</div>
							

						</div>
						
						<div style="height:500px;"></div>
					</div>
        		</div>
            </div>
            
            
            

            <div id="sidebar">
            	<div class="sidebar_top">
            		<div class="sidebar_bottom">
						<?php
							// 首页登录窗
							if ( !is_logged_in() ) :
						?>
            			<div class="sidebar_widget">
            				
            				
							<script>
							var $user_login_action = '<?=base_url();?>user/login';
							var $user_home = '<?=base_url();?>';
							var $redirect = '<?=site_url( $this->input->get("redirect") );?>';
							</script>            				
							<?=import_js('js/app/user/login.js');?>
            				
							<h2>登录</h2>
							
							<div class="form_div">
								<form id="user_login_form" class="home_user_login_form" method="post" action="<?=site_url('user/login');?>">
									<p>
										<label>电邮</label>
										<input id="user_login_login" title="注册时所填的Email、电子邮箱" class="required email tipsy_se" type="text" name="login" minlength="3" />
										
									</p>
									<p>
										<label>密码</label>
										<input id="user_login_password" title="注册时所填的密码" class="tipsy_se required" type="password" name="password" />
									</p>
									
									<div class="user_login_remember_div center">
										<!-- 居中-->
										<input type="checkbox" name="remember" value="1" id="user_login_remember" style="margin:0;padding:0">
										<label id="user_login_remember_label" for="user_login_remember">下次自动登录</label>
									</div>
									
									<p class="center">
										<a id="user_login_submit" class="awesome blue tipsy_se" title="开始奇异果！">
											开始奇异果!
										</a>
									</p>
								</form>
							</div>
							
							<div class="login_more_tip">
								你也可以...
							</div>
							

							
							<div class="login_more">

								<div class="other_login_item">
									<a class="btn" href="#" onclick="$('#register_btn').trigger('click');return false;">
										<span><span>快速注册奇异果</span></span>
									</a>
								</div>

								<div class="other_login_item">
									<a href="<?=site_url('user/login_by_t_sina');?>" class="tipsy_sw" title="使用「新浪微博」的帐号登录">
										<img src="<?=static_url('img/button_t_sina_connect.png');?>" />
									</a>
								</div>
								
								
								<div class="other_login_item">
									<a href="<?=site_url('user/login_by_douban');?>" class="tipsy_sw" title="使用「豆瓣网」的帐号登录">
										<img src="<?=static_url('img/button_douban_connect.png');?>" />
									</a>
								</div>
								
							</div>
							
            			</div>
            			<?php
            				endif;  //首页登录窗
            			?>
            			
            			<div class="sidebar_widget">
            				
		            		<?php //$this->load->view('sidebar/sidebar_group_view'); ?>
	            		</div>
	            		
	            		<div class="sidebar_widget">
	            			<h2 class="tipsy_se" title="奇异果每天都在努力着!">每天爱你多一些!</h2>
	            			<div class="sidebar_widget_content">
	            				<ul>
	            					<li>成功开发了朋友关系功能</li>
	            				</ul>
	            			</div>
	            		</div>
	            		
            		</div> <!-- sidebar_bottom -->
            	</div>	<!-- sidebar top-->
            </div><!-- sidebar -->
            
<?php $this->load->view('footer_view'); ?>