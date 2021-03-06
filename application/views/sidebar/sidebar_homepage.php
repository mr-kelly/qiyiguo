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
								<form id="user_login_form" class="home_user_login_form" method="post" action="<?=site_url('user/login?ajax=' . rand() );?>">
									<p>
										<label>电邮</label>
										<input id="user_login_login" title="注册时所填的电子邮箱/或果号ID" class="required tipsy_se input_text" type="text" name="login" minlength="3" />
										
									</p>
									<p>
										<label>密码</label>
										<input id="user_login_password" title="注册时所填的密码" class="tipsy_se required input_text" type="password" name="password" />
									</p>
									
									<div class="user_login_remember_div align_center">
										<!-- 居中-->
										<input type="checkbox" name="remember" value="1" id="user_login_remember" style="margin:0;padding:0">
										<label id="user_login_remember_label" for="user_login_remember">下次自动登录</label>
									</div>
									
									<p class="align_center">
										<a href="#" id="user_login_submit" class="kk_btn tipsy_se" title="开始奇异果！">
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
									<?php 
										// Redirect-> 如果设置GET redirect,那么就display redirect~  没有，将redirect设为当前页面 
										// 这样，可以令跳转的登录窗口生效
										//IE 6到指定的登录页
										if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false ):
									?>
									<a id="" class="btn icon icon_login" href="<?=site_url('user/iframe_login' );?>?redirect=<?= isset($_GET['redirect']) ? $this->input->get('redirect') : uri_string();?>"> 
									<?php
										else:
									?>
									<a class="btn" href="#" onclick="$('#register_btn').trigger('click');return false;">
									<?php endif; ?>
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
            				<h2>快速查找</h2>
            				<div class="form_div">
            					<form id="rapid_enter_form" method="get" action="<?=site_url('search');?>">
            						<p class="align_center">
            							输入群号/朋友的G号
            						</p>
            						
            						<p class="align_center">
            							<input id="rapid_enter_input" class="tipsy_s" title="输入群号、朋友果号～" type="text" name="q" />
            						</p>
            						
            						<p class="align_center">
            							<a onclick="$('#rapid_enter_form').submit();return false;" href="#" class="kk_btn">
            								找群/找人
            							</a>
            						</p>
            					</form>
            					<script>
            						$(function(){
            							$rapid_enter_tips = '10000';
            							
            							$('#rapid_enter_input').input_tips( $rapid_enter_tips );
            							
            							$('#rapid_enter_form').submit(function(){
            								if ( $('#rapid_enter_input').val() == '' ) {
            									return false;
            								}
            							});
            						});
            					</script>
            					
            				</div>
		            		<?php //$this->load->view('sidebar/sidebar_group_view'); ?>
	            		</div>
	            		
	            		<div class="sidebar_widget">
							<h2>奇异果演示视频</h2>
							<div>
								<!--<embed src='http://player.youku.com/player.php/sid/XMjU1MDk2NjM2/v.swf' quality='high' width='230' height='190' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash'></embed>
								-->
								<embed src="http://player.youku.com/player.php/sid/XMjU3MjU2NzEy/v.swf" quality="high" width="230" height="190" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>
							</div>
						</div>
						
						
	            		<?php if ( !empty( $random_users ) ) : ?>
	            		<div class="sidebar_widget">
							<h2 class="tipsy_s" title="这些都是奇异果的用户哦~">这些人在奇异果</h2>
							
							<ul class="home_users_list">
							<?php foreach( $random_users as $random_user ) :?>
								<li>
									<a class="tipsy_s" href="<?=site_url('user/' . $random_user['id']);?>" title="<?=$random_user['name'];?> <?= !empty( $random_user['Mood'] ) ? ': ' . $random_user['Mood']['text'] : '';?>">
										<img class="avatar" width="30" height="30" src="<?=get_user_avatar_url( $random_user['id'] );?>" />
									</a>
								</li>
							<?php endforeach; ?>
							</ul>
							
							<div class="clearboth"></div>
							
						</div>
						<?php endif; ?>
						
						<?php
							$this->load->view('sidebar/sidebar_client');
						?>
						
						
	            		<div class="sidebar_widget">
	            			<h2 class="tipsy_se" title="我们为了未来而努力着!">每天爱你多一些!</h2>
	            			<div class="sidebar_widget_content">
	            				
	            				<p>
	            					奇异果希望带给每个用户最好的服务。期待获得你的批评。
	            				</p>
	            				
	            				
	            				<div class="align_right">
	            					<a href="<?=site_url('g/qiyiguo');?>">
	            						&gt;去「奇异果之家」提意见
	            					</a>
	            				</div>
	            				
	            			</div>
	            		</div>
	            		
