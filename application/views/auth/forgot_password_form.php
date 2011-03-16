<?php
	$this->load->view('header_view');
?>

<div id="content">
	<div class="content_top">
		<div class="content_bottom">
			
			<form action="<?=site_url( 'auth/forgot_password' );?>" method="post">			
				<p>
					<label for="login">Email</label>
					
					<input type="text" name="login" value="" id="login" maxlength="80" size="30" class="input_text" />
					
				</p>
				
				<p class="align_center">
					<button type="submit" class="kk_btn">
						获取新密码
					</button>
				</p>
				
			</form>

			
		</div>
	</div>
</div>



<?php
	$this->load->view('footer_view');
?>