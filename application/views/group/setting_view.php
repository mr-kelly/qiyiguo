<?php $this->load->view('header_view'); ?>

	<?=import_js('js/app/group/setting.js');?>
	

	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
			
				<form id="group_setting_form" method="post" action="<?=site_url('group/setting/' . $group['id']);?>">
					<div class="kk_tabs">
						<ul class="tab_menu">
							<li>
								<a href="#setting_group_profile">
									<span>果群资料</span>
								</a>
							</li>
							
							<li>
								<a href="#setting_group_slug">
									<span>群网址</span>
								</a>
							</li>
							
							<!--
							<li>
								<a href="#setting_logo">果群图标</a>
							</li>
							-->
							
						</ul>
						
						
						
							<div id="setting_group_profile" class="hidden tab_div">
							
								<h2>果群资料设置</h2>
								
								<div class="form_div">
									
										<p>
											<label>群号</label>
											<span><?=$group['id'];?></span>
										</p>
										<p>
											<label>果群名称</label>
											<input class="required" type="text" name="name" value="<?=$group['name'];?>" />
										</p>
										
										<p>
											<label>果群种类</label>
											<select name="category_id">
											<?php foreach( $group_categories as $cat ): ?>
												<option value="<?=$cat['id'];?>"><?=$cat['name'];?></option>
											<?php endforeach; ?>
											</select>
										</p>
										
										<p>
											<label>群组性质</label>
											<span>
												<input onclick="$('#group_verify_p').hide();" type="radio" name="privacy" value="public" <?=$group['privacy'] == 'public'  ? 'checked="checked"' :'';?> />公开
												<input onclick="$('#group_verify_p').show();" type="radio" name="privacy" value="private" <?=$group['privacy'] == 'private'  ? 'checked="checked"' :'';?> />私密
											</span>
										</p>
										
		
										
										<p id="group_verify_p" class="<?= $group['privacy'] == 'public' ? 'hidden' :'';?>">
											<label for="group_verify">加入方式</label>
											<select id="group_verify" name="verify" class="tipsy_nw" title="其他人加入你果群的方式">
												<option value="request" <?=$group['verify']=='request' ? 'selected="selected"' : '';?>>需要管理员审核加入</option>
												<? //<option value="everyone">任何人都可以直接加入</option> ?>
												<option value="closed" <?=$group['verify']=='closed' ? 'selected="selected"' : '';?>>不允许任何人加入</option>
						
											
											</select>
										</p>
										
										<p>
											<label>位置</label>
											<select class="dict_province location_select" name="province_id">
											<?php
												$ci =& get_instance();
												$provinces =  $ci->dict_model->get_provinces();
												$group_province = $group['province_id']; // 用户当前设置的省份
												foreach ( $provinces as $prov ):
											?>
												<option value="<?=$prov['id'];?>"<?=( $group_province == $prov['id'] ) ? ' selected="selected"' : '' ; ?>><?=$prov['province_name'];?></option>
											
											<?php endforeach; ?>
											</select>
											
											<select class="dict_city location_select" name="city_id">
												<option value="">不设置</option>
											<?php
												$ci =& get_instance();
												$cities =  $ci->dict_model->get_cities($group_province);
												$group_city = $group['city_id'];
												foreach ( $cities as $city ):
											?>
												<option value="<?=$city['id'];?>"<?=( $group_city == $city['id'] ) ? ' selected="selected"' : '' ; ?>><?=$city['city_name'];?></option>
											
											<?php endforeach; ?>
											</select>
											
										</p>
										
										<p>
											<label>群网站</label>
											<input class="url tipsy_w" title="如果有关于这个果群的网址，你可以在这里填写" type="text" name="website" value="<?= isset( $group['website'] ) ? $group['website'] :'' ;?>" />
										</p>
										
										<p>
											<label>果群简介</label>
											<textarea name="intro"><?=$group['intro'];?></textarea>
										</p>
										
										<p>
											<label>统治模式</label>
											<span>
												<input type="checkbox" name="admin_mode" value="1" <?= $group['admin_mode'] ? 'checked="checked"' : '' ;?> />
												只有管理员有权发布话题、活动
											</span>
										</p>
										
										<p>
											<label>隐藏菜单</label>
											<span>
												<input type="checkbox" name="noheader_mode" value="1" <?= $group['noheader_mode'] ? 'checked="checked"' : '' ;?> />
												群组页不显示奇异果顶部菜单
											</span>
										</p>
		
		
										
	
										
									
								</div>
							</div>
							
							
	<!-- 						
							<div id="setting_logo" class="hidden tab_div">
								<h2>友群标志</h2>
								

								<form action="<?=site_url('group/logo_upload/' . $group['id']);?>" method="post" enctype="multipart/form-data">
									<input type="file" name="userfile" size="20" />
									
									<input type="submit" />
								</form>

							</div> -->
							
							
							<div id="setting_group_slug" class="hidden tab_div">
								<div class="form_div">
									<h3>
										当前群网址：
										
										<?php $group_url = get_group_url( $group['id'] ); ?>
										
										
										<a class="group_url" href="<?=$group_url;?>">
											<?= $group_url; ?>
										</a>
									</h3>
									
									<p>
										<label>设置为</label>
										http://qiyiguo.cc/g/
										<input id="slug_input" type="text" name="slug" value="<?= $group['slug'];?>" class="input_text" />
									</p>
								</div>
								
							</div>
							
							
						
					</div><!--END TAB-->
				</form>
				
				<div class="align_center">
					<a id="group_setting_submit" class="kk_btn" href="#">
						<span><span>确认修改</span></span>
					</a>
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

<?php $this->load->view('footer_view'); ?>