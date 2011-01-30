
<?php
	$ci =& get_instance();
	$ci->load->model('request_model');
	$request_group = $ci->request_model->get_request_admin_groups_num( $this->tank_auth->get_user_id() );
	if ( $request_group != false ) {
?>
           <a href="<?=site_url('request/group');?>"><?=$request_group;?>个加入友群请求</a>
<?php
	}
?>


<ul class="sidebar_menu sidebar_links">
	
	<?php 
		if (isset($before_sidebar_item)) echo $before_sidebar_item; 
	?>
	
	
	<?php
		// 友群设置
		if ( isset( $group )):
			if ($ci->group_model->is_group_admin($group['id'], get_current_user_profile('id'))):
	?>
			<li>
				<a class="tooltip" title="群组的设置，公有、私有" href="<?=site_url('group/setting/'.$group['id']);?>">
					<span class="icon_setting">友群设置</span>
				</a>
			</li>
	<?php
			endif;
		endif;
	?>
	
	
	
	<li>
		<a class="tipsy_e" title="由你来创建一个群组~它可以是你的朋友圈、公司、组织、兴趣小组" href="<?=site_url('group/new_group');?>">
			创建新友群
		</a>
	</li>
	
	<li>
		<a class="tipsy_e" title="查看你已加入的群组" href="<?=site_url('user/joined_groups');?>">
			已加入的群组
		</a>
	</li>
</ul>