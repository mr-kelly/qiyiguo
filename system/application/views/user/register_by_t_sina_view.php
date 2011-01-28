<?php
	$this->load->view('header_view');
?>

<div id="content">
	<div class="content_top">
		<div class="content_bottom">
			<h2>用新浪微博登录 - 绑定电邮</h2>
			
			
			<div class="form_div">
				<form method="post" action="<?=site_url('user/register_by_t_sina');?>">
				<?php
					$ci =& get_instance();
					$ci->load->library('t_sina');
					$user_t_sina = $ci->t_sina->getSelf();
	
				?>
					<p>
						微博帐号
						<a target="_blank" href="http://t.sina.com.cn/<?=$user_t_sina['id'];?>">@<?=$user_t_sina['screen_name'];?>(<?=$user_t_sina['id'];?>)</a>
					</p>
					
					<p>
						<label>电邮</label>
						<input type="text" name="email" />
					</p>
					
					<p>
						<label>备用密码</label>
						<input type="text" name="password" />
					</p>
					
					<p>
						<label>真实姓名</label>
						<input type="text" name="realname" />
					</p>
					
					<p>
						<label>昵称</label>
						<input type="text" name="nickname" />
					</p>
					
					
					
					
					<button type="submit" class="awesome blue">
						<span><span>开始奇异果！</span></span>
					</button>
				</form>
			</div>			
			
			<?php
				print_r( $ci->t_sina->getSelf() );
			?>
		</div>
	</div>
</div>

<?php
	$this->load->view('footer_view');
?>