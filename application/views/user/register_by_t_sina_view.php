<?php
	$this->load->view('header_view');
?>

<div id="content">
	<div class="content_top">
		<div class="content_bottom">
			<h2>用新浪微博登录 - 绑定电邮</h2>
			
			
			<div class="form_div">
				<form method="post" action="<?=site_url('user/register_by_t_sina');?>?redirect=<?=$this->input->get('redirect');?>">
				<?php
					$ci =& get_instance();
					$ci->load->library('t_sina');
					$user_t_sina = $ci->t_sina->getSelf();
					//print_r( $user_t_sina );
				?>
					<p>
						<a target="_blank" href="http://t.sina.com.cn/<?=$user_t_sina['id'];?>">
							<img class="avatar" src="<?=$user_t_sina['profile_image_url'];?>" width="50" />
						</a>
						
						微博帐号
						<a target="_blank" href="http://t.sina.com.cn/<?=$user_t_sina['id'];?>">
							
							@<?=$user_t_sina['screen_name'];?>(<?=$user_t_sina['id'];?>)
						</a>
					</p>
					
					<p>
						<label>电邮</label>
						<input type="text" name="email" />
					</p>
					
					<p>
						<label>备用密码</label>
						<input type="password" name="password" />
					</p>
					
					<p>
						<label>真实姓名</label>
						<input type="text" name="realname" />
					</p>
					
					<p>
						<label>昵称</label>
						<input type="text" name="nickname" value="<?=$user_t_sina['screen_name'];?>" />
					</p>
					
					<p>
						<label>生日</label>
						
						<?php //年 ?>
						<select class="birth_year" name="birth_year">
							<?php
								
								// 用于年份选择，默认1990
								foreach( range(1890,intval(date('Y'))) as $year ) :
							?>
							<option <?= $year == 1990 ? 'selected="selected"' :'';?>><?=$year;?></option>
							<?php
								endforeach;
							?>
						</select>
						
						<?php //月 ?>
						<select class="birth_select" name="birth_month">
							<?php
								foreach( range(1,12) as $month ) :
							?>
							<option><?=$month;?></option>
							<?php
								endforeach;
							?>
						</select>
						
						<?php // 日 ?>
						<select class="birth_select" name="birth_day">
							<?php
								foreach( range(1,31) as $day ) :
							?>
							<option><?=$day;?></option>
							<?php
								endforeach;
							?>
						</select>
						
						<!--
						日期控件～～  过期不用了
						<input class="datepicker" name="birth" type="text" value="<?=get_current_user_profile('birth');?>" />
						-->
						
					</p>

					
					<button type="submit" class="kk_btn">
						开始奇异果
					</button>
				</form>
			</div>			
			
		</div>
	</div>
</div>

<?php
	$this->load->view('footer_view');
?>