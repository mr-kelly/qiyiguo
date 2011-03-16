<?php
	$this->load->view('header_view');
?>
	<?=import_js('js/app/user/change_password.js');?>
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
			
				<h1>修改密码</h1>
				<div class="form_div">
					<form id="change_password_form" method="post" action="<?=site_url('user/change_password');?>">
						<p>
							<label>旧密码</label>
							<input class="required" type="password" name="old_password" />
						</p>
						<p>
							<label>新密码</label>
							<input class="required" type="password" name="new_password" />
						</p>
						<p>
							<label>确认新密码</label>
							<input class="required" type="password" name="confirm_new_password" />
						</p>
						
						<p class="align_center">
							<button type="submit" class="kk_btn">
								确认
							</button>
						</p>
					</form>
				</div>
				
				
				
			</div>
		</div>
	</div>
	
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php
					$this->load->view('sidebar/sidebar_user_profile', array(
						'user' => get_current_user_profile(),
					));
				?>
			</div>
		</div>
	</div>


<?php
	$this->load->view('footer_view');
?>