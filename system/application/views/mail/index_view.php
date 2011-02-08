<?php
	$this->load->view('header_view');
	
?>
	<div class="form_div">
		<form method="post" action="<?=site_url('mail');?>">
			<p>
				<label>发送给:</label>
				
				<?php foreach ( $send_to as $user ): ?>
				<span class="mail_user">
					<a href="<?=site_url('user/' . $user['id']);?>">
						<?=$user['name'] . '&lt;' . $user['email_1'] . '&gt;';?>
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
			
			<p>
				<input type="submit" />
			</p>
		</form>
	</div>
	
<? //var_dump($send_to);?>





<?php
	$this->load->view('footer_view');
?>