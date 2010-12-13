(function($){
    $.fn.center=function(settings){
        var style=$.extend({
                          position:'absolute',//absolute or fixed
                          top:'50%',            //50%即居中，将应用负边距计算，溢出不予考虑了。
                          left:'50%',
                          zIndex:2009,
                          relative:true        //相对于包含它的容器居中还是整个页面
                          }, settings || {});
        
        return this.each(function(){
                  var $this=$(this);
                  
                  if(style.top == '50%') style.marginTop=-$this.outerHeight()/2;
                  if(style.left == '50%') style.marginLeft=-$this.outerWidth()/2;
                  if(style.relative && !$this.parent().is('body') && $this.parent().css('position') == 'static')
                      $this.parent().css('position','relative');
                  delete style.relative;
                  //ie6
                  if(style.position == 'fixed' && $.browser.version=='6.0'){
                      style.marginTop += $(window).scrollTop();
                      style.position = 'absolute';
                      $(window).scroll(function(){
                                                    $this.stop().animate({
                                                                      marginTop:$(window).scrollTop()-$this.outerHeight()/2
                                                                      });
                                                    });
                  }
                  
                  $this.css(style);
                  });
    };
})(jQuery);






$(function() {
	
	
	
	// Ajax Loading
	$('#loading').ajaxStart(function(){
		$(this).show();
	}).ajaxSuccess(function(){
		$(this).fadeOut();
	});
	// Ajax Loading Error
	$('#loading_error').ajaxError(function(){
		
		$(this).show();
		$('#loading').hide();
		// 出现错误提示，5秒后自动关闭
		setInterval('$("#loading_error").fadeOut();', 5000);
	});
	
	// 菜单,子菜单伸缩处理
	$('.menu_item > a').mouseover(function() {
	
		// 判断是否为当前current_menu,是则不做动作
		if ( !$(this).parent().hasClass('current_menu')) {
			// 先隐藏目前显示的子菜单, 移除current_menu class
			// 遍历所有
			$('.menu_item').removeClass('current_menu');
			$(this).parent().addClass('current_menu');
			
			// 渐变效果
			$('.submenu').hide();
			$(this).next().fadeIn();
		}
	});
	

    // 登出按钮
    $('#logout_btn').click(function() {
        $.post($user_logout_action,function() {
            alert('您已经成功地登出~');
            location.reload();
        });
        return false;
    });

    // 登入按钮
    $('#login_btn').click(function() {
       $('#login_box').fadeIn();
       $('#user_login_login').focus();
       return false;
    });
	
	$('#login_tabs').tabs();
	
	
    // 注册按钮
    $('#register_btn').click(function() {
    	$('#register_box').fadeIn();
    	$('#user_register_email').focus();
       return false;
    });
    
    
    /**
     *	绑定日期设置控件
     */
	$('.datepicker').datepicker( {
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '1890:2012',
		monthNamesShort:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月']
	} );
    

    	/**
    	 *	全局设置， 城市、省份的自动变换
    	 */
    	$('.dict_province').change(function(){
  
    		
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
    				
    				$('.dict_city').html(select_cities);
    			}
    		);
    		
    	});
    	
    	
    	
    	
    	// 刷新iframe自适应高度， 配合jquery.iframeautoHeight
    	
     	$('iframe').load(function(){
     		$(this).height( $(this).contents().find('#iframe_div').height() + 10);
     	});
});



	/**
	 *	Session Message, 显示8秒后，消失
	 */
	timer = '';
	
	function session_message($message, $type) {
		clearInterval(timer);
		
		$(".session_message").html($message).slideDown().focus();
		
		timer = setInterval('$(".session_message").slideUp()', 8000);
	}
	
	function target_message( $target, $message, $type) {
	
		if ( $type == 'none' ) {
			$target.hide();
		} else {
			$target.html($message).show();
		}
		//clearInterval(timer);
		
		
		
		//timer = setInterval($target.slideUp(), 8000);
	}