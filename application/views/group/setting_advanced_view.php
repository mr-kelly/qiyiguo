<?php $this->load->view('header_view'); ?>
	<? //import_js('js/app/group/setting.js');?>
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>高级功能</h1>
				
				<h2>群聊天（实验）</h2>
				<p>
					你可以在奇异果实现QQ群的集体即时聊天。
				</p>
				<div class="align_center">
					<a href="<?=site_url( 'group/' . $group_id . '/chat' );?>" class="kk_btn">
						&gt;群组聊天
					</a>
				</div>
				
				<h2>高级设置</h2>
				
				<div class="form_div">
					<form id="group_setting_form" class="ajax_form" method="post" action="<?=site_url('group/setting/' . $group['id'] . '/advanced' );?> ">
						
						<?php // 防止不传任何值通不过表单验证 ?>
						<input type="hidden" name="null" value="null" />
						
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
					</form>
				</div>
				
				<div class="align_center">
					<a onclick="$('#group_setting_form').submit();return false;" id="group_setting_submit" class="kk_btn" href="#">
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
					
					$this->load->view('sidebar/sidebar_group_view');
				?>
				
				
				<?php
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
			</div>
		</div>
	</div>

<?php $this->load->view('footer_view'); ?>