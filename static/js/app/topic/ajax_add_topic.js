$(function(){

		
		
});

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

	// 预载KindEditor
	
		KE.init({
			id : 'content_editor',
			resizeMode : 1,
			allowPreviewEmoticons : false,
			allowUpload : false,
			filterMode: true,
			items : [
			'fontname', 'fontsize', '|', 'textcolor', 'bgcolor', 'bold', 'italic', 'underline',
			'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
			'insertunorderedlist', '|', 'emoticons', 'link'],
			htmlTags: {
					font : ['color', 'size', 'face', '.background-color'],
					span : ['style'],
					div : ['class', 'align', 'style'],
					table: ['class', 'border', 'cellspacing', 'cellpadding', 'width', 'height', 'align', 'style'],
					'td,th': ['class', 'align', 'valign', 'width', 'height', 'colspan', 'rowspan', 'bgcolor', 'style'],
					a : ['class', 'href', 'target', 'name', 'style'],
					embed : ['src', 'width', 'height', 'type', 'loop', 'autostart', 'quality',
			'style', 'align', 'allowscriptaccess', '/'],
					img : ['src', 'width', 'height', 'border', 'alt', 'title', 'align', 'style', '/'],
					hr : ['class', '/'],
					br : ['/'],
					'p,ol,ul,li,blockquote,h1,h2,h3,h4,h5,h6' : ['align', 'style'],
					'tbody,tr,strong,b,sub,sup,em,i,u,strike' : []
			},
			afterCreate : function(id) {
				KE.util.focus(id);
			}

		});
		
		
    // topic里的添加标题按钮
	/**
	 *	“发话”里的 转成文章 按钮
	 */
    $('.create_topic_add_title_btn').click(function(){
    
    	$('.create_topic_title').toggle();
    	return false;
    	
    }).toggle(function(){
    	// 按了添加标题后，令编辑器可视化编辑 （需要导入KindEditor)
    	KE.create('content_editor');
    	// 标题变成必填
    	$('.create_topic_title').addClass('required');
    }, function(){
    	KE.remove('content_editor');
    	$('.create_topic_title').removeClass('required');
    });
    

});




		/**
		 *		添加图片按钮， 添加图片的ajax处理
		 */
		 
		 $(function(){
		 	
			 $('#add_topic_pic_btn').click(function(){
				 $('#add_topic_pic_input').trigger('click');
				 
				 return false;
			 });
			
			// 添加附件按钮
			$('#add_topic_file_btn').click(function(){
				$('#add_topic_file_input').trigger('click');
				
				return false;
			});
			 
			 
		  });
		  
		  
		 // 话题图片上传控制
		 function ajax_pic_upload() {
			 $.ajaxFileUpload({
				 url: $topic_upload_pic_url, // '<?=site_url("topic/ajax_topic_upload_pic");?>',
				 fileElementId: 'add_topic_pic_input',
				 dataType: 'json',
				 success: function (data, status){//上传成功
				 
					 if(data.status == 1){
						 kk_growl.success( '话题图片上传！' );
						 
						 // 原图、缩略图
						 $('#add_topic_pic_full').removeClass('hidden').fancybox().tipsy().attr('href', $attach_img_url + data.data.file );
						 $('#add_topic_pic_thumb').attr( 'src', $attach_img_url + data.data.file_thumb );
						 
						 // 因为只能上传一张图片，所以上传一张之后，“上传图片”按键消失吧
						 $('#add_topic_pic_btn').hide();
						 
						 // 设置topic表单~  以绑定topic与attach联系
						 $('#add_topic_attach_img_id').val( data.data.attach_id );
						 
					 } else{
					   kk_growl.error('上传失败！?');
					 }
				},
			   
				error: function( data, status, e ) {
				  alert(e);
				  kk_growl.error( '无法上传～原因未知' );
				  
				  // 清空文件传输框
				  //$('#add_topic_pic_input').val('');
				  
				  
				}
				
			 });
		 }
		 
		 // 话题附件上传控制
		 function ajax_file_upload() {
			 $.ajaxFileUpload({
				 url: $topic_upload_file_url, // '<?=site_url("topic/ajax_topic_upload_pic");?>',
				 fileElementId: 'add_topic_file_input',
				 dataType: 'json',
				 success: function (json, status){//上传成功
				 
					 if(json.status == 1){
						 kk_growl.success( '附件上传成功！' );
						 
						 // 设置表单，绑定topic与文件attach_file关系，以便发布
						 $('#add_topic_attach_file_id').val( json.data.attach_id );
						 $('#add_topic_file_display').text( json.data.file_name ).addClass('icon');
						 
						 // 判断上传文件的后缀名，添加相应的class以显示图标
						 if  ( json.data.file_ext == '.doc' ) {
						 	$('#add_topic_file_display').addClass('icon_doc');
						 } else if ( json.data.file_ext == '.xls' ) {
						 	$('#add_topic_file_display').addClass('icon_xls');
						 } else if ( json.data.file_ext == '.zip' ) {
						 	$('#add_topic_file_display').addClass('icon_zip');
						 } else if ( json.data.file_ext == '.rar' ) {
						 	$('#add_topic_file_display').addClass('icon_rar');
						 } else if ( json.data.file_ext == '.ppt' ) {
						 	$('#add_topic_file_display').addClass('icon_ppt');
						 }
						 
						 // 原图、缩略图
// 						 $('#add_topic_pic_full').removeClass('hidden').fancybox().tipsy().attr('href', $attach_img_url + data.data.file );
// 						 $('#add_topic_pic_thumb').attr( 'src', $attach_img_url + data.data.file_thumb );
// 						 
// 						 // 因为只能上传一张图片，所以上传一张之后，“上传图片”按键消失吧
// 						 $('#add_topic_pic_btn').hide();
// 						 
// 						 // 设置topic表单~  以绑定topic与attach联系
// 						 $('#add_topic_attach_id').val( data.data.attach_id );
						 
					 } else{
					   kk_growl.error('上传失败！?不能超过1MB哦');
					 }
				},
			   
				error: function( data, status, e ) {
				  alert(e);
				  kk_growl.error( '无法上传～ 可能是文件太大了？如果超过1MB，请使用果邮群发给群成员。' );
				  
				  // 清空文件传输框
				  //$('#add_topic_pic_input').val('');
				  
				}
				
			 });
		 }