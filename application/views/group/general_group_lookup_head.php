	<?php
		// 该页面代码被 lookup_head 包围
	?>
			  <div class="lookup_avatar">
				  <a href="<?= get_group_logo_url( $group['id'] , 'big');?>" class="sexybox">
					  <img class="avatar" width="100" height="100" src="<?= get_group_logo_url( $group['id'] ); ?>" />
				  </a>
				  
				  
				  <?php
					  // 如果当前用户是管理员，显示“修改”
					  if ( is_group_admin( $group['id'], get_current_user_id() )) :
				  ?>
					  <form class="lookup_avatar_form" action="<?=site_url('group/logo_upload/' . $group['id']);?>" method="post" enctype="multipart/form-data">
						  
						  <input onchange="$('.lookup_avatar_form').submit();return false;" class="lookup_avatar_input" type="file" name="userfile" style="visibility:hidden;position:absolute;" />
						  
					  </form>
					  
				  <a class="lookup_avatar_edit" href="#" onclick="$('.lookup_avatar_input').trigger('click'); return false;" title="修改群组的标志LOGO">
					  改标志
				  </a>
				  

					  
				  <?php endif; ?>
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
            	  	  <?php if (  $group['privacy'] == 'public' ) :;?>
					  
					  <span class="kk_btn_blue tipsy_s" title="所有人都可以进入查看这个群">
					      公开群
					  </span>
					  
					  <?php else: ?>
					  
					  <span class="kk_btn_blue tipsy_s" title="内部成员才能进入">
					      私密群
					  </span>
					  <?php endif; ?>
				  
					  
					  <?php
								// 管理员判断...
							  if ( is_group_admin($group['id'], get_current_user_profile('id'))):
					  ?>
								 <span title="您是群管理员" class="tipsy_s kk_btn_blue">管理者</span>
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

				  <div class="profile_detail">
				  
				  	  <?php
				  	  	if ( !empty( $group['city_id'] ) ): 
							$ci =& get_instance();
							$ci->load->model('dict_model');
				  	  		$province_name = $ci->dict_model->get_province_name( $group['province_id'] );
				  	  		$city_name = $ci->dict_model->get_city_name( $group['city_id'] );
				  	  ?>
				      <span class="icon icon_house tipsy_s" title="所在地: <?=$province_name;?> <?=$city_name;?>">

						  <?=$province_name;?>
						  <?=$city_name;?>
				      </span>
				      <?php endif; ?>
						
						
					  
					  <?php if ( !empty( $group['website'] ) ) : ?>

						  <span class="icon icon_website">
							  <b>网址:</b>
						  </span>
						  
						  <a target="_blank" href="<?= $group['website'];?>">
							  <?= $group['website'];?>
						  </a>

  				 	 <?php endif; ?>
  				 	 
  				 	 
  				 	 
				  </div>
				  

											
				  <?php
					  // 如果有果群简介
					  if ( isset( $group['intro'] ) ):
				  ?>
				  <div class="profile_detail">
				      <span class="icon icon_intro">
				          <?=$group['intro'];?>
				      </span>
					  
				  </div>
				  <?php
					  endif;
				  ?>
				  
				  
				  
				
				<ul class="lookup_menu">
					<li>
						<a href="<?=site_url('group/' . $group['id']);?>" class="<?= isset($current_group_lookup_home) ? 'selected' : '' ; ?>">群首页</a>
					</li>
					<li>
						<a href="<?=site_url('group/' . $group['id'] . '/topic');?>" class="<?= isset($current_group_lookup_topic) ? 'selected' : '' ; ?>">
							<?= $group['privacy'] == 'public' ? '话题' : '议论';?>
						</a>
					</li>
					<li>
						<a href="<?=site_url('group/' . $group['id'] . '/event');?>" class="<?= isset($current_group_lookup_event) ? 'selected' : '' ; ?>">
							<?= $group['privacy'] == 'public' ? '活动' : '任务';?>
						</a>
					</li>
					
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
					
					<li class="<?= isset($current_group_lookup_members) ? '' : 'hidden' ; ?>">
						<a href="<?=site_url('group/' . $group['id'] . '/relations');?>" class="<?= isset($current_group_lookup_members) ? 'selected' : '' ; ?>">
							成员列表
						</a>
					</li>
					<!--<li><a href="<?=site_url('group/' . $group['id'] . '/chat');?>" class="<?= isset($current_group_lookup_chat) ? 'selected' : '' ; ?>">聊天</a></li>-->
					<!--<li><a href="<?=site_url('group/' . $group['id'] . '/stream');?>" class="<?= isset($current_group_lookup_stream) ? 'selected' : '' ; ?>">新闻台</a></li>-->
				</ul>
				
			  </div>