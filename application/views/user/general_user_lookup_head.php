
					<div class="lookup_avatar">
						<a class="sexybox" href="<?=get_user_avatar_url( $user['id'], 'big' );?>">
							<img class="avatar" width="100" src="<?=get_user_avatar_url( $user['id'] );?>" />
						</a>

					</div>
					
					<div class="lookup_easy_profile">
						<h2>
							<span class="icon icon_user tipsy_s" title="这是一个人"></span>
							<?=get_user_name( $user['nickname'], $user['realname'] );?>
							<span class="small grey tipsy_s" title="果号">
								&nbsp;&nbsp;<?=$user['id'];?>
							</span>
						</h2>
						
						<div>
									<?php
										$ci =& get_instance();
										$ci->load->model('dict_model');
									?>
									
									<span class="icon icon_building">
										 <b>常住:</b> <?=$ci->dict_model->get_province_name( $user['province_id' ] );?> <?=$ci->dict_model->get_city_name( $user['city_id' ] );?>
									</span>
									
									
									<span class="icon icon_house">
										<b>籍贯:</b> <?=$ci->dict_model->get_province_name( $user['hometown_province_id' ] );?> <?=$ci->dict_model->get_city_name( $user['hometown_city_id' ] );?>
									</span>
									
									
									
						</div>
						
						<div class="user_mood">
							<span class="icon icon_mood">
								<b>心情:</b> <?=$user['mood'];?> <span class="grey small"><?= $ci->humanize->datetime( $user['mood_created'] );?></span>
								
								<?php if ( $user['id'] == get_current_user_id() ): //当前用户？提供修改 ?>
								<a class="sexybox" href="<?=site_url('user/ajax_add_mood');?>">[更改]</a>
								<?php endif; ?>
							</span>
						</div>
					</div>
					
					<ul class="lookup_menu">
						<li><a href="<?=site_url('user/'.$user['id']);?>" class="<?=isset($current_user_lookup_home) ? 'selected' : '';?>">个人主页</a></li>
						<li><a href="<?=site_url('user/' . $user['id'] . '/profile');?>" class="<?=isset($current_user_lookup_profile) ? 'selected' : '';?>">详细资料</a></li>
						<li><a href="<?=site_url('user/' . $user['id'] . '/chat');?>" class="<?=isset($current_user_lookup_chat) ? 'selected' : '';?>">聊天</a></li>
						
						<li class="<?= isset( $current_user_lookup_groups ) ? '' : 'hidden';?>">
							<a href="<?=site_url('user/' . $user['id'] . '/chat');?>" class="<?= isset( $current_user_lookup_groups ) ? 'selected' : '';?>">
								加入的果群
							</a>
						</li>
						
					</ul>
					
					<div class="lookup_btn">
						<span class="kk_btn_blue">
							人气: <?=$user['page_view'];?>
						</span>
						<?php
							// Javascript在 user_lookup.js
							
							// 朋友关注
							$this->load->view('general/general_user_relation_btn_view', array('to_user_id'=>$user['id']));
						?>
						
					</div>