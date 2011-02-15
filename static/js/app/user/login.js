    $(function() {
    
    
    	/** 
    	 *  绑定回车->Tab事件
    	 */ 
    	$("#user_login_login").keypress(function(e){
    		if (e.keyCode == 13) {
    			// 按下了回车，聚焦到下一个密码填空
    			$("#user_login_password").focus();
    		}
    	});
    	
    	
    	
    	
    	/** 
    	 *   输入密码后回车确认 ， 触发注册的单击按钮
    	 */
    	$("#user_login_password").keypress(function(e) {
    		if (e.keyCode == 13) {
    			$("#user_login_submit").trigger('click');
    		}
    	});
    	
    
    
    
//         $("#user_login_submit").click(function(){
//             
//             $.post($user_login_action,
//                     {
//                         login:$('#user_login_login').val(),
//                         password:$('#user_login_password').val(),
//                         remember:$('#user_login_remember').val()
//                         //__hash__:$(this).next().val() // Form Hash
//                     },
//                     function(data){
//                         eval("data = " + data);
//                         
//                         
//                         if (data['status'] == 1) {
//                         	session_message(data.info,'normal');
//                             window.location = $redirect;
//                         } else {
//                         	session_message(data.info,'error');
//                         }
//             });
//             
//             return false;
//         });
	
	$('#user_login_submit').click(function(){
		$('#user_login_form').submit();
		return false;
	});
	
	
	// Validation + AjaxForm
	$('#user_login_form').validate({
		messages: {
			login: {
				required: '请输入你的注册电邮！',
				email: '电邮格式不对'
			},
			password: {
				required: '请输入密码!'
			}
		},
		
		submitHandler: function(form) {
			$('#user_login_form').ajaxSubmit({
				dataType: 'json',
				success: function(data){
				
					
					if ( data.status == 1) {
						kk_growl.success( data.info );
						window.parent.location = $redirect;
					} else {
						kk_growl.error( data.info );
						//session_message( data.info, 'error');
					}
				}
			});
		},
		success: function(label) {
			// 表单通过验证， 提供一个勾，代表填写正确
			label.text('').addClass('success');
		}
	});
	
// 	$('#user_login_form').ajaxForm({
// 		dataType: 'json',
// 		success: function(data){
// 		
// 			
// 			if ( data.status == 1) {
// 				session_message( data.info, 'normal');
// 				window.parent.location = $redirect;
// 			} else {
// 				jGrowl_Error( data.info );
// 				//session_message( data.info, 'error');
// 			}
// 		}
// 	});



    });