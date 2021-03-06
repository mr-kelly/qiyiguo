<?php $this->load->view('header_view'); ?>
		
		
		<?=import_js('js/app/user/setting.js');?>
		<?=import_css('css/app/user/setting.css');?>
					<script>
						
					</script>


<div id="content">
	<div class="content_top">
		<div class="content_bottom">
			
			<form id="user_profiles_form" method="post" action="<?=site_url('user/setting');?>">
				<div class="kk_tabs">
					<ul class="tab_menu">
						<li>
							<a href="#profile_setting">
								<span>资料设置</span>
							</a>
						</li>
						<!--
						<li>
							<a href="#education_setting">学校信息</a>
						</li>
						
						<li>
							<a href="#job_setting">工作信息</a>
						</li>
						-->
						<li>
							<a href="#privacy_setting">
								<span>
									隐私设置
								</span>
							</a>
						</li>
						
						<li>
							<a href="#slug_setting">
								<span>
								个人网址
								</span>
							</a>
						</li>
						
						<li>
							<a href="#recommend_friend_setting">
								<span>
								推荐朋友
								</span>
							</a>
						</li>
					
					</ul>
					
					
					<!--资料设置-->
					<div id="profile_setting" class="tab_div hidden">
						<div class="form_div">

								<p>
									<label>果号</label>
									<span>
										<?=$current_user_profile['id'];?>
									</span>
									<span class="grey">
										在搜索框搜这个号码可以找到群
									</span>
								</p>
								<p>
									<label>电邮地址</label>
									<span>
										<?=$current_user_profile['email'];?>
									</span>
								</p>
								<p>
									<label>真实姓名</label>
									<input class="required" name="realname" type="text" value="<?= $current_user_profile['realname'];?>" />
									<select name="name_privacy">
										<option value="2" <?= $current_user_profile['name_privacy'] == 2 ? 'selected="selected"' : '';?>>只显示真实姓名</option>
										<option value="1" <?= $current_user_profile['name_privacy'] == 1 ? 'selected="selected"' : '';?>>显示昵称+真实姓名</option>
										<option value="0" <?= $current_user_profile['name_privacy'] == 0 ? 'selected="selected"' : '';?>>只显示昵称</option>
									</select>
								</p>
								
								<p>
									<label>昵称</label>
									<input class="required" name="nickname" type="text" value="<?= $current_user_profile['nickname'];?>"  />
								</p>
								
								
								<p>
									<label>性别</label>
									<span>
										<input type="radio" class="" name="gender" value="male" <?=( $current_user_profile['gender'] == 'male' ) ? 'checked="checked"' :''?> />男
										<input type="radio" class="" name="gender" value="female" <?=( $current_user_profile['gender'] == 'female' ) ? 'checked="checked"' :''?>  />女
									</span>
								</p>
								

								<p>
									<label>生日</label>
									
									<?php //年 ?>
									<select class="birth_year" name="birth_year">
										<?php
											
											// 用于年份选择，默认1990
											foreach( range(1890,intval(date('Y'))) as $year ) :
										?>
										<option <?=( $year == $current_user_profile['birth_year'] ) ? 'selected="selected"' : '';?>><?=$year;?></option>
										<?php
											endforeach;
										?>
									</select>年
									
									<?php //月 ?>
									<select class="birth_select" name="birth_month">
										<?php
											foreach( range(1,12) as $month ) :
										?>
										<option <?=( $month == $current_user_profile['birth_month'] ) ? 'selected="selected"' : '';?>><?=$month;?></option>
										<?php
											endforeach;
										?>
									</select>月
									
									<?php // 日 ?>
									<select class="birth_select" name="birth_day">
										<?php
											foreach( range(1,31) as $day ) :
										?>
										<option <?=( $day == $current_user_profile['birth_day'] ) ? 'selected="selected"' : '';?>><?=$day;?></option>
										<?php
											endforeach;
										?>
									</select>日
									
									<!--
									日期空间～～  过期不用了
									<input class="datepicker" name="birth" type="text" value="<?=get_current_user_profile('birth');?>" />
									-->
									
								</p>
								
								<p>
									<label>所在城市</label>
									<select class="dict_province location_select" name="province_id">
									<?php
										$ci =& get_instance();
										$provinces =  $ci->dict_model->get_provinces();
										$user_province = $current_user_profile['province_id']; // 用户当前设置的省份
										foreach ( $provinces as $prov ):
									?>
										<option value="<?=$prov['id'];?>"<?=( $user_province == $prov['id'] ) ? ' selected="selected"' : '' ; ?>><?=$prov['province_name'];?></option>
									
									<?php endforeach; ?>
									</select>
									
									<select class="dict_city location_select" name="city_id">
									<?php
										$ci =& get_instance();
										$cities =  $ci->dict_model->get_cities($user_province);
										$user_city = $current_user_profile['city_id'];
										foreach ( $cities as $city ):
									?>
										<option value="<?=$city['id'];?>"<?=( $user_city == $city['id'] ) ? ' selected="selected"' : '' ; ?>><?=$city['city_name'];?></option>
									
									<?php endforeach; ?>
									</select>
									
								</p>
								
								
								<p>
									<label>籍贯</label>
									<select class="hometown_province location_select" name="hometown_province_id">
										
									<?php
										$ci =& get_instance();
										$provinces =  $ci->dict_model->get_provinces();
										$user_province = $current_user_profile['hometown_province_id']; // 用户当前设置的省份 - 籍贯！
										foreach ( $provinces as $prov ):
									?>
										<option value="<?=$prov['id'];?>"<?=( $user_province == $prov['id'] ) ? ' selected="selected"' : '' ; ?>><?=$prov['province_name'];?></option>
									
									<?php endforeach; ?>
									</select>
									
									<select class="hometown_city location_select" name="hometown_city_id">
									<?php
										$ci =& get_instance();
										if ( empty( $user_province ) ) {
											$user_province = 11; // 如果没设置，给予默认的
										}
										$cities =  $ci->dict_model->get_cities($user_province); 
										$user_city = $current_user_profile['hometown_city_id']; // 籍贯！

										foreach ( $cities as $city ):
									?>
										<option value="<?=$city['id'];?>"<?=( $user_city == $city['id'] ) ? ' selected="selected"' : '' ; ?>><?=$city['city_name'];?></option>
									
									<?php endforeach; ?>
									</select>
								</p>
								
								<p>
									<label>手机</label>
									<input type="text" class="input_text" name="phone" value="<?= !empty( $current_user_profile['phone'] ) ? $current_user_profile['phone'] : '';?>" />
									
									<select name="phone_privacy">
										<option value="3" <?= $current_user_profile['phone_privacy'] == 3 ? 'selected="selected"' : '';?>>所有人可见</option>
										<option value="2" <?= $current_user_profile['phone_privacy'] == 2 ? 'selected="selected"' : '';?>>我收藏的人可见</option>
										<option value="1"<?= $current_user_profile['phone_privacy'] == 1 ? 'selected="selected"' : '';?>>朋友(互相收藏)可见</option>
										<option value="0"<?= $current_user_profile['phone_privacy'] == 0 ? 'selected="selected"' : '';?>>封闭(其他人不能查看你的资料)</option>
									</select>
								</p>
								
								<p>
									<label>新浪微博</label>
									<span>
										<?php
											// 判断是否已绑定。
											$ci =& get_instance();
											$ci->load->model('user_t_sina_model');
											if ( $ci->user_t_sina_model->is_user_t_sina( array(
												'user_id' => get_current_user_id(),
											)) ) :
												// 已绑定
												$user_t_sina = $ci->user_t_sina_model->get_user_t_sina( get_current_user_id() );
										?>
										
											
											<a target="_blank" href="<?=$current_user_profile['t_sina_url'];?>" class="icon icon_t_sina">
												去新浪微博
											</a>
											&nbsp;&nbsp;&nbsp;
											<a onclick="$('#loading').show();" class="btn" href="<?=site_url('user/bind_t_sina');?>">&gt;解除绑定</a>
										<?php else: ?>
											<a target="_blank" class="btn" href="<?=site_url('user/bind_t_sina');?>">
												绑定微博
											</a>
										<?php
											endif;
											
										?>
									</span>
								</p>
								
								<p>
									<label>豆瓣网</label>
									<span>
										<?php
											// 判断是否已绑定。
											$ci =& get_instance();
											$ci->load->model('user_douban_model');
											if ( $ci->user_douban_model->is_user_douban( array(
												'user_id' => get_current_user_id(),
											)) ) :
										?>
											<a target="_blank" class="icon icon_douban" href="<?=$current_user_profile['douban_url'];?>">
												去豆瓣网
											</a>
											&nbsp;&nbsp;&nbsp;
											<a onclick="$('#loading').show();" class="btn" href="<?=site_url('user/bind_douban');?>">
												&gt;解除绑定
											</a>
										<?php else: ?>
											<a target="_blank" class="btn" href="<?=site_url('user/bind_douban');?>">
												绑定豆瓣
											</a>
										<?php
											endif;
											
										?>
									</span>
								</p>
								
								<p>
									<label>个人网站</label>
									<input class="url" name="website" type="text" value="<?= $current_user_profile['website'] ;?>"  />
								</p>
								

								
								<!--
								<p>
									<label>常用电子邮箱</label>
									<input class="email" name="email_1" type="text" value="<?=get_current_user_profile('email_1');?>"  />
								</p>
								
								<p>
									<label>第二电子邮箱</label>
									<input class="email" name="email_2" type="text" value="<?=get_current_user_profile('email_2');?>"  />
								</p>
								
								<p>
									<label>第三电子邮箱</label>
									<input class="email" name="email_3" type="text" value="<?=get_current_user_profile('email_3');?>"  />
								</p>
								-->
								
								<p>
									<label>QQ号</label>
									<input class="digits tipsy_w" title="填写QQ号后朋友可以通过你的个人页面直接跟你QQ聊天" name="qq" type="text" value="<?= $current_user_profile['qq'];?>" />

								</p>
								
								<p>
									<label>MSN聊天</label>
									<input class="email" name="msn" type="text" value="<?= $current_user_profile['msn'];?>" />
								</p>
								
								<p>
									<label>GTalk聊天</label>
									<input class="email" name="gtalk" type="text" value="<?= $current_user_profile['gtalk'];?>" />
								</p>
								
								<p>
									<label>人人网ID号</label>
									<input class="digits tipsy_w" name="link_renren" type="text" value="<?= $current_user_profile['link_renren'];?>" title="人人网个人主页网址是http://www.renren.com/profile.do?id={您的人人网ID}"  />
									<a class="sexybox_iframe" href="http://wiki.qiyiguo.cc/获得人人网的id号">
										如何知道自己的人人网的ID号？
									</a>
								</p>
								
								<p>
									<label>恋爱状态</label>
									<select id="love_status" name="love_status">
										<option value="" <?= $current_user_profile['love_status'] == '' ? 'selected="selected"' :'';?>>不知道</option>
										<option value="single" <?= $current_user_profile['love_status'] =='single'? 'selected="selected"' :'';?>>单身</option>
										<option value="persue" <?= $current_user_profile['love_status'] =='persue'? 'selected="selected"' :'';?>>追求中</option>
										<option value="inlove" <?= $current_user_profile['love_status'] =='inlove'? 'selected="selected"' :'';?>>恋爱中</option>
										<option value="married" <?= $current_user_profile['love_status'] =='married'? 'selected="selected"' :'';?>>已婚</option>
									</select>
								</p>
								
								<script type="text/javascript">
									$(function(){
										$('#love_status').change(function(){
											// 如果恋爱状态设置成“非单身”，那么，显示恋爱对象设置
											if ( $(this).val() == 'persue' || $(this).val() == 'inlove' || $(this).val() == 'married' ) {
												$('#lover_p').show();
											} else {
												$('#lover_p').hide();
											}
										});
									});
								</script>
								
								<?php
									$current_user_love_status = $current_user_profile['love_status'];
								?>
								<p id="lover_p" class="<?=$current_user_love_status == 'single' ? 'hidden' :'';?><?= empty($current_user_love_status) ? 'hidden' :'';?>">
									<label>恋人号</label>
									<?php
										$ci =& get_instance(); $ci->load->model('relation_model');
										$lover = $ci->relation_model->get_lover( get_current_user_id() );
									?>
									<input id="lover_id" class="tipsy_w" type="text" name="lover_id" title="这里填入你另一半的果号" value="<?=$lover['id'];?>" />
								</p>
								<p>
									<label>个人描述</label>
									<textarea name="description"><?= $current_user_profile['description'];?></textarea>
								</p>
								

							<?php
							
							/*
								// 如果用户是使用新浪微博帐号登录，那么不允许设置绑定新浪微博
								
								$ci =& get_instance();
								if ( $ci->user_t_sina_model->is_bind_user_t_sina( $this->tank_auth->get_user_id(),'by_id' ) != 't_sina' ):
							
								<p>
									<label>新浪微博帐号</label>
									<input type="text" name="t_sina_login" value="<?= @ $user_t_sina['t_sina_login'];?>" />
								</p>
								
								<p>
									<label>新浪微博密码</label>
									<input class="input_text" type="password" name="t_sina_password" value="<?= @ $user_t_sina['t_sina_password'];?>" />
								</p>
								<input type="submit" />
								
							
								endif;
							*/
							?>
							
						</div>
						
					</div>
					

					
					<div id="education_setting" class="tab_div hidden">
						<h2>学校信息</h2>
						<div class="form_div">
							<?php
							if	( !empty( $user_education ) ):
								foreach( $user_education as $school ):
							?>
							<p>
								<label>所在学校</label>
								<input type="text" name="school_id[]" value="<?=$school['school_id'];?>" />
								<a class="btn" href="#" onclick="return get_school(this);"><span><span>选择学校</span></span></a>
							</p>
							<?php
								endforeach;
							else:
							?>
							<p>
								<label>所在学校</label>
								<input type="text" name="school_id[]" value="" />
								<a class="btn" href="#" onclick="return get_school(this);"><span><span>选择学校</span></span></a>
							</p>
							<?php
							endif;
							?><!-- 

							<p>
								<label>所在学校</label>
								<input type="text" name="school_id[]" value="" />
								<a class="btn" href="#" onclick="return get_school(this);"><span><span>选择学校</span></span></a>
							</p>
 -->
							
							<script>
								// 弹窗获取指定的学校
								function get_school($this) {
									var school_group_id = window.showModalDialog('<?=site_url("search/window_choose_school");?>','','center=yes;help=no;status=no;location=no');	
									
									$($this).prev().val( school_group_id );
									
									return false;
								}
								
								//alert(temp);
							</script>
							
							
						</div>
					</div>
					
					<div id="job_setting" class="tab_div hidden">
						<h2>工作单位</h2>
						<div class="form_div">
							<?php 
							if ( !empty($user_job_units) ):
								foreach( $user_job_units as $unit ): 
							?>
							<p>
								<label>工作单位</label>
								<input type="text" name="job_unit_id[]" value="<?=$unit['job_unit_id'];?>" ?>
								<a class="btn" href="#" onclick="return get_job_unit(this);"><span><span>选择工作单位</span></span></a>
							</p>
							<?php
								endforeach;
							
							else:
								// 没有设置工作单位时
							?>
							<p>
								<label>工作单位</label>
								<input type="text" name="job_unit_id[]" value="" ?>
								<a class="btn" href="#" onclick="return get_job_unit(this);"><span><span>选择工作单位</span></span></a>
							</p>
							<?php
							endif;
							?>
							
							<script>
								// 弹窗获取指定的工作单位 （Group ID )
								function get_job_unit($this) {
									var job_unit_id = window.showModalDialog('<?=site_url("search/window_choose_job_unit");?>', '','center=yes;help=no;status=no;location=no');
									
									$($this).prev().val( job_unit_id );
									
									return false;
								}
							</script>
						</div>
					</div>
					
					<div id="privacy_setting" class="tab_div hidden form_div">
						<p>
							<label>个人页隐私</label>
							<select name="user_privacy">
								<option value="3" <?= $current_user_profile['user_privacy'] == 3 ? 'selected="selected"' : '';?>>所有人可见</option>
								<option value="2" <?= $current_user_profile['user_privacy'] == 2 ? 'selected="selected"' : '';?>>我收藏的人可见</option>
								<option value="1"<?= $current_user_profile['user_privacy'] == 1 ? 'selected="selected"' : '';?>>朋友(互相收藏)可见</option>
								<option value="0"<?= $current_user_profile['user_privacy'] == 0 ? 'selected="selected"' : '';?>>封闭(其他人不能查看你的资料)</option>
							</select>
						</p>
					</div>
					
					<div id="slug_setting" class="tab_div hidden">
						<div class="form_div">
							<h3>
								<?php
									$slug = $current_user_profile['slug'];
									if ( $slug == '' ) $slug = get_current_user_id();
								?>
								你当前的个人网址: <a id="slug_a" target="_blank" href="http://qiyiguo.cc/u/<?=$slug;?>">qiyiguo.cc/u/<?=$slug;?></a>
							</h3>
						
							<p>
								<label for="slug">设置个人网址:</label>
								http://qiyiguo.cc/u/<input id="slug_input" type="text" name="slug" value="<?= $current_user_profile['slug'];?>" />
							</p>
						</div>
					</div>
					
					<div id="recommend_friend_setting" class="tab_div hidden">
						<label>输入朋友果号: </label>
						<input type="text" name="add_recommend_id" id="add_recommend_id" />

						<a id="add_recommend_btn" class="btn" href="#"><span><span>添加推荐</span></span></a>

						<div>
							<img width="80" id="add_recommend_avatar" src="<?=static_url('img/default_avatar.jpg');?>" />
							<div>
								<span id="add_recommend_name"></span>
							</div>
						</div>
						
						<div id="reommend_users_div">
							
						</div>
						
						<script>
							// 读取推荐的好友到页面
							$('#reommend_users_div').load("<?=site_url('user/ajax_get_recommends');?>");
							
							//添加 推荐好友的 ID输入框
							$('#add_recommend_id').keyup(function(){
								if ( $(this).val() != '' ) {
									$.getJSON(
										'<?=site_url("user/ajax_get_user");?>' + '/' + $(this).val() + '?ajax=<?=rand();?>', 
										function(data){
										
											if ( data.status == 1 ) {
												// 放置头像
												$avatar = data.data.avatar_thumb_url;
												$('#add_recommend_avatar').attr('src', $avatar );
												
												$name = data.data.name;
												$('#add_recommend_name').text( $name );
												
												
												
											} else {
												// 用户不存在！ 清空调出数据
												$('#add_recommend_name').text('');
												$('#add_recommend_avatar').attr('src', $default_user_avatar );
											}
										
									});
								}
							});
							
							$('#add_recommend_btn').click(function(){
								// 如果还没填ID，不反应
								if ( $('#add_recommend_id').val() == '' ) {
									return false;
								}
								
								
								// 添加推荐好友
								$.getJSON( 
									'<?=site_url("user/ajax_add_recommend");?>' + '/' + $('#add_recommend_id').val(),
									function(data){
										if ( data.status == 1 ) {
											// 重新读取推荐好友div
											$('#reommend_users_div').load("<?=site_url('user/ajax_get_recommends');?>");
											kk_growl.success('成功添加推荐用户');
											
										} else {
											kk_growl.error( data.info );
										}
										
								});
								return false;
							});
						</script>
					</div>
					
				</div>
				
			</form>
			
			<div class="align_center">
				<a class="kk_btn" id="submit_user_profiles_form" href="#">
					确认修改
				</a>
			</div>
			
		
		</div><!-- end content bottom-->
	</div>
</div>



<div id="sidebar">
	<div class="sidebar_top">
		<div class="sidebar_bottom">
			
			<?php
				$this->load->view('sidebar/sidebar_user_profile', array(
					'user' => get_current_user_profile(),
				));
			?>
			<div class="sidebar_widget">
				<h2>安全设置</h2>
			
							
				<ul class="sidebar_menu sidebar_links">
					<li>
						<span>
							<a class="tipsy_e" title="更改自己的登录密码" href="<?=site_url('user/change_password');?>">
								<span class="hover"></span>
								<span class="icon icon_setting_group"></span>
								修改密码
							</a>
						</span>
					</li>
				</ul>
				
			</div>
			
			
			<div class="sidebar_widget">

				
				<h2>更改头像</h2>
				<div>
					你使用过的头像...
				</div>
				
				<div>
					<?php
						// 头像更改设置
						if ( $user_avatars != null ):
					?>
							
							
							<?php
								
							
								foreach( $user_avatars as $avatar ):
								
								// 头像更改时同时提交 ajax form, 以确保用户修改资料后，未保存按修改头像资料丢失
							?>	
								<div class="change_avatar">
									<a class="change_avatar" onclick="//$('#user_profiles_form').submit();" href="<?=site_url('user/avatar_set/' . $avatar['id'] );?>">
										<img width="50" src="<?=static_url( sprintf('upload/avatars/%u/%s', get_current_user_id(), $avatar['avatar_thumb']) );?>" />
									</a>
									<div>
										<a href="#" onclick="return delete_btn(this);" ajax="<?=site_url('user/ajax_delete_avatar/' . $avatar['id'] );?>" class="icon icon_delete">
											删除
										</a>
									</div>
								</div>
								
							<?php
								endforeach;
							?>
							
							
					<?php
						endif;
					?>
					
					<div class="clearboth"></div>
					
				</div>
				
				
				<div class="align_center">
					<a class="kk_btn" href="<?=site_url('user/avatar');?>">上传头像</a>
				</div>
				
			</div>
			
			
			

			<?php
				$this->load->view('sidebar/sidebar_ad_pic');
			?>
			
			
		</div>
	</div>
</div>
<?php $this->load->view('footer_view'); ?>