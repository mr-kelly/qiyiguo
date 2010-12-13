<?php
/**
 *		if 注释
 
 		group的加入验证不为closed? 
 			user不属于group?
 				
 			user属于group?
 				是admin?
 					显示是管理员
 				不是admin?
 					显示已经加入
 		是closed?
 			显示不允许加入！
 
 
 user->group?
 	是
 		判断admin
 	不是
 		加入验证
 		
 
 */
            		$ci =& get_instance();
            		

            		
            		
            		
            		
            		// 如果为closed，不允许用户进入该友群
            		if ( $group['verify'] != 'closed' ) {
						
						
						if ( !$ci->group_model->is_group_user($group['id'], get_current_user_profile('id'))) {
							// 用户不属于该友群，显示相关
							// 检查是否正在验证请求列表
							if ( $ci->request_model->is_request_group($group['id'] , get_current_user_profile('id'))) {
								// 在验证中
								echo '验证中';
								
							} else {
								// 若不在验证中，压根没有加入小组，提供加入连接
					?>
								<a href="<?=site_url('group/join_group/'.$group['id'] . '/join');?>">申请加入友群</a>
					<?php
							}
					?>
							
					<?php
						} else {
							// 用户已属于该群组
							if ( $ci->group_model->is_group_admin($group['id'], get_current_user_profile('id'))) {
								echo '<p>你是管理员</p>';
							} else {
					?>
								<p>
									您已经加入该群
									<a href="<?=site_url('group/join_group/'.$group['id'] . '/exit');?>">
										(退出)
									</a>
								</p>
					<?php
							}
						}
					
					
					} else {
						// $group['verify'] == 'closed'  .....
						echo '不允许加入';
					}
            		
            		

            	?>
            	
            	