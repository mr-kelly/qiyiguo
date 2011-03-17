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
			// Form Key + Token
			// 防止跟前一次累加
			
			$('.form_key_token').val( $('.form_key').val() + $form_token );
			
			$('#user_register_form').submit();
            return false;
        });
        
        
        $('#user_register_form').validate({
        	submitHandler: function(form) {
				$('#user_register_form').ajaxSubmit({
					dataType: 'json',
					success: function(data){
						
						if ( data.status == 1) {
							kk_growl.success( data.info, 'normal');
							window.parent.location = $redirect;
						} else {
							kk_growl.error( data.info, 'error');
						}
					}
				});
        	},
        	success: function(label) {
        		label.text('').addClass('success');
        	}
        });

    });
