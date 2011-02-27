				<?php if ( get_current_user_id() == $user['id'] ): ?>
				<div class="sidebar_widget">
					<form method="post" action="<?=site_url('user/ajax_add_mood');?>">
						<input name="mood_text" value="今天心情怎样？" />
						<input type="submit" />
					</form>
				</div>
				<?php endif; ?>
				
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
								//print_r( $user_friends );
								foreach( $user_friends as $friend ):
							?>
								<a href="<?=site_url('user/'.$friend['id']);?>">
									<img height="18" src="<?=get_user_avatar_url($friend['id']);?>" />
									<?=get_user_name( $friend['nickname'], $friend['realname'] );?>
								</a>
							<?php
								endforeach;
							?>
						</div>
						
						<div id="user_fans" class="hidden tab_div">
							<?php
								$user_fans = $ci->relation_model->get_fans( $user['id'] );
								foreach( $user_fans as $fan ):
							?>
							<a href="<?=site_url('user/'. $fan['id']);?>">
								
								<?=$fan['realname'];?>
							</a>
							<?php
								endforeach;
							?>
						</div>
						
					</div>
				</div>
				
				<div class="sidebar_widget">
					<h2>所在友群</h2>
					<p>
						加入的友群在这里
					</p>
				</div>
				
				<div class="sidebar_widget">
					<h2>他的好友</h2>
					<p>
						好友列表
					</p>
				</div>