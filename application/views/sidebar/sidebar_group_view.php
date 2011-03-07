
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



<div class="sidebar_widget align_center">

	<?php
		// 加入群组按钮
		$this->load->view('group/general_join_group_view'); 
	?>


</div>

<?php
	// 查看的群组的状态、按钮
	endif;
?>


<div class="sidebar_widget">

<?php if ( !empty( $relation_groups ) ) :?>
	<h2>关系群</h2>
	
	
		
		<ul class="groups_show">
			<?php foreach( $relation_groups as $relation_group ) : ?>
			<li class="group">
				<div class="group_logo">
					<a href="<?=site_url('group/' . $relation_group['id']);?>">
						<img class="avatar" src="<?=get_group_logo_url( $relation_group['id'] );?>" width="40" />
					</a>
				</div>
				
				<div class="group_name">
					<a class="tipsy_s" href="<?=get_group_url( $relation_group['id'] );?>" title="<?=$relation_group['id'];?> <?=$relation_group['intro'];?>">
						<?= $relation_group['name']; ?>
					</a>
				</div>
			
			</li>
			<?php endforeach; ?>
			
			<div class="clearboth"></div>
		</ul><!-- END Groups List-->
		
		
		<?php if ( count( $relation_groups ) == 6 ) : ?>
		<div class="align_right">
			<a href="<?=site_url('group/' . $group['id'] . '/relations');?>">
				&gt;全部<?=$relation_groups_count;?>个关系群
			</a>
		</div>
		<?php endif; ?>
		
<?php endif; ?>
		

		
		<?php
			if ( isset( $group ) ) : 
				// 需要群组管理员
				if ( is_group_admin( $group['id'], get_current_user_id() ) ):
		?>
		<div class="align_center">
			<a title="添加关系群(友情链接群)" class="tipsy_n sexybox kk_btn" href="<?=site_url('relation/ajax_choose_group_relation/' . $group['id'] );?>">
				<span><span>&gt;添加关系群</span></span>
			</a>
			
			<div class="clearboth"></div>
			
		</div>
		<?php
				endif;
			endif; 
		?>

	
	<div class="clearboth"></div>


</div>





<div class="sidebar_widget">
	<h2>群控制</h2>
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
							放弃管理员身份
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
		?>
			
				<?php
					// 判断是否群的 拥有者, 是， 显示消灭群
					if ( is_group_owner( $group['id'], get_current_user_id() ) ) :
				?>
				<li>
					<a href="<?=site_url('group/destroy/' . $group['id'] );?>" class="tipsy_e" title="你是群的创始人，毁灭这个群吧？">
						<span class="hover"></span>
						<span class="icon icon_create_group"></span>
						毁灭该群
					</a>
				</li>
				<?php
					endif;
				?>
		
		
		<?php
			endif;
		?>
		
		
		
		<li>
			<a class="tipsy_e sexybox_iframe" title="由你来创建一个群组~它可以是你的朋友圈、公司、组织、兴趣小组" href="<?=site_url('group/iframe_new_group');?>">
				<span class="hover"></span>
				<span class="icon icon_create_group"></span>
				创建新果群
			</a>
		</li>
		


	</ul>

</div>



    <?php if ( isset( $group_users ) ) :?>
	<div class="sidebar_widget">
		<h2>成员<?= isset($group_users_count) ? ' <span class="small">('. $group_users_count .')</span>' :'';?></h2>
		
		<?php if ( !empty( $group_users ) ) :?>
		<ul class="sidebar_users_list">
			<?php	
				foreach ($group_users as $u) {
			?>
				<li>
					<a class="sexybox" href="<?=get_user_avatar_url(  $u['id'], 'big' );?>" title="<?=$u['name'];?>">
						<img width="18" src="<?=get_user_avatar_url(  $u['id'], false );?>" />
					</a>
					
					<a class="tipsy_e" href="<?=get_user_url( $u['id'] );?>" title="<?=$u['id'];?>">
						<?=$u['name'];?> <!--(<?=$u['id'];?>)-->
					</a>
					
					
					<div class="sidebar_user_control">
						<?php
							// 若是管理员
							if ( $this->group_model->is_group_admin($group['id'], $u['id'])) :
						?>
						<a class="tipsy_e icon icon_admin" href="javascript:void(0);" title="管理者"></a>
						<?php
							endif;            					
						?>
						
						<?php // 发送邮件给指定ID用户的email ?>
						<a class="tipsy_e icon icon_email" href="<?=site_url('mail?' . 'send_to=' . $u['id'] );?>" title="向<?=$u['name'];?>发送电邮"></a>
					</div>
					
				</li>
			<?php } ?>
		</ul>
		<?php
			else: // 没有成员？
		?>
		还没有成员.
		<?php endif; ?>
		
		<div class="align_right">
			<a href="<?=site_url('group/' . $group['id'] . '/members' );?>">
				&gt;查看成员列表
			</a>
		</div>
		
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
    		<h2>需要对外宣传组织？</h2>
    	</div>
    <?php
				endif;
    		endif;
    	endif;
    ?>