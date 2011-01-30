/**
 *	用户注册box 的JS代码， 包含输入框的回车按键处理，Ajax传递输入框参数
 */


    $(function() {
    	
    	
    	/** 
    	 *  绑定回车->Tab事件
    	 */ 
    	$("#user_register_email").keypress(function(e){
    		if (e.keyCode == 13) {
    			// 按下了回车，聚焦到下一个密码填空
    			$("#user_register_password").focus();
    		}
    	});
    	
    	
    	
    	
    	/** 
    	 *   输入密码后回车确认 ， 触发注册的单击按钮
    	 */
    	$("#user_register_password").keypress(function(e) {
    		if (e.keyCode == 13) {
    			$("#user_register_submit").trigger('click');
    		}
    		
    	});
    	
    	
    	
    	
    	/**
    	 *	城市、省份的自动变换
    	 */
    	$('#user_register_province_id').change(function(){
  
    		
    		// 选择省份，  显示省份的所有城市
    		// 获得目前选择的省份的城市列表， 通过GET上设置prov_id
    		
    		$.get(
    			$get_cities_url,
    			{ province_id: $(this).val() },
    			function(data){
    				//alert(data);
    				data = $.parseJSON(data);
    				
    				// 改变城市列表下拉菜单~
    				select_cities = '';
    				$.each(data.data, function(key, value){
    					//alert(value.city_name);
    					select_cities += '<option value="' + value.id + '">' + value.city_name + '</option>';
    				});
    				
    				$('#user_register_city_id').html(select_cities);
    			}
    		);
    		
    	});
    	
    	
    	
    	/**
    	 *	 按下确认注册的按钮
    	 */
        $("#user_register_submit").click(function(){
        
        
//             $.post($user_register_action,    用ajaxForm改写！
//                     {
//                         email:$('#user_register_email').val(),
//                         username:$('#user_register_username').val(),
//                         password:$('#user_register_password').val(),
//                         province_id: $('#user_register_province_id').val(),
//                         city_id: $('#user_register_city_id').val()
                        
                        //__hash__:$(this).next().val() // 表单令牌
//                     },
//                     function(data){
//                         eval("data = " + data);
//                         
//                         if (data['status'] == 1) {
//                         	session_message(data.info);
//                             window.location = $user_home;
//                             
//                         } else {
//                         	session_message(data.info);
//                         }
//             });
//             
			$('#user_register_form').submit();
            return false;
        });
        
		$('#user_register_form').ajaxForm({
			dataType: 'json',
			success: function(data){
				
				if ( data.status == 1) {
					session_message( data.info, 'normal');
					window.parent.location = $redirect;
				} else {
					session_message( data.info, 'error');
				}
			}
		});
    });