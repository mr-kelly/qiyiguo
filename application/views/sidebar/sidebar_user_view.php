		
				

				<div class="sidebar_widget">
					<h2>他的群</h2>
					<?php
						$this->load->view('group/general_groups_show', array(
							'groups' => $user_groups,
						));
					?>
					
					<div class="clearboth"></div>
					
					<div class="align_right">
						<a href="<?=site_url('user/user_groups/' . $user['id'] ); ?>">&gt;加入了<?=$user_groups_count;?>个群组</a>
					</div>
				</div>
				
				


				<?php if ( $users_common_groups ): ?>
				<div class="sidebar_widget">
					<h2>共同群组</h2>
					<?php
						$this->load->view('group/general_groups_show', array(
							'groups' => $user_groups,
						));
					?>
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
								<a href="#user_fans" class="tipsy_s" title="拥趸">
									粉丝(<?=$ci->relation_model->get_fans_count( $user['id'] );?>)
								</a>
							</li>
						</ul>
						
						<div id="user_friends" class="hidden tab_div">
							<?php
								$user_friends = $ci->relation_model->get_friends( $user['id'] );
								
								$this->load->view('sidebar/sidebar_users_list', array(
									'users' => $user_friends,
								));
								
								if ( empty( $user_friends ) ) :

							?>
								<div class="align_center grey">
									<b>还没有朋友..互相收藏成为朋友</b>
								</div>
							<?php
								endif;
							?>
						</div>
						
						<div id="user_fans" class="hidden tab_div">
							<?php
								$user_fans = $ci->relation_model->get_fans( $user['id'] );
								
								$this->load->view('sidebar/sidebar_users_list', array(
									'users' => $user_fans,
								));
								
								if ( empty( $user_fans) ) :
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
				
				