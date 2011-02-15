<?php $this->load->view('header_view'); ?>

	<?=import_js('js/app/group/setting.js');?>
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php //$this->load->view('sidebar/sidebar_group_view'); ?>
			</div>
		</div>
	</div>
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<div class="kk_tabs">
					<ul class="tab_menu">
						<li>
							<a href="#setting_group_profile">果群资料</a>
						</li>
						
						<li>
							<a href="#setting_logo">果群图标</a>
						</li>
						
					</ul>
					
					<div id="setting_group_profile" class="hidden tab_div">
						<h2>果群资料设置</h2>
						
						<div class="form_div">
							<form method="post" action="<?=site_url('group/setting');?>">
								
								<p>
									<label>果群名称</label>
									<input type="text" name="group_name" value="<?=$group['name'];?>" />
								</p>
								
								<p>
									<label>果群种类</label>
									<select>
									<?php foreach( $group_categories as $cat ): ?>
										<option value="<?=$cat['id'];?>"><?=$cat['name'];?></option>
									<?php endforeach; ?>
									</select>
								</p>
								
								<p>
									<label>群组性质</label>
									<input type="radio" name="privacy" <?=$group['privacy'] == 'public'  ? 'checked="checked"' :'';?> />公开
									<input type="radio" name="privacy" <?=$group['privacy'] == 'private'  ? 'checked="checked"' :'';?> />私密
								</p>
								
								<p>
									<label for="group_verify">加入方式</label>
									<select id="group_verify" name="group_verify" class="tipsy_nw" title="其他人加入你果群的方式">
										<option value="request" <?=$group['verify']=='request' ? 'selected="selected"' : '';?>>需要管理员审核加入</option>
										<option value="everyone" <?=$group['verify']=='everyone' ? 'selected="selected"' : '';?>>任何人都可以直接加入</option>
										<option value="closed" <?=$group['verify']=='closed' ? 'selected="selected"' : '';?>>不允许任何人加入</option>
				
									
									</select>
								</p>
								
								<p>
									<label>果群简介</label>
									<textarea name="intro"><?=$group['intro'];?></textarea>
								</p>
								
								<p class="center">
									<a class="btn" href="#"><span><span>确认修改</span></span></a>
								</p>
								
							</form>
						</div>
					</div>
					
					<div id="setting_logo" class="hidden tab_div">
						<h2>友群标志</h2>
						
						<form action="<?=site_url('group/logo_upload/' . $group['id']);?>" method="post" enctype="multipart/form-data">
							<input type="file" name="userfile" size="20" />
							
							<input type="submit" />
						</form>
					</div>
				
				</div>
				
				
			</div>
		</div>				
	</div>
	

<?php $this->load->view('footer_view'); ?>