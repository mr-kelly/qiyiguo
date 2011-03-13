<?php
	$this->load->view('header_view');
	
?>

<div id="content">
	<div class="content_top">
		<div class="content_bottom">
			<h1>果邮</h1>
			<div>
				无需知道对方的电邮地址，就可以向对方发送电子邮件。
			</div>
			
			<div class="form_div">
				<form method="post" action="<?=site_url('mail');?>">
					<p>
						<label>发送给:</label>
						
						<?php foreach ( $send_to as $user ): ?>
						<span class="mail_user">
							<a href="<?=site_url('user/' . $user['id']);?>">
								<?=$user['name'] ;?><!--<?= $user['email'];?> '&lt;'  . '&gt;'-->
							</a>
						</span>	
						<?php endforeach; ?>
						
						<input type="hidden" name="mail_send_to" value="<?=$this->input->get('send_to');?>" />
					</p>
					
					<p>
						<label>主题:</label>
						<input type="text" name="mail_topic" />
					</p>
					
					<p>
						<label>内容:</label>
						<textarea name="mail_content"></textarea>
					</p>
					
					<div class="align_center">
						<button type="submit" class="kk_btn">
							发送
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<? //var_dump($send_to);?>





<?php
	$this->load->view('footer_view');
?>