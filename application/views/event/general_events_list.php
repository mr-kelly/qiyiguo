<?php
	$ci =& get_instance();
?>
					<ul class="events_list">
					<?php
						if ( !empty( $events ) ):
						$row = 1;
						foreach ( $events as $event ):
					?>
						<li class="event <?= $row % 2 == 0 ? 'event_even' : '';?>">
							<h2>
								<a href="<?=site_url('event/' . $event['id']);?>">
									<?=$event['name'];?>
								</a>
							</h2>
							
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
								</div>
								
								<div class="event_location">
								
								</div>
								
							</div>
							
							<div class="event_content"><?=$event['content'];?></div>
						</li>
					<?php
						$row++;
						endforeach;
						
						else:
					?>
						No Events
					<?php
						endif;
					?>
					</ul>