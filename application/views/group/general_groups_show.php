				<?php if ( !empty ( $groups ) ) : ?>
				
				<ul class="groups_show">
				<?php
					foreach( $groups as $group ) : 
						$user_group_url = get_group_url( $group['id'] );
				?>
					<li class="tipsy_s" title="<?=$group['name'];?> <?=$group['intro'];?>">
						<div class="group_logo">
							<a href="<?=$user_group_url;?>">
								<img class="avatar" width="50" src="<?=get_group_logo_url( $group['id'] ); ?>" />
							</a>
						</div>
						
						<div class="group_intro">
							<div>
								<a href="<?=$user_group_url;?>">
									<?= $group['name'];?>
								</a>
							</div>
							
							<div class="grey">
								<?php
									$ci =& get_instance();
									$ci->load->model('group_model');
									$group_members_count = $ci->group_model->get_group_users_count( $group['id'] );
								?>
								<?= $group_members_count; ?>名成员
							</div>
							
							<div>
								<?= kk_content_preview( $group['intro'], 55 ); ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
				</ul>
				
				<div class="clearboth"></div>
				
				<?php else: ?>
					没有群组...
				
				<?php endif; ?>