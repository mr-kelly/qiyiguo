	<?php
		// 该页面代码被 lookup_head 包围
	?>
			  <div class="lookup_avatar">
				  <a href="<?= get_group_logo_url( $group['id'] , 'big');?>" class="sexybox">
					  <img class="avatar" width="100" height="100" src="<?= get_group_logo_url( $group['id'] ); ?>" />
				  </a>
			  </div>
			  
			  <div class="lookup_easy_profile">
				  <h2>
					  <span class="icon icon_group tipsy_s" title="这是一个果群"></span>
					  <?=$group['name'];?>
					  
					  <span class="small grey">
					  	<?=$group['id'];?>
					  </span>
					  

				  </h2>
				  

            	  <div class="lookup_btn">
					  <span class="kk_btn_blue">
						<?= $group['privacy'] == 'public' ? '公开群' : '私密群';?>
					  </span>
				  
					  
					  <?php
								// 管理员判断...
							  if ( is_group_admin($group['id'], get_current_user_profile('id'))):
					  ?>
								 <span title="您是这群组的管理员" class="tipsy_s kk_btn_blue">管理员</span>
					  <?php
							  else:
								//不是管理员，是不是成员？  成员显示“已加入”
								
									// 如果是该群组的成员...显示 "已加入" 成员~
									if ( is_group_user( $group['id'], get_current_user_id() ) ):
							  ?>
										<span title="您是这群组的成员" class="kk_btn_blue tipsy_s">已加入</span>
					  
							  <?php
									endif;
							  ?>
					  <?php
							  endif;
					  ?>
					  
					  <span class="kk_btn_blue tipsy_s" title="<?=$group['page_view'];?>人看过">
						  人气: <?=$group['page_view'];?>
					  </span>
					  
					  
					  

				  </div>

				  <div>
				      <?php
				      	$ci =& get_instance();
				      	$ci->load->model('dict_model');
				      ?>
				      <?=$ci->dict_model->get_province_name( $group['province_id'] );?>
				      <?=$ci->dict_model->get_city_name( $group['city_id'] );?>
				      
				      

				  </div>
											
				  <?php
					  // 如果有果群简介
					  if ( isset( $group['intro'] ) ):
				  ?>
				  <div>
					  <?=$group['intro'];?>
				  </div>
				  <?php
					  endif;
				  ?>
				  
				  
				  
				
				<ul class="lookup_menu">
					<li>
						<a href="<?=site_url('group/' . $group['id']);?>" class="<?= isset($current_group_lookup_home) ? 'selected' : '' ; ?>">群首页</a>
					</li>
					<li><a href="<?=site_url('group/' . $group['id'] . '/topic');?>" class="<?= isset($current_group_lookup_topic) ? 'selected' : '' ; ?>">话题</a></li>
					<li><a href="<?=site_url('group/' . $group['id'] . '/event');?>" class="<?= isset($current_group_lookup_event) ? 'selected' : '' ; ?>">活动</a></li>
					
					<li class="<?= isset($current_group_lookup_intro) ? '' : 'hidden' ; ?>">
						<a href="<?=site_url('group/' . $group['id'] . '/intro');?>" class="<?= isset($current_group_lookup_intro) ? 'selected' : '' ; ?>">
							介绍
						</a>
					</li>
					
					<li class="<?= isset($current_group_lookup_relations) ? '' : 'hidden' ; ?>">
						<a href="<?=site_url('group/' . $group['id'] . '/relations');?>" class="<?= isset($current_group_lookup_relations) ? 'selected' : '' ; ?>">
							关系群组
						</a>
					</li>
					<!--<li><a href="<?=site_url('group/' . $group['id'] . '/chat');?>" class="<?= isset($current_group_lookup_chat) ? 'selected' : '' ; ?>">聊天</a></li>-->
					<!--<li><a href="<?=site_url('group/' . $group['id'] . '/stream');?>" class="<?= isset($current_group_lookup_stream) ? 'selected' : '' ; ?>">新闻台</a></li>-->
				</ul>
				
			  </div>