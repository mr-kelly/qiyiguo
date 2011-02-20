<?php
	$ci =& get_instance();
?>
					<ul class="events_list">
					<?php
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
								<p class="event_time">
									<?=$event['start'];?>
									
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
								</p>
								
								<p class="event_location">
								
								</p>
								
							</div>
							
							<p><?=$event['content'];?></p>
						</li>
					<?php
						$row++;
						endforeach;
					?>
					</ul>