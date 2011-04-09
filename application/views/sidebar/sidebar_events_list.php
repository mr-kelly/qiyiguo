
		
		<h2>活动</h2>
		
<?php
	$ci =& get_instance();
	
?>
		<ul class="sidebar_events_list">
		<?php
			if ( !empty( $events ) ):
			$row = 1;
			foreach ( $events as $event ):
		?>
			<li class="event <?= $row % 2 == 0 ? 'event_even' : '';?>">
					
				<h2><a href="<?=site_url('event/' . $event['id']);?>">
						<?=$event['name'];?>
					</a></h2>
				
				
				<?php 
					//if ( !isset( $no_group_logo ) || !$no_group_logo )  : 
					// 活动图片
				?>
					<div class="event_group_logo">
									<?php
										if ( empty( $event['attach_img_id'] ) ) :
										$event_group_logo_url = get_group_logo_url( $event['model_id'] );
										$event_group_url = get_group_url( $event['model_id'] );
										$event_group = kk_get_group( $event['model_id'] );
									?>
									<a class="tipsy_s" href="<?= $event_group_url ; ?>" title="来自 <?=$event_group['name'];?> <?=$event_group['intro'];?>">
										<img width="40" height="40" src="<?=$event_group_logo_url;?>" />
										
										<br />
										<?= $event_group['name'];?>
									</a>
									
									<?php
										else:
											// 有活动图片？显示活动图片
									?>
									
										<?php if ( !empty( $event['Attach_Img'] ) ) : ?>
										<div class="event_attach_img">
											<a class="sexybox" href="<?=site_url('static/upload/attach_img' . $event['Attach_Img']['file']);?>">
												<img width="40" src="<?=site_url('static/upload/attach_img' . $event['Attach_Img']['file']);?>" />
											</a>
											
											
										</div>
										<?php endif; ?>
										
									<?php 
										endif; 
									?>
					</div>
					
					<?php //endif; ?>

				
				<?php
					$event_user = kk_get_user( $event['user_id'] );
					$user_url = get_user_url( $event_user['id'] );
					
					$ci =& get_instance();
					$ci->load->model('event_model');
					//$event_join_users_count = $ci->event_model->get_event_users_count( $event['id'],'join' );
					$event_users_count  = $ci->event_model->get_event_users_count( $event['id'] );
				?>

				
				<div class="event_detail">
					<div class="event_time small grey">
						<?php
							// 只显示日期，不显示时间...
							if ( !isset( $dateonly ) ) : 
						?>
							<?=$event['start'];?>
						<?php
							else:  // 显示日期
								echo sprintf( '%d年%d月%d日', $ci->humanize->get_year($event['start']), $ci->humanize->get_month($event['start']), $ci->humanize->get_day($event['start']) );
						?>
						<?php endif; ?>
						
						<?php 
							// 如果同一天，不显示到什么时间
							// 不同一天，显示 xx至xx
							if ( $ci->humanize->get_year($event['start']) != $ci->humanize->get_year($event['end']) 
								&& $ci->humanize->get_month($event['start']) != $ci->humanize->get_month($event['end']) 
								&& $ci->humanize->get_day($event['start']) != $ci->humanize->get_day($event['end']) 
								): 
						?>
						- <?=$event['end'];?>
						<?php endif; ?>
						
						<?=$event_users_count;?>人参与
					</div>
				</div>
				
					
				<div class="event_user" >
					<div class="grey">
						<img width="16" src="<?= get_user_avatar_url( $event_user['id'] );?>" />
						
						<a href="<?=$user_url;?>" title="<?=$event_user['name'];?>" class="tipsy_s">
							<?=$event_user['name'];?>
						</a>
						
					</div>
				</div>
				
				
				<div class="event_content">
						<?= kk_content_preview( $event['content'], 64 );?>
				</div>
				
				<div class="event_meta">
	
	
	
				</div>
				
	
			</li>
		<?php
			$row++;
			endforeach;
			
			else:
		?>
			<div class="align_center grey">
				<b>还没有创建活动</b>
			</div>
		<?php
			endif;
		?>
		</ul>
		
		
	