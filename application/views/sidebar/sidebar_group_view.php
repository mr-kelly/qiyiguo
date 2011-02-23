
<?php
	$ci =& get_instance();
	$ci->load->model('request_model');
	$request_group = $ci->request_model->get_request_admin_groups_num( $this->tank_auth->get_user_id() );
	if ( $request_group != false ) {
?>
           <a href="<?=site_url('request');?>"><?=$request_group;?>个加入友群请求</a>
<?php
	}
?>


<?php if ( isset( $group ) ) : ?>
<!-- 
<div class="sidebar_widget">
	
	<h2><?=$group['name'];?> <span class="small">(<?=$group['id'];?>)</span></h2>
    <img width="100" height="100" src="<?= get_group_logo_url( $group['id'] ); ?>" />
</div>
 -->
<?php endif; ?>

<div class="sidebar_widget">
	<h2>关系群组</h2>
</div>

<div class="sidebar_widget">
	<h2>果群面板</h2>
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
					<span>
						<a class="tipsy_e" title="群组的设置，公有、私有" href="<?=site_url('group/setting/'.$group['id']);?>">
							<span class="hover"></span>
							<span class="icon icon_setting_group"></span>
							果群设置
						</a>
					</span>
				</li>
				
				<li>
					<span>
						<a class="tipsy_e" title="管理果群成员" href="<?=site_url('group/setting/' . $group['id'] . '/members' );?>">
							<span class="hover"></span>
							<span class="icon icon_members"></span>
							成员管理
						</a>
					</span>
				</li>
				
				<li>
					<span>
						<a href="<?=site_url('group/ajax_cancel_group_admin/' . $group['id']);?>" class="tipsy_e cancel_group_admin_btn" title="取消该群的管理员身份">
							<span class="hover"></span>
							<span class="icon icon_setting_group"></span>
							取消管理员身份
						</a>
					</span>
				</li>
				
				<li>
					<span>
						<a href="<?=site_url('group/setting/' . $group['id'] . '/advanced');?>">
							<span class="hover"></span>
							<span class="icon icon_setting_group"></span>
							高级功能
						</a>
					</span>
				</li>
				<script>
					$('.cancel_group_admin_btn').click(function(){
						
						if ( !confirm('确定取消这果群的管理员身份?') ) {
							return false;
						} else {
							$.getJSON( $(this).attr('href'), function(json){
								if ( json.status == 1 ) {
									kk_growl.success( '已取消管理员身份!');
									setInterval('location.reload()', 500);
								} else {

									kk_growl.error( json.info );
									
								}
							});
							
						}
							
						return false;
					});
				</script>
				
		<?php
				endif;
			endif;
		?>
		
		
		
		<li>
			<a class="tipsy_e sexybox_iframe" title="由你来创建一个群组~它可以是你的朋友圈、公司、组织、兴趣小组" href="<?=site_url('group/iframe_new_group');?>">
				<span class="hover"></span>
				<span class="icon icon_create_group"></span>
				创建新果群
			</a>
		</li>
		

		
		<li>
			<a class="tipsy_e" title="查看你已加入的群组" href="<?=site_url('user/joined_groups');?>">
				<span class="hover"></span>
				<span class="icon icon_joined_group"></span>
				已加入的群组
			</a>
		</li>
	</ul>

</div>



    <?php if ( isset( $group_users ) ) :?>
	<div class="sidebar_widget">
		<h2>友群成员<?= isset($group_users) ? ' <span class="small">('.count($group_users).')</span>' :'';?></h2>
		<ul class="sidebar_users_list">
			<?php	
				foreach ($group_users as $u) {
			?>
				<li>
					<img width="18" src="<?=get_user_avatar_url(  $u['id'], false );?>" />
					<a href="<?=site_url('user/'.$u['id']);?>">
						
						<?=$u['name'];?>(<?=$u['id'];?>)
						<?php
						
						if ( $this->group_model->is_group_admin($group['id'], $u['id'])) {
							// 若是管理员
							echo '(管理员)';
						}            					
						?>
					</a>
					<div>
						<!--<a href="mailto:<?=$u['name'];?><<?=$u['email_1'];?>>">-->
						<a href="<?=site_url('mail?' . 'send_to=' . $u['id'] );?>">
							<?php // 发送邮件给指定ID用户的email ?>
							发电邮
						</a>
					</div>
					
				</li>
			<?php } ?>
		</ul>
	</div>
    <?php endif; ?>
    
    <?php
    	// 提示公开群组的管理员!!! 叫他们开个内部管理的东西！
    	if ( isset( $group ) ):
    		if ( is_group_admin( $group['id'], get_current_user_id() )  ):
	    		if ( $group['privacy'] == 'public' ):
    			
    ?>
    	<div class="sidebar_widget">
    		<h2>内部组织需要人员管理?</h2>
    	</div>
    <?php
    			else:
    				//提示私密群组的管理员，开个对外的东西
    ?>
    	<div class="sidebar_widget">
    		<h2>需要一个对外宣传组织？</h2>
    	</div>
    <?php
				endif;
    		endif;
    	endif;
    ?>