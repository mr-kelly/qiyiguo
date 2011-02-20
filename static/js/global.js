/**
 *	判断用户是否已登录，没有转到登录页！
 */
function login_redirect() {

}
//alert( location.href );


/**
 *	控制jGrowl的显示
 */
var kk_growl = {
	error: function( $message ) {
		// 错误显示的jGrowl ( 短暂 )
		$.jGrowl( $message, { header: '错误' } );
	},
	success: function ( $message ) {
		$.jGrowl( $message, { header: '成功' } );
	},
	session_message: function( $message ) {
		// 用于library Session Message。  持久显示
		$.jGrowl( $message );
	}
}



$(function() {
	//$.jGrowl('<img src="http://localhost:8888/kiwiguo/static/img/logo.png" />abc', { sticky: true });
	//$.jGrowl("A message with a header", { header: 'Important' });
	
	// jquery Tipsy生成
	$('.tooltip').tipsy( {   fade: true, live:true }); // gravity: $.fn.tipsy.auto ,
	
	// Tipsy Form表单提示～
	$('.tipsy_form [title]').tipsy( { trigger: 'focus', gravity: $.fn.tipsy.autoWE , fade: true } );
	
	// 控制东南西北的tipsy
	$('.tipsy_w').tipsy({ gravity: 'w' });
	$('.tipsy_e').tipsy({ gravity: 'e' });
	$('.tipsy_n').tipsy({ gravity: 'n' });
	$('.tipsy_s').tipsy({ gravity: 's' });
	$('.tipsy_nw').tipsy({ gravity: 'nw'});
	$('.tipsy_ne').tipsy({ gravity: 'ne'});
	$('.tipsy_sw').tipsy({ gravity: 'sw'});
	$('.tipsy_se').tipsy({ gravity: 'se'});
	
	
	// jquery idTabs 
	$('.kk_tabs > ul').idTabs();
	
	// Fancyboxx  -  I call it sexy box!  cool!
	$('.sexybox').fancybox();
	$('.sexybox_iframe').fancybox( {
		'type':'iframe',
		'scrolling': 'yes'
	});
	
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
//     $('#logout_btn').click(function() {
//         $.post($user_logout_action,function() {
//             // 直接登出ajax，然后刷新页面
//             location.reload();
//         });
//         return false;
//     });

    // 登入按钮
    $('#login_btn').click(function() {
       //$('#login_box').fadeIn();
       //$('#user_login_login').focus();
       return false;
    });
	
	//$('#login_tabs').tabs();
	
	
    // 注册按钮
    $('#register_btn').click(function() {
    	//$('#register_box').fadeIn();
    	//$('#user_register_email').focus();
       return false;
    });
    
    

    
    /**
     *	绑定日期设置控件
     */
// 	$('.datepicker').datepicker( {
// 		changeMonth: true,
// 		changeYear: true,
// 		dateFormat: 'yy-mm-dd',
// 		yearRange: '1890:2012',
// 		monthNamesShort:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月']
// 	} );
    

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
    	// 跟上面一样!!!!!!!   不过用于籍贯的  - 重复吧~
    	$('.hometown_province').change(function(){
    		$.get( $get_cities_url, { province_id: $(this).val() }, function( data ){
    				data = $.parseJSON(data);
    				
    				// 改变城市列表下拉菜单~
    				select_cities = '';
    				$.each(data.data, function(key, value){
    					//alert(value.city_name);
    					select_cities += '<option value="' + value.id + '">' + value.city_name + '</option>';
    				});
    				
    				$('.hometown_city').html(select_cities);
    		});
    	});
    	
    	
    	
    	
    	// 刷新iframe自适应高度， 配合jquery.iframeautoHeight
    	
     	$('iframe').load(function(){
     		$(this).height( $(this).contents().find('body').height() + 10);
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
	
	
	
	
	
	
	/*
	 *	导航菜单固定漂浮  Navigator
	 */
	 $(function(){
		 //$('#navigator').pozFixed();
		 
		 $('#nav_btn').click(function(){
			$('.nav_content').toggle();
			
			return false;
		 });
		 
		 //alert( document.body.clientWidth );
		 
		 // 根据屏幕分辨率默认显示导航菜单
		 if ( document.body.clientWidth >= 1140 ) {
		 	$('#nav_btn').trigger('click');
		 }
	});	 
	 
	 
//     var navigator = new StickyScroller( '#navigator' ,
//         {
//             start: 300,
//             end: 1800,
//             interval: 300,
//             range: 100,
//             margin: 100
//         });