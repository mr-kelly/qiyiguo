
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
		if( !isset( $no_join_group_btn ) ) {
			// 没有设置该变量的话，显示“加入群组按钮”
			$this->load->view('group/general_join_group_view'); 
		}
	?>


</div>

<?php
	// 查看的群组的状态、按钮
	endif;
?>


<?php
	if ( isset( $group ) ) :
		if ( is_group_admin( $group['id'], get_current_user_id() ) ) :
?>
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
							<span class="icon icon_quit_group_admin"></span>
							放弃管理员身份
						</a>
					</span>
				</li>
				
				<li>
					<span>
						<a href="<?=site_url('group/setting/' . $group['id'] . '/advanced');?>">
							<span class="hover"></span>
							<span class="icon icon_setting_group_advanced"></span>
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
						<span class="icon icon_delete_group"></span>
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
<?php
		endif;
	endif;
?>




<?php if ( isset( $group ) ) : ?>

<div class="sidebar_widget">


	<h2>关系群</h2>
	
<?php if ( !empty( $relation_groups ) ) :?>	
		<?php
			$this->load->view('group/general_groups_list', array(
				'groups' => $relation_groups,
			));
		?><!-- END Groups List-->
		
		
		<div class="clearboth"></div>
		
		<?php //if ( count( $relation_groups ) == 6 ) : ?>
		<div class="align_right">
			<a href="<?=site_url('group/' . $group['id'] . '/relations');?>">
				&gt;全部<?=$relation_groups_count;?>个关系群
			</a>
		</div>
		<?php //endif; ?>
<?php
	else:
?>
	<div class="align_center grey">
		还没有关系群...
	</div>
<?php endif; ?>
		

		
		<?php
			if ( isset( $group ) ) : 
				// 需要群组管理员
				if ( is_group_admin( $group['id'], get_current_user_id() ) ):
		?>
		<div class="align_center" style="margin-top:20px;">
			<?php
				// IE6转到指定页面添加群组
				if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false ):
				//if ( ie6 ) :
			?>
			<a title="添加关系群(友情链接群)" class="tipsy_n kk_btn" href="<?=site_url('relation/choose_group_relation/' . $group['id'] );?>">
			<?php
				else:
			?>
			<a title="添加关系群(友情链接群)" class="tipsy_n sexybox kk_btn" href="<?=site_url('relation/ajax_choose_group_relation/' . $group['id'] );?>">
			<?php endif; ?>
				<span><span>&gt;添加友情群</span></span>
			</a>
			
			<div class="clearboth"></div>
			
		</div>
		<?php
				endif;
			endif; 
		?>

	
	<div class="clearboth"></div>


</div>
<?php
	endif;  // 如果没有$group, 非查看群组页，不显示关系群
?>

    <?php
    	if ( !isset( $no_sidebar_group_users_list ) || !$no_sidebar_group_users_list  ) :
	    	if ( isset( $group_users ) ) :?>
	<div class="sidebar_widget">
		<h2>成员<?= isset($group_users_count) ? ' <span class="small">('. $group_users_count .')</span>' :'';?></h2>
		
		<?php
			$this->load->view('sidebar/sidebar_users_list', array(
				'users' => $group_users,
			));
		?>
		
		<div class="align_right">
			<a href="<?=site_url('group/' . $group['id'] . '/members' );?>">
				&gt;查看成员列表
			</a>
		</div>
		
	</div>
    <?php	
    		endif;
    	endif;
    ?>
    
    
    
    <?php if ( isset( $events ) && isset( $group ) ) : ?>
    <div class="sidebar_widget">
		<?php
			if ( isset( $show_sidebar_group_events_list ) && $show_sidebar_group_events_list ) : 
				$this->load->view('sidebar/sidebar_events_list', array(
					'events' => $events,
				));
			endif;
		?>
	
		<?php if ( count( $events ) >= 10 ) : ?>
		<div class="align_right">
			<a href="<?=site_url('group/' . $group['id'] . '/event?start=10' );?>">
				&gt;更多活动
			</a>
		</div>
		<?php endif; ?>
		
		<div class="clearboth"></div>
		
	</div>
	<?php endif; ?>
	
	
    <?php
    	if ( empty( $relation_groups ) ) :
    ?>
    	<div class="sidebar_widget">
    		<h2>推荐群</h2>
    		<?php
    			$ci =& get_instance();
    			
    			$ci->load->model('group_model');
    			
    			$this->load->view('group/general_groups_list', array(
    				'groups' => $ci->group_model->get_groups( array(), 8, 0, true ),
    			));
    		?>
    		
    		<div class="clearboth"></div>
    	</div>
    	
    	
    	
    <?php
    	endif;
    ?>
    
    
    <?php
    	// 提示公开群组的管理员!!! 叫他们开个内部管理的东西！
    	if ( isset( $group ) ):
    		if ( is_group_admin( $group['id'], get_current_user_id() )  ):
	    		if ( $group['privacy'] == 'public' ):
    			
    ?>
    	<div class="sidebar_widget">
    		<h2>内部组织需要人员管理?</h2>
    		<p>
    			你可以建立一个「私密」群，让其他人必须通过你的验证才能加入。
    			
    			...
    			<a href="#" onclick="$('#create_group_btn').trigger('click');return false;">
    				&gt;去创建
    			</a>
    		</p>
    	</div>
    <?php
    			else:
    				//提示私密群组的管理员，开个对外的东西
    ?>
    	<div class="sidebar_widget">
    		<h2>需要对外宣传组织？</h2>
    		<p>
    			你可以建立一个「公开」群，或者在「<a href="<?=site_url('group/setting/'. $group['id']);?>">果群设置</a>」将这一个群转变成公开群。
    		</p>
    	</div>
    <?php
				endif;
    		endif;
    	endif;
    ?>

    
    <div class="sidebar_widget">
    <?php
    	$this->load->view('sidebar/sidebar_jiathis');
    ?>
    </div>