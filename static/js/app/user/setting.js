$(function(){

	// 用户页 个性化主页网址前缀
	$user_home = 'qiyiguo.cc/u/';

	$('#submit_user_profiles_form').click(function(){
		$("#user_profiles_form").submit();
		return false;
	});
	
// 	$('#user_profiles_form').validate({
// 		submitHandler: function(form) {
// 			$('#user_profiles_form').ajaxSubmit({
// 				dataType: 'json',
// 				success: function(data) {
// 					if ( data.status == 1 ) {
// 						kk_growl.success(data.info);
// 						
// 						
// 						/**
// 						 * 个人网址设置页，  设置个人网址后，页面ui变化
// 						 	“当前个人网址”的链接href，text改成 用户设置后的slug
// 						 */
// 						$slug = $('#slug_input').val();
// 						
// 						// 如果没填slug, 抓取当前登录用户的ID
// 						if ( $slug == '' ) {
// 							$slug = $js_current_user_id;
// 						}
// 						
// 						
// 						$('#slug_a').text( $user_home + $slug )
// 									.attr('href', 'http://' + $user_home + $slug);
// 						
// 						
// 					} else {
// 						kk_growl.error(data.info);
// 					}
// 				}
// 			});
// 		},
// 		success: function(label) {
// 			label.text('').addClass('success');
// 		},
// 		rules: {
// 			slug: 'slug_validate' // slug不能为纯数字
// 		}
// 	});
// 	
// 	$.validator.addMethod("slug_validate", function(value) {
// 		// 正则表达式，如果是纯数字，返回false
// 		var $reg = /[\D\s]/;
// 		if ( value == '' ) {
// 			return true;
// 		} else if( !$reg.exec( value )) {
// 			return false; // 纯数字
// 		} else {
// 			return true;
// 		}
// 	}, '不能为纯数字!');

});