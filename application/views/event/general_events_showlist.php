
						<ul class="events_show">
						<?php 
							if ( !empty( $events ) ):
							foreach( $events as $event ) :
								$event_group = kk_get_group( $event['model_id'] );
								$event_user = kk_get_user( $event['user_id'] );
						?>
							<li>
								<div class="float_left">

									
									<span class="tipsy_s" title="来自<?= $event_group['name'];?>">
										<a href="<?= get_group_url( $event_group['id'] );?>">
											<img width="24" src="<?= get_group_logo_url( $event_group['id'] );?>" />
										</a>
									</span>
									
									<span class="tipsy_s" title="作者:<?= $event_user['name'];?>">
										<a href="<?= get_user_url( $event_user['id'] );?>">
											<img width="24" src="<?= get_user_avatar_url( $event_user['id'] );?>" />
										</a>
									</span>
									


								</div>
								
								<div class="float_right">
									<?php if ( isset( $show_group_name ) ) :?>
									<span>
										<a href="<?= get_group_url( $event_group['id'] );?>">
											<?= kk_content_preview( $event_group['name'], 40 );?>
										</a>
									</span>
									<?php endif; ?>
									
									<?php
										$ci =& get_instance();
										$ci->load->model('event_model');
										$event_users_count = $ci->event_model->get_event_users_count( $event['id'] );
									?>
									<span class="grey">
										<?=$event_users_count; ?>人参与
									</span>
								</div>
								<a class="tipsy_s" href="<?=site_url('event/' . $event['id'] );?>" title="<?= $event_group['name'] . ' 的 ' . $event_user['name']  . ' 组织活动: ' .   kk_content_preview( $event['content'], 200);?>">
									<?= $event['name'];?>
								</a>
								

							</li>
						<?php
							endforeach;
							else:
						?>
							<div class="grey align_center">
								<b>还没加入任何有活动的群...</b>
								<a href="<?=site_url('group');?>">
									->去看看
								</a>
							</div>
						<?php
							endif;
						?>
						</ul>