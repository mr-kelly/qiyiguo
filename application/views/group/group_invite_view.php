<?php
	$this->load->view('header_view');
?>

	<?= import_js( 'js/kk.clipboard/kk.clipboard.min.js');?>
	
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">

				<h1>
					邀请朋友加入
					<img width="16" src="<?=get_group_logo_url( $group['id'] );?>" />
					
					<a href="<?=site_url('group/' . $group['id'] );?>">
						<?= $group['name'];?>
					</a>
				</h1>
				
				<div>
					<h2>群网址</h2>
					
					<p>
						<?= $group['name'];?>的网址。
					</p>
					<p>
						将它复制到到QQ群、QQ聊天、MSN，邀请朋友加入你的群...
					</p>
					
					<br />
					
					<div>
						<input id="group_url_input" style="width: 300px;" type="text" value="<?=get_group_url( $group['id'] );?>" />
					
						<a id="group_url_copy_btn" class="kk_btn" href="#">复制网址</a>
					</div>
					
					
					<script>
						$(function(){
							$('#group_url_input').select();
							
							$.clipboardReady(function(){
							
								$( "#group_url_copy_btn" ).click(function(){
							
									$.clipboard( $('#group_url_input').val() );
							
									return false;
							
								});
							
							});
						});
					</script>
				</div>
				
				
				<div>
					<br />
					
					<h2>发到新浪微博</h2>
					
					<p>
						你可以通过将<?=$group['name'];?>的网址发布到新浪微博，
						邀请朋友来到你的群
					</p>
					
					<br />
					
					<div>
						<form method="post">
							<textarea name="weibo_invite_text" style="height: 40px;width:300px;">我为「<?=$group['name'];?>」建立了一个果群(<?=$group['id'];?>)，朋友们快来加入啦。<?=get_group_url( $group['id'] );?></textarea>
						</form>
					</div>
					
					<div>
						<a href="#" class="tipsy_n kk_btn" title="通过新浪微博邀请朋友加入<?=$group['name'];?>">
							告诉朋友
						</a>						
					</div>
					
					
				</div>
				
				
			</div>
		</div>
	</div>


	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
			
				<?php
					$this->load->view('sidebar/sidebar_group_profile');
				?>
				
				<?php
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
				
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>


