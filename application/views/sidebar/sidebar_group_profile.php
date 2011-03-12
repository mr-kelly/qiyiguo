<!-- 
				<div class="align_center">
					<a class="kk_btn" href="<?=$_SERVER['HTTP_REFERER'];?>">返回上一页</a>
				</div>
 -->
				<div class="sidebar_widget">
					<div class="sidebar_profile">
						
						<div class="profile_img">
							<img width="50" src="<?=get_group_logo_url( $group['id'] );?>" />
						</div>
						
						
							<h3>
								<a href="<?= get_group_url( $group['id'] );?>">
									<?=$group['name'];?>
								</a>
							</h3>
							
							<div class="profile_detail">
								
								<div>
									<?php
										$ci =& get_instance();
										$ci->load->model('group_model');
									?>
									<?=$ci->group_model->get_group_users_count( $group['id'] );?>
									名成员
									
								</div>
								
								
							</div>
						
						<div class="clearboth"></div>
						
					</div>
				</div>