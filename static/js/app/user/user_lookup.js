
/**
 *	用户“关注”按钮～  ajax并获取html视图
 */
function user_relation_btn( $this ) {

	$.getJSON( $($this).attr('href'), function(json){
		if ( json.status == 1 ) {
			kk_growl.success( json.info );
			// 更改“关注”按钮的html视图
												// 需要先定义变量（非import）
			$('.lookup_relation_btn').load( $ajax_get_user_relation_btn_url ); // 变量需要定义 '<?=site_url("relation/ajax_get_user_relation_btn/" . $user['id'] );?>'
		} else {
			kk_growl.error( json.info );
		}
	});
	
	return false;
}