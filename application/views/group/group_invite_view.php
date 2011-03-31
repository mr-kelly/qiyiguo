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
					
					<?php
						$ci =& get_instance();
						$ci->load->model('user_t_sina_model');
						if ( $ci->user_t_sina_model->is_user_t_sina( array( 'user_id' => get_current_user_id(),)) ) :
					?>
					
					<p>
						将<?=$group['name'];?>的网址发布到新浪微博，
						邀请朋友来到你的群
					</p>
					
					<br />
					
					<form method="post" action="<?=site_url('group/group_invite/' . $group['id'] . '/t_sina' );?>">
						<div>
								<textarea name="t_sina_text" style="height: 40px;width:300px;">我为「<?=$group['name'];?>」建立了一个果群(<?=$group['id'];?>)，朋友们快来加入啦。<?=get_group_url( $group['id'] );?></textarea>
						</div>
						
						<div>
							<br />
							<button type="submit" class="tipsy_n kk_btn" title="通过新浪微博邀请朋友加入<?=$group['name'];?>">
								告诉朋友
							</button>						
						</div>
					</form>
					<?php
						else:
					?>

					<div>
						你还未绑定新浪微博，到<a href="<?=site_url('user/setting');?>">个人设置</a>页绑定
					</div>

					<?php
						endif;
					?>
					
				</div>
				
				
			</div>
		</div>
	</div>


	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
			
				<?php
					$this->load->view('sidebar/sidebar_group_profile');
					$this->load->view('sidebar/sidebar_group_view');
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


