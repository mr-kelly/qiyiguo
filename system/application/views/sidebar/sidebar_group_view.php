
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


<ul class="sidebar_menu">
	
	<?php 
		if (isset($before_sidebar_item)) echo $before_sidebar_item; 
	?>
	
	
	<?php
		// 友群设置
		if ( isset( $group )):
			if ($ci->group_model->is_group_admin($group['id'], get_current_user_profile('id'))):
	?>
			<li>
				<a href="<?=site_url('group/setting/'.$group['id']);?>">友群设置</a>
			</li>
	<?php
			endif;
		endif;
	?>
	
	
	
	<li>
		<a href="<?=site_url('group/new_group');?>">
			创建新友群
		</a>
	</li>
	
	<li>
		<a href="<?=site_url('user/joined_groups');?>">
			我已加入的友群
		</a>
	</li>
</ul>