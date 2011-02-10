	$topic_title_input_tip = '标题是什么?';
	$topic_content_input_tip = '想要写什么?';
	
	$('.create_topic_title').input_tips( $topic_title_input_tip );
	$('.create_topic_content').input_tips( $topic_content_input_tip );

    
    
    /**
     *	 Topic添加的 submit提交键~
     */
    function add_topic_submit(  ) {
    
    	// 没有填写？
		if ( $('.create_topic_title').val() == $topic_title_input_tip ) {
			$('.create_topic_title').val('');
		}
		if ( $('.create_topic_content').val() == $topic_content_input_tip ) {
			$('.create_topic_content').val('');
		}

    	// 绑定
		$('.topic_add_form').validate({
			submitHandler: function(form) {

				
				
				$('.topic_add_form').ajaxSubmit({
					dataType: 'json',
					success: function(data) {
						if ( data.status == 1 ) {
							kk_growl.success(data.info);
							// 成功提交后刷新
							location.reload();
						} else {
							kk_growl.error(data.info);
						}
					}
				});
			},
			success: function(label) {
				label.text('').addClass('success');
			}
		});
		
		// 绑定后提交
		$('.topic_add_form').submit();
		

		
		return false;
		
	}
	
	
	
$(function(){

//	$('.tipsy').tipsy();
    
    // topic里的添加标题按钮
	/**
	 *	“发话”里的 转成文章 按钮
	 */
    $('.create_topic_add_title_btn').tipsy().click(function(){
    	$(this).prev().toggle();
    	
    	return false;
    });

});