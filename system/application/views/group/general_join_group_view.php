
 <?php
	 $ci =& get_instance();
	 
	 // 群组加入、退出按钮
	 
	 
	 if ( $this->tank_auth->is_logged_in() ) { ?>
	 <!--<iframe iframeborder="0" src="<?=site_url('group/join_group/'.$group['id'])?>"></iframe>-->
 <?php } ?>
 
 <?php
	 // 点击加入后
	 // post 到ajax_join_group,
	 // 若返回错误
	 // 出现消息框，输入验证信息
	 
	 // 未加入
	 if ( !$ci->group_model->is_group_user($group['id'], get_current_user_profile('id')) ) {
	 
 ?>

 
 <?php
		 // 未加入，但在审核,显示审核中		
		 if ( $ci->request_model->is_request_group( $group['id'], $this->tank_auth->get_user_id() )) {
			 echo '审核中';
		 } elseif( $group['verify'] == 'closed' ) {
			 // 未加入，但该group拒绝加入，私密group
			 echo '拒绝加入';
			 
		 } else {
			 // 未加入，不在审核, 显示加入按钮
 ?>
			 <a class="medium blue awesome join_group_btn" href="<?=site_url("group/ajax_join_group/". $group["id"]);?>">
				 <span><span>加入</span></span>
			 </a>
			 
			 
			 <script>
				 $(function(){
					 $('.join_group_btn').click(function(){
						 $.post(
							 $(this).attr('href'),
							 {
								 message: $('#group_message').val()
							 },
							 function(data) {
								 alert(data);
								 data = $.parseJSON(data);
								 
								 if ( data.status == 0 ) {
									 // 返回失败，并且data提示信息为message，那么显示输入message
									 if ( data.data == 'message') {
										 $('#join_group_box').fadeIn();	
									 }
									 //alert($('#group_message').val());
								 }
								 
								 if ( data.status == 1 ) {
									 // 成功添加请求
									 window.location = '';
								 }
								 
						 });
						 return false;
					 });
				 });
			 </script>
 <?php
			 
		 }
	 } else {
		 // 已经加入该group
		 echo '已加入';
		 
		 if ($ci->group_model->is_group_admin($group['id'], get_current_user_profile('id'))):
 ?>
			 ,还是管理员<a href="<?=site_url('group/setting/'.$group['id']);?>">友群设置</a>
 <?php
		 endif;
	 }

 ?>
 