

							
							
$(function(){

		//显示，隐藏 评论（聊天）
		$('.chat_button').click(function(){
			//var load_href = $(this).attr('href');
			
			$(this).parent().nextAll('.chats_container').toggle();
			
			// 若聊天评论内容div， 要显示，读取
			if ( $(this).parent().nextAll('.chats_container').css('display') != 'none' ) {
				$(this).parent().nextAll('.chats_container').load( $(this).attr('href') );
				
			}
			
			// Chat Preview hide
			$(this).parent().nextAll('.chats_preview').hide();
			
			// 聚焦评论输入框
			
			
			
			return false;
		});
		
		
		// 点击“最近评论”的回复，相当于按了.chat_button
		$('.latest_chat_reply').click(function(){
			$(this).parent().parent().parent().prevAll('.topic_controller').find('.chat_button').trigger('click');
			
			return false;
		});



		
	});