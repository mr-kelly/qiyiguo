$(function(){
		var $chat_form_input_tips = '说点什么...';
		$('.chat_form .chat_content').input_tips( $chat_form_input_tips );
		
		
		$('.chat_container').jscroll();
		// Focus  with BUG
		//$('.chat_form input[name=chat_content]').focus();
		
		$('.chat_form').keydown(function(e){
		
			// Ctrl + Enter
			if ( e.ctrlKey && e.which == 13 || e.which == 10) {
				$(this).submit();
				return false;
			}
			
		});
		
		/** 聚焦 chat输入框时， 框变大并显示“提交”按钮。   Textarea变身 */
		$('.chat_content').focus(function(){
			
			// 如果有“自动刷新”，关闭
			if ( typeof( $chat_refresh_switch ) != 'undefined' ) {
				clearInterval( $chat_refresh_switch );
			}
			
			
			
			$(this).attr('rows', '3');
			$(this).css('height', '40px');
			//$(this).nextAll('button[type=submit]').show(); // 自动隐藏
			//$(this).prevAll('.chat_form_avatar').show();
			
		}).blur(function(){
			
			// 如果定义了 chat刷新函数，那么令它自动刷新～  还有发布评论后
			if ( typeof( chat_refresh ) != 'undefined' ) {
				$chat_refresh_switch = setInterval( chat_refresh, $chat_refresh_time );
			}
			
			
			//$(this).attr('rows' ,'1');
			$(this).css('height', '15px');
			

			
			// 延迟取消提交按钮，否则用户按不到，就不见了
			// 自动隐藏
			//setTimeout('$("button[type=submit]").hide();$(".chat_form_avatar").hide();', 500);
			
		});
		
		
		$('.chat_form').submit(function(){
			
			// 判断用户有没有输入文字，如果为空，或者==input_tips文字，强迫令其 == tips, 不能提交成功
			if ( $(this).find('.chat_content').val() == $chat_form_input_tips ) {
				return false;//$(this).find('.chat_content').val('');
			}
			
			// 防重复提交
			$(this).find('button[type=submit]').attr('disabled','disabled');
			
			
			var $chat_id = $(this).find('.chat_id').val(); // 用于提交后聚焦
			var $chat_form = $(this);
			var $chats_container = $(this).parent().parent();//.nextAll('.chats_container');
			var $chats_container_scrollTop = $chats_container.scrollTop();
			
			$(this).ajaxSubmit({
				dataType: 'json',
				clearForm: true,
				success: function(data) {
					// 成功, 读取评论数据，隐藏错误提示信息
					if ( data.status == 1) {
						$chats_container.show().load( data.data.get_chats_url); // Ajax Random解决 IE Ajax缓存问题
						target_message( $chat_form.find('.target_message'), '', 'none');
						
						$('#chat_' + $chat_id).focus();
						
						
						// 发布评论后自动刷新~
						// 如果定义了 chat刷新函数，那么令它自动刷新～
						if ( typeof( chat_refresh ) != 'undefined' ) {
							$chat_refresh_switch = setInterval( chat_refresh, $chat_refresh_time );
						}
						
						
						// 设置滚动条位置在发布回复刚刚的位置
						//$chats_container.scrollTop( $chats_container_scrollTop );
					} else {
					
						// 失败， 出现提示信息
						target_message( $chat_form.find('.target_message'), data.info, 'normal');
					}
				}
			});
			
			
			
			
			$(this).find('button[type=submit]').removeAttr('disabled');
			
			return false;
		});
		
		
		/** 回复按钮, 层叠回复*/
		$('.chat_reply').click(function(){
		
			$(this).parent().nextAll('.chat_form').toggle().find('.chat_content').focus();
			
			return false;
		});


});