
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


<?php if ( isset( $group ) ) : ?>
<!-- 
<div class="sidebar_widget">
	
	<h2><?=$group['name'];?> <span class="small">(<?=$group['id'];?>)</span></h2>
    <img width="100" height="100" src="<?= get_group_logo_url( $group['id'] ); ?>" />
</div>
 -->
<?php endif; ?>

<div class="sidebar_widget">
	<h2>关系果群</h2>
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
							友群设置
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
    
    
    <?php if ( isset( $group ) ) : ?>
	<div class="sidebar_widget">
		<h2>友群活动</h2>
		<a href="#" id="create_event_button" class="btn">
			<span><span>创建任务▼</span></span>
		</a>
		
		<div id="create_event_div" class="hidden">
			
			<?php
				$datetime = getdate();
			?>
			
			<form action="<?=site_url('group/ajax_create_event');?>" id="create_event_form" method="post">
				<? // 发表活动的群组 ?>
				
				<input type="hidden" name="event_group_id" value="<?=$group['id'];?>" />
				<label>开始时间:</label>
				
				<br />
				
				<input class="datepicker event_date" type="text" name="create_event_start_date" value="<?=date('Y-m-d');?>" />
				
				<select class="event_time" name="create_event_start_hour">
					<?php foreach ( range(01,24) as $hour ) : ?>
						
						
						<option <?=( $datetime['hours'] == $hour ) ? 'selected="selected"' : '' ; ?> >
							<?=$hour;?>
						</option>
						
						
					<?php endforeach; ?>
				</select>
				:
				<select class="event_time" name="create_event_start_min">
					<?php foreach ( range(00,60) as $min ) : ?>
						<option <?=( $datetime['minutes'] == $min ) ? 'selected="selected"' : '' ; ?> >
							<?=$min;?>
						</option>
					<?php endforeach; ?>
				</select>
				
				<br />
				
				<label>结束时间:</label>
				
				<br />
				
				<input class="datepicker event_date" type="text" name="create_event_end_date" value="<?=date('Y-m-d');?>" />
				
				<select class="event_time" name="create_event_end_hour">
					<?php foreach ( range(01,24) as $hour ) : ?>
						
						
						<option <?=( $datetime['hours'] == ($hour-1) ) ? 'selected="selected"' : '' ; ?> >
							<?=$hour;?>
						</option>
						
						
					<?php endforeach; ?>
				</select>
				:
				<select class="event_time" name="create_event_end_min">
					<?php foreach ( range(00,60) as $min ) : ?>
						<option <?=( $datetime['minutes'] == $min ) ? 'selected="selected"' : '' ; ?> >
							<?=$min;?>
						</option>
					<?php endforeach; ?>
				</select>
				
				<br />
				
				<label>活动名称:</label>
				<input type="text" name="create_event_name" />
				
				<br />
				
				<label>活动内容:</label>
				<textarea class="input_textarea" name="create_event_content"></textarea>
				
				<br />
				
				<a class="awesome small" href="#">创建</a>
				
				<input type="submit" />
			</form>
			
		</div>
		
		
		
	</div>
    <?php endif; ?>
            	
            	<script>
            		$(function(){
            			$('#create_event_button').click(function(){
            				$('#create_event_div').toggle();
            				return false;
            			});
            		});
            	
            	</script>