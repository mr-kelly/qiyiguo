
				
				
				
				
				
				
				
$(function(){


    // “发话” 按钮
    //$add_topic_btn_switch = 0; // 开关， 如果1（开），按发话，读取load; 如果0（关），按发话，隐藏、显示
//     $('.add_topic_btn').click(function(){
//     	$('.add_topic_div').toggle();
// //     	if ( $add_topic_btn_switch == 1 ) {
// //     		$('.add_topic_div').load( $js_url_ajax_add_topic ).show();
// //     		
// // 			$add_topic_btn_switch = 0;
// //     	} else {
// //     		$('.add_topic_div').toggle();
// //     	}
//     	return false;
//     });
    
    
    
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