            	<img width="100" height="100" src="<?= get_group_logo_url( $group['id'] ); ?>" />
            	<h2><?=$group['name'];?> <span class="small">(群号:<?=$group['id'];?>)</span></h2>
            	
            	
            	
            	
				<?php $this->load->view('sidebar/sidebar_group_view'); ?>
            	
            	<div class="aside_widget">
					<h3>友群成员</h3>
					<ul>
						<?php	
							foreach ($group_users as $u) {
						?>
							<li>
								<img width="18" src="<?=get_user_avatar_url(  $u['id'], false );?>" />
								<a href="<?=site_url('user/'.$u['id']);?>">
									
									<?=$u['name'];?>
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
										发邮件
									</a>
								</div>
								
							</li>
						<?php } ?>
					</ul>
            	</div>
            	
            	<div class="aside_widget">
            		<h3>友群活动</h3>
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
            	
            	
            	<script>
            		$(function(){
            			$('#create_event_button').click(function(){
            				$('#create_event_div').toggle();
            				return false;
            			});
            		});
            	
            	</script>