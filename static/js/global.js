


/**
 *	判断用户是否已登录，没有转到登录页！
 */
function login_redirect() {

}
//alert( location.href );


// IE时，回到网页的top
function if_ie_to_top() {
	
	if ( navigator.userAgent.indexOf('MSIE') >= 0 ) {
		scroll( 0, 0);			
	}
}



/**
 *	控制jGrowl的显示
 */
var kk_growl = {
	error: function( $message ) {
		// 错误显示的jGrowl ( 短暂 )
		$.jGrowl( $message, { header: '<a class="icon icon_error"></a>' } );
		if_ie_to_top();

	},
	success: function ( $message ) {
		
		$.jGrowl( $message, { header: '<a class="icon icon_yes"></a>' } );
		if_ie_to_top();

	},
	session_message: function( $message ) {
		// 用于library Session Message。  持久显示
		$.jGrowl( $message, { sticky: true } );
		if_ie_to_top();

	},
	
	notice: function( $message, $header ) {

		$.jGrowl( $message , { sticky: true, header: '<span class="icon icon_notice">' + $header + '</span>' });
		
		if_ie_to_top();
	}
}




/**
 *	检查是否有新的提醒，  ( function , 配合下面的 )
 	并显示提醒
 */	
function notice_check() {



		$.getJSON( $get_user_notices_url + '&jsrand=' + Math.random(), function(json) {

			if ( json.status == 1 ) {
			
				//新消息提示
				//$('#sound').html('<iframe src="http://qiyiguo.cc/static/new_notice.mp3" name="Message" width="0" marginwidth="0" height="0" marginheight="0" scrolling="No"   frameborder="0" id="Message" border="0" framespacing="0" noresize="noResize"  vspale="0"> </iframe>');
				//$('#sound').html('<BGSOUND SRC="http://qiyiguo.cc/static/new_notice.mp3" LOOP="false" />');
				//$('#sound').html('<embed width="0" height="0" src="http://qiyiguo.cc/static/new_notice.mp3" />');
				
				data = json.data;
				//if ( data ) {
					for ( var key in data ) {
					
						// 提醒中的链接... 如果没有链接，不显示
						if ( data[key].link != '' ) {
							$link = '<a href="' + $site_url + 'notice/poke/' + data[key].id + '">...&gt;去看看</a>';
							
						} else {
							$link = '';
						}
						kk_growl.notice( '<div style="float:right;"><a href="' + $site_url + 'notice/poke/' + data[key].id + '"><img width="30" height="30" src="' + data[key].user_avatar_url + '" /></a></div>'
											+
											data[key].content + 
											$link, 
											data[key].title );
											
						
					}
					clearInterval( $notice_interval );

			}
			
		});
	//}
}

var $notice_interval = setInterval( 'notice_check()', 30000 );


$(function(){
	
	// 进入页面后，检查，是否有， 有 , 消灭计时器
	// 没有，让循环计时器启动
	// 循环过程中，检查到有提醒， 消灭计时器
	
	notice_check();
});









/**
 *	顶部搜索框...
 */
$search_input_tips_text = '搜索 / 群号 / 果号';
$(function(){
	$('.search_input').input_tips( $search_input_tips_text );
});

function search_submit_check( $this ) {
	
	if ( $($this).find('.search_input').val() == $search_input_tips_text
				 || $($this).find('.search_input').val() == '' ) {
				 
		return false;
	}
	
}

/**
 *	通用的ajax按钮...
 */
function ajax_btn( $this ) {

}


/**
 *	删除的ajax通用按钮...
 */
function delete_btn( $this, $redirect ) {
	if ( confirm( '确定?!') ) {
		$.getJSON( $($this).attr('ajax'), function(json) {
			if ( json.status == 1 ) {
				kk_growl.success( json.info );
				
				if ( $redirect ) {
					location.href= $redirect;
				} else {
					location.reload(); // 删除后刷新
				}
				
			} else {
				kk_growl.error( json.info );
			}
		});
	}
	
	return false;
}


$(function(){
	// Ajax 表单 通用
	$('.ajax_form').validate({
			submitHandler: function(form) {
				$('.ajax_form').ajaxSubmit({
					dataType: 'json',
					success: function(json) {
						if ( json.status == 1 ) {
							kk_growl.success(json.info);
							
							if ( json.data != null ) {
								// redirect
								window.location = json.data;
							}
							
						} else {
							kk_growl.error(json.info);
						}
					}
				});
			},
			success: function(label) {
				label.text('').addClass('success');
			},
			error: function() {
				alert('error');
			}
	});
	
	
});







$(function() {

	// PNG Fix
	//$('body').pngFix();
	
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
			
			// 滑动效果
			$('.submenu').hide();
			$(this).next().slideDown();
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
    				select_cities = '<option value="">不设置</option>';
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
    				select_cities = '<option value="">不设置</option>';
    				$.each(data.data, function(key, value){
    					//alert(value.city_name);
    					select_cities += '<option value="' + value.id + '">' + value.city_name + '</option>';
    				});
    				
    				$('.hometown_city').html(select_cities);
    		});
    	});
    	
    	
    	
    	
    	// 刷新iframe自适应高度， 配合jquery.iframeautoHeight
    	
//      	$('iframe').load(function(){
//      		$(this).height( $(this).contents().find('body').height() + 10);
//      	});
});



	/**
	 *	Session Message, 显示8秒后，消失
	 */
// 	timer = '';
// 	
// 	function session_message($message, $type) {
// 		clearInterval(timer);
// 		
// 		$(".session_message").html($message).slideDown().focus();
// 		
// 		timer = setInterval('$(".session_message").slideUp()', 8000);
// 	}
	
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
		 
// 		 $('#nav_btn').click(function(){
// 			$('.nav_content').toggle();
// 			
// 			return false;
// 		 });
		 
		 // 显示菜单~
		 $('#nav_btn').click(function(){
		 	
		 	$.getJSON( $(this).attr('href') );
		 	
		 	$('.nav_content').show();
		 	$('#nav_close').show();
		 	$(this).hide();
		 	
		 	return false;
		 });
		 
		 // 关闭导航菜单
		 $('#nav_close').click(function(){
		 	
		 	$.getJSON( $(this).attr('href') );
		 	
		 	$('.nav_content').hide();
		 	$('#nav_btn').show();
		 	$(this).hide();
		 	
		 	return false;
		 });
		 
		 
		 
		 //alert( document.body.clientWidth );
		 
		 // 根据屏幕分辨率默认显示导航菜单
// 		 if ( document.body.clientWidth >= 1140 ) {
// 		 	$('#nav_btn').trigger('click');
// 		 }
	});	 
	 
	 
//     var navigator = new StickyScroller( '#navigator' ,
//         {
//             start: 300,
//             end: 1800,
//             interval: 300,
//             range: 100,
//             margin: 100
//         });



/**
 *	用户的心情改变
 */
$(function(){
	$mood_text_tips = '今天心情怎样？';
	$('.mood_text').input_tips( $mood_text_tips );
	
});


function mood_form() {
	$('.mood_form').ajaxSubmit({
		dataType: 'json',
		beforeSubmit: function() {
			if ( $('.mood_text').val() == $mood_text_tips
					||　$('.mood_text').val() == ''　) {
					
				return false;
			}
		},
		success: function(json) {
			if ( json.status == 1 ) {
				kk_growl.success( json.info );
				$.fancybox.close();
				parent.location.reload();
				//setInterval( 'parent.location.reload()', 1000 );
			} else {
				kk_growl.error( json.info );
			}
		}
	});
	
	return false;
}