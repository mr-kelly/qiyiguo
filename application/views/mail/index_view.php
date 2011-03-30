<?php
	$this->load->view('header_view');
	
?>

<div id="content">
	<div class="content_top">
		<div class="content_bottom">
			<h1>果邮</h1>
			<div class="grey">
				无需知道对方的电邮地址，就可以向对方发送电子邮件。
			</div>
			
			<div class="form_div">
				<form method="post" action="<?=site_url('mail?send_to=' . $_GET['send_to'] );?>" enctype="multipart/form-data">
					<p>
						<label>发送给:</label>
						
						<?php foreach ( $send_to as $user ): ?>
						<span class="mail_user">
							<img src="<?=get_user_avatar_url( $user['id'] );?>" width="16" height="16" />
							<a href="<?=site_url('user/' . $user['id']);?>">
								<?=$user['name'] ;?><!--<?= $user['email'];?> '&lt;'  . '&gt;'-->
							</a>
						</span>	
						<?php endforeach; ?>
						
						<input type="hidden" name="mail_send_to" value="<?=$this->input->get('send_to');?>" />
					</p>
					
					<p>
						<label>主题:</label>
						<input style="width:500px;" type="text" name="mail_topic" />
					</p>
					
					<p>
						<label>内容:</label>
						<textarea style="width:500px;height:300px;" name="mail_content"></textarea>
					</p>
					
					<p>
						<label for="mail_file">附件:</label>
						<input type="file" name="mail_file" id="mail_file" /> 
					</p>
					
<!--<form action="upload_file.php" method="post"
enctype="multipart/form-data">
<br />
<input type="submit" name="submit" value="Submit" />
</form>-->
					<div class="align_center">
						<button type="submit" class="kk_btn" onclick="$('#loading').show()">
							发送
						</button>
					</div>
				</form>
			</div>
			
			
		</div>
	</div>
</div>
<? //var_dump($send_to);?>


<div id="sidebar">
	<div class="sidebar_top">
		<div class="sidebar_bottom">
			
			<?php
				$current_user_profile = get_current_user_profile();
				$this->load->view('sidebar/sidebar_user_profile', array(
					'user' => $current_user_profile,
				));
			?>
			<div class="sidebar_widget">
				<h2>您的电邮地址</h2>
				<div class="align_center">
					<?= $current_user_profile['email'];?>
				</div>
			</div>
			
			<?php
				$this->load->view('sidebar/sidebar_user_view', array(
					'user' => $current_user_profile,
				));
			?>

			
		</div>
	</div>
</div>



<?php
	$this->load->view('footer_view');
?>