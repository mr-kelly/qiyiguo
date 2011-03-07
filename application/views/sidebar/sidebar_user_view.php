		
				

				<div class="sidebar_widget">
					<h2>他的群</h2>
					<ul class="groups_show">
					<?php
						if ( !empty( $user_groups ) ):
							foreach( $user_groups as $user_group ) :
					?>
						<li>
							<div>
								<img width="40" src="<?=get_group_logo_url( $user_group['id'] );?>" />
							</div>
							<div>
								<a href="<?=get_group_url( $user_group['id'] );?>">
									<?=$user_group['name'];?>
								</a>
							</div>
						</li>
					<?php
							endforeach;
						else:
					?>
						<div class="align_center">
							<b>没有加入任何群组</b>
						</div>
					<?php
						endif;
					?>
					</ul>
					
					<div class="clearboth"></div>
					
					<div class="align_right">
						<a href="<?=site_url('user/user_groups/' . $user['id'] ); ?>">&gt;加入了<?=$user_groups_count;?>个群组</a>
					</div>
				</div>
				
				


				<?php if ( $users_common_groups ): ?>
				<div class="sidebar_widget">
					<h2>共同群组</h2>
					<ul class="groups_show">
					<?php foreach ( $users_common_groups as $uc_group ) : ?>
						<li>
							<div>
								<img width="30" src="<?=get_group_logo_url( $uc_group['id'] );?>" />
							</div>
							<div>
								<a href="<?=get_group_url($uc_group['id']);?>">
									<?=$uc_group['name'];?>
								</a>
							</div>
						</li>
					<?php endforeach; ?>
					</ul>
					
					<div class="clearboth"></div>
				</div>
				<?php endif;?>
				
				<?php if ( isset( $users_common_friends ) ) :?>
				<div class="sidebar_widget">
					<h2>共同好友</h2>
					<ul>
					<?php foreach( $users_common_friends as $common_friend ) : ?>
						<li>
							<a href="<?=get_user_url( $common_friend['id'] );?>">
								<?=$common_friend['name'];?>
							</a>
						</li>
					<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>
				
				
				<!--人，关系-->
				<div class="sidebar_widget">
					<div class="kk_tabs user_relation_tabs">
						<ul class="tab_menu">
							<?php
								$ci =& get_instance();
								$ci->load->model('relation_model');
							?>
							<li>
								<a href="#user_friends">
									朋友(<?=$ci->relation_model->get_friends_count( $user['id'] );?>)
								</a>
							</li>
							<li>
								<a href="#user_fans" class="tipsy_s" title="拥趸,即是粉丝的意思,是fans的意译">
									拥趸(<?=$ci->relation_model->get_fans_count( $user['id'] );?>)
								</a>
							</li>
						</ul>
						
						<div id="user_friends" class="hidden tab_div">
							<?php
								$user_friends = $ci->relation_model->get_friends( $user['id'] );
								
								if ( !empty( $user_friends ) ) :
									foreach( $user_friends as $friend ):
							?>
								<a href="<?=site_url('user/'.$friend['id']);?>">
									<img height="18" src="<?=get_user_avatar_url($friend['id']);?>" />
									<?=get_user_name( $friend['nickname'], $friend['realname'] );?>
								</a>
							<?php
									endforeach;
								else:
							?>
								<div class="align_center grey">
									<b>还没有朋友</b>
								</div>
							<?php
								endif;
							?>
						</div>
						
						<div id="user_fans" class="hidden tab_div">
							<?php
								$user_fans = $ci->relation_model->get_fans( $user['id'] );
								if ( !empty( $user_fans) ) :
									foreach( $user_fans as $fan ):
							?>
							<a href="<?=site_url('user/'. $fan['id']);?>">
								
								<?=$fan['realname'];?>
							</a>
							<?php
									endforeach;
								else:
							?>
								<div class="align_center grey">
									<b>还没有粉丝...快叫朋友收藏你吧</b>
								</div>
							<?php
								endif;
							?>
						</div>
						
					</div>
				</div>
				
				