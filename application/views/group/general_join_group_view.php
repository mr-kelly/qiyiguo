<div class="lookup_relation_btn">
	<?php
	   $ci =& get_instance();
	   
	   // 群组加入、退出按钮
	   if ( $this->tank_auth->is_logged_in() ) : ?>
	   <!--<iframe iframeborder="0" src="<?=site_url('group/join_group/'.$group['id'])?>"></iframe>-->
	<?php endif; ?>
	
	
	
	
	
	<?php
	   // 点击加入后
	   // post 到ajax_join_group,
	   // 若返回错误
	   // 出现消息框，输入验证信息
	   
	   // 未加入
	   if ( ! is_group_user($group['id'], get_current_user_profile('id')) ) :
	   
	?>
	
	
	<?php
		   // 未加入，但在审核,显示审核中
	
		   if ( $ci->request_model->is_request_group( $group['id'], get_current_user_id() )) :
			   echo '审核中';
		   elseif ( $group['verify'] == 'closed' ) :
			   // 未加入，但该group拒绝加入，私密group
	?>
				<span title="管理员设置了禁止任何人申请加入群组" class="tipsy_s kk_btn_blue">禁止加入</span>
	<?php
		
			   
		   else:
			   // 未加入，不在审核, 显示加入按钮
	?>
			   <?php
				  //加入、关注按钮
				  // 如果群设置了
				  if ( $group['verify'] != 'request' ):
			   ?>
			   <a class="kk_btn join_group_btn" href="<?=site_url("group/ajax_join_group/". $group["id"]);?>">
			       <?= $group['privacy'] == 'public' ? '关注群' : '加入群'; ?>
			   </a>
			   <?php
			   	  else:
			   ?>
			   <a href="<?=site_url('group/ajax_request_join_group/' . $group['id'] );?>" class="kk_btn sexybox join_verify_btn">
				  加入群组验证信息
			   </a>
			   <?php 
			   	  endif;
			   ?>
			   
	
	<?php
			   
		   endif;
		   
	   else:
		   // 已经加入该group
	?>
	
		<a href="<?=site_url('group/ajax_join_group/' . $group['id'] .'/exit');?>" class="kk_btn join_group_btn">退出该群</a>
	  
	
	<?php
	   endif;
	
	?>
	
	  
			  <script>
				  $(function(){
					  $('.join_group_btn').click(function(){
						  //点击“加入”群组以后...
// 						  if ( !confirm( '确定要' + $(this).text() +'?' ) ) {
// 							  return false;
// 						  }
						  
						  $.getJSON( $(this).attr('href') + '?ajax=' + Math.random() , function(json) {
							  //alert(json);
							  if ( json.data == 'message' && json.status == 0 ) {
							  
								  // 弹出输入群组信息的窗口框
								  $('.join_verify_btn').trigger('click');
								  
							  } else if ( json.status == 1 ) {
							  
								  kk_growl.success( json.info );
								  
								  
								  
								  //if ( json.data == 'join' ) {
								      
								  //}
								  
								  //$('.lookup_relation_btn').load('<?=site_url("group/ajax_get_join_group_btn/" . $group["id"]);?>');
								  
								  //setInterval('location.reload();', 1000 );
								  location.reload();
								  
							  } else if ( json.status == 0 ) {
								  // 失败加入
								  kk_growl.error( json.info );
							  } else {
								  /**
								   *	出错了。有多种情况
										  其中一种...可能因为 用户退出了私有群组，再次按“加入”～
										  因为这时候系统已经不正常返回json，所以按了没反应的！
										  
								   */
								   location.reload();
							  }
						  });
						  
						  return false;
					  });
				  });
			  </script>
			  
	<?php
		if ( is_logged_in() ) :
			if ( is_group_user( $group['id'], get_current_user_id() )) :
	?>
	<a title="邀请朋友加入<?=$group['name'];?>" class="kk_btn tipsy_s" href="<?=site_url('group/group_invite/' . $group['id'] );?>">
	  邀请入群
	</a>
	<?php
			endif;
		endif;
	?>
	
	
</div>