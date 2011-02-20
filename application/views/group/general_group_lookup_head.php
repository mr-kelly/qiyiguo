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
				  </h2>
				  

            	  <div class="lookup_relation_btn">
				  <?php
					  // 加入群组按钮
					  $this->load->view('group/general_join_group_view'); 
				  ?>
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
				  <p>
					  <?=$group['intro'];?>
				  </p>
				  <?php
					  endif;
				  ?>
				  
				  
				  
				
				<ul class="lookup_menu">
					<li>
						<a href="<?=site_url('group/' . $group['id']);?>" class="<?= isset($current_group_lookup_home) ? 'selected' : '' ; ?>">群首页</a>
					</li>
					<li><a href="<?=site_url('group/' . $group['id'] . '/topic');?>" class="<?= isset($current_group_lookup_topic) ? 'selected' : '' ; ?>">话题</a></li>
					<li><a href="<?=site_url('group/' . $group['id'] . '/event');?>" class="<?= isset($current_group_lookup_event) ? 'selected' : '' ; ?>">活动</a></li>
					<!--<li><a href="<?=site_url('group/' . $group['id'] . '/chat');?>" class="<?= isset($current_group_lookup_chat) ? 'selected' : '' ; ?>">聊天</a></li>-->
					<li><a href="<?=site_url('group/' . $group['id'] . '/stream');?>" class="<?= isset($current_group_lookup_stream) ? 'selected' : '' ; ?>">新闻台</a></li>
				</ul>
				
			  </div>