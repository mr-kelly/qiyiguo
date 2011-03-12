<?php
	$this->load->view('header_view');
?>

<div id="content">
	<div class="content_top">
		<div class="content_bottom">
			<h2>绑定电邮</h2>
			
				<?php
					//print_r( $douban_self );
				?>
			<div class="form_div">
				<form method="post" action="<?=site_url('user/register_by_douban');?>?redirect=<?=$this->input->get('redirect');?>">

					<p>
						<a target="_blank" href="http://t.sina.com.cn/<?=$douban_self['id'];?>">
							<img class="avatar" src="<?=$douban_self['link'][2]['@href'];?>" width="50" />
						</a>
						
						你是第一次使用豆瓣帐号登录
						<a target="_blank" href="<?=$douban_self['link'][1]['@href'];?>">
							
							<?=$douban_self['title']['$t'];?>(<?=$douban_self['db:uid']['$t'];?>)
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
						<input type="text" name="nickname" value="<?=$douban_self['title']['$t'];?>" />
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

					<p>
						<label>性别</label>
						<input type="radio" name="gender" value="male" /> 男
						<input type="radio" name="gender" value="female" /> 女
					<p>
						<label>所在城市</label>
						<select class="dict_province location_select" name="province_id">
						<?php
							$ci =& get_instance();
							$provinces =  $ci->dict_model->get_provinces();
							foreach ( $provinces as $prov ):
						?>
							<option value="<?=$prov['id'];?>"><?=$prov['province_name'];?></option>
						
						<?php endforeach; ?>
						</select>
						
						<select class="dict_city location_select" name="city_id">
						<?php
							$ci =& get_instance();
							$cities =  $ci->dict_model->get_cities();
							foreach ( $cities as $city ):
						?>
							<option value="<?=$city['id'];?>"><?=$city['city_name'];?></option>
						
						<?php endforeach; ?>
						</select>
					</p>
					
					
					<button type="submit" class="btn">
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