
					<div class="lookup_avatar">
						<a class="sexybox" href="<?=get_user_avatar_url( $user['id'], 'big' );?>">
							<img class="avatar" width="100" src="<?=get_user_avatar_url( $user['id'] );?>" />
						</a>
						
						
						<?php
							// 如果用户查看自己
							if ( $user['id'] == get_current_user_id() ) :
						?>
							<form class="lookup_avatar_form" action="<?=site_url('user/avatar_upload/' . get_current_user_id() );?>" method="post" enctype="multipart/form-data">
								
								<input onchange="$('.lookup_avatar_form').submit();return false;" class="lookup_avatar_input" type="file" name="userfile" style="visibility:hidden;position:absolute;" />
								
							</form>
						
						<?php //if(strpos(  $_SERVER["HTTP_USER_AGENT"],'MSIE')) : ?>
						<a class="lookup_avatar_edit" href="<?=site_url('user/avatar');?>" title="修改群组的标志LOGO">
						<?php //else: ?>
						<!--<a class="lookup_avatar_edit" href="#" onclick="$('.lookup_avatar_input').trigger('click'); return false;" title="修改群组的标志LOGO">-->
						<?php //endif; ?>
							改头像
						</a>
						
	  
							
						<?php endif; ?>
					</div>
					
					<div class="lookup_easy_profile">
						<h2>
							<span class="icon icon_user tipsy_s" title="这是一个人"></span>
								<?=get_user_name( $user['nickname'], $user['realname'] );?>
							<span class="small grey tipsy_s" title="果号">
								&nbsp;&nbsp;<?=$user['id'];?>
							</span>
						</h2>
						
						<div class="profile_detail">
							<span class="icon tipsy_s <?= $user['gender'] == 'male' ? 'icon_boy' : 'icon_girl' ;?>" title="性别">
								<?= $user['gender'] == 'male' ? '男' : '女' ;?>
							</span>
							
									<?php
										$ci =& get_instance();
										$ci->load->model('dict_model');
									?>
									
									<span class="icon icon_building tipsy_s" title="常居地">
										 <!-- <b>常住:</b> --> <?=$ci->dict_model->get_province_name( $user['province_id' ] );?> <?=$ci->dict_model->get_city_name( $user['city_id' ] );?>
									</span>
									
									<?php if ( !empty ( $user['hometown_province_id' ] ) ) :?>
									<span class="icon icon_house tipsy_s" title="籍贯">
										<!-- <b>籍贯:</b> --> <?=$ci->dict_model->get_province_name( $user['hometown_province_id' ] );?> <?=$ci->dict_model->get_city_name( $user['hometown_city_id' ] );?>
									</span>
									<?php endif; ?>
									
									<?php if ( !empty( $user['age'] ) ) : ?>
									<span class="icon tipsy_s icon_age" title="年龄">
										<?=$user['age'];?>岁
									</span>
									<?php endif; ?>
									
									<?php if ( !empty( $user['constellation'] ) ) : ?>
									<span class="icon tipsy_s <?=kk_constellation_icon( $user['constellation'] );?>" title="星座">
										<!-- <b>星座:</b> -->
										<?=$user['constellation'];?>
									</span>
									<?php endif; ?>
									

							
							<?php
								// 爱情状态
								if ( !empty( $user['love_status'] ) ) : 
							?>
							<span class="tipsy_s icon icon_love" title="恋爱状态">
								<?php
									switch( $user['love_status'] ) {
										case 'single':
											echo '单身';
											break;
										case 'inlove':
											echo '恋爱中';
											break;
										case 'married':
											echo '已婚';
											break;
										case 'persue':
											echo '追求爱情中';
											break;
									}
								?>
							</span>
							<?php
								endif;
							?>
									
									
						</div>

						<?php 
							if ( !empty( $user['mood'] ) ) :
						?>
						<div class="user_mood profile_detail">
							<span class="icon icon_mood">
								<b>心情:</b> <?=$user['mood'];?> <span class="grey small"><?= $ci->humanize->datetime( $user['mood_created'] );?></span>
								
								<?php if ( $user['id'] == get_current_user_id() ): //当前用户？提供修改 ?>
								<a class="sexybox" href="<?=site_url('user/ajax_add_mood');?>">[更改]</a>
								<?php endif; ?>
								
							</span>
						</div>
						<?php
							else: //无心情？显示个人介绍.
						?>
						<div class="tipsy_s profile_detail profile_intro" title="自我介绍">
							<span class="icon icon_intro"></span>
								
							<?= kk_content_preview( $user['description'] );?>
							
								<?php if ( $user['id'] == get_current_user_id() ): //当前用户？提供修改 ?>
								<a class="sexybox" href="<?=site_url('user/ajax_add_mood');?>">[添加心情]</a>
								<?php endif; ?>
						</div>
						<?php
							endif;
						?>
						
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