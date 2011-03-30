<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				
				<!--<h2>邀请MSN好友</h2>-->
				
				<h2>发一条微博</h2>
				<div>
					如果未绑定微博...
					<form method="post" action="<?=site_url('invite/t_sina');?>">
						<div>
							<span class="icon icon_t_sina">通过发送新浪微博告诉朋友</span>
							
						</div>
						
						<div>
							<br />
							
							<textarea name="t_sina">我的果号是<?=get_current_user_id();?>，果断找我吧，果址是<?=get_user_url( get_current_user_id() );?>。</textarea>
						</div>
						
						<div>
							<br />
							
							<button type="submit" class="kk_btn">
								&gt;微博通知
							</button>
							
						</div>
					</form>
				</div>
				
				<!--<h2>选择微博好友</h2>-->
				
				
				
				<h2>邀请入群</h2>
				<p>
					其实，你可以把你建立的<b>群的网址</b>告诉朋友。 朋友就可以关注、加入你的群组。
				</p>
					
				
				
			</div>
		</div>
	</div>


	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php
					$this->load->view('sidebar/sidebar_user_profile', array(
						'user'=>get_current_user_profile(),
					));
					$this->load->view('sidebar/sidebar_user_view', array(
						'user'=>get_current_user_profile(),
					));
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>