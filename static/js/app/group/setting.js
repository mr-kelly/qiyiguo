$(function(){

	$('#group_setting_submit').click(function(){
		$('#group_setting_form').submit();
		return false;
	});
	
    	// 绑定

	$('#group_setting_form').validate({
			submitHandler: function(form) {
				$('#group_setting_form').ajaxSubmit({
					dataType: 'json',
					success: function(json) {
						if ( json.status == 1 ) {
							kk_growl.success(json.info);
							
							// 将页面显示的网址更改成修改后的网址..
							
							$('.group_url').attr('href', json.data.group_url )
											.text(json.data.group_url );
					
							
							
							
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


/**
 *	设置群组管理员的链接...
 */
function set_group_user( $this ) {
	
	$.getJSON( $($this).attr('href'), function(json) {
	
		if ( json.status == 1 ) {
			
			kk_growl.success( json.info );
			location.reload();
			
		} else {
			kk_growl.error( json.info );
		}
		
	});
	
	return false;
}


		