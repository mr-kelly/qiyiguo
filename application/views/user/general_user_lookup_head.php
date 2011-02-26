
					<div class="lookup_avatar">
						<a class="sexybox" href="<?=get_user_avatar_url( $user['id'], 'big' );?>">
							<img class="avatar" width="100" src="<?=get_user_avatar_url( $user['id'] );?>" />
						</a>

					</div>
					
					<div class="lookup_easy_profile">
						<h2>
							<span class="icon icon_user tipsy_s" title="这是一个人"></span>
							<?=get_user_name( $user['nickname'], $user['realname'] );?>
							<span class="small grey">
								&nbsp;&nbsp;果号:<?=$user['id'];?>
							</span>
						</h2>
						
						<div>
									<?php
										$ci =& get_instance();
										$ci->load->model('dict_model');
									?>
									所在地:  <?=$ci->dict_model->get_province_name( $user['province_id' ] );?> <?=$ci->dict_model->get_city_name( $user['city_id' ] );?>
									,
									籍贯: <?=$ci->dict_model->get_province_name( $user['hometown_province_id' ] );?> <?=$ci->dict_model->get_city_name( $user['hometown_city_id' ] );?>
									
									<a class="tipsy_s icon icon_email" href="<?=site_url('mail?' . 'send_to=' . $user['id'] );?>" title="向<?=$user['name'];?>发送电邮">发电邮</a>
						</div>
					</div>
					
					<ul class="lookup_menu">
						<li><a href="<?=site_url('user/'.$user['id']);?>" class="<?=isset($current_user_lookup_home) ? 'selected' : '';?>">个人主页</a></li>
						<li><a href="<?=site_url('user/' . $user['id'] . '/profile');?>" class="<?=isset($current_user_lookup_profile) ? 'selected' : '';?>">详细资料</a></li>
						<li><a href="<?=site_url('user/' . $user['id'] . '/chat');?>" class="<?=isset($current_user_lookup_chat) ? 'selected' : '';?>">聊天</a></li>
					</ul>
					
					<div class="lookup_relation_btn">
						<?php
							// Javascript在 user_lookup.js
							
							// 朋友关注
							$this->load->view('general/general_user_relation_btn_view', array('to_user_id'=>$user['id']));
						?>
						
					</div>