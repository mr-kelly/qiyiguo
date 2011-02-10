<?php
	// 此页用于ajax，所以需要在外面先读取js functions
	
	
	//$this->load->view('general/general_header_view');
?>
	<?=import_js('js/app/topic/ajax_add_topic.js');?>
	<?=import_js('js/kk.ajaxfileupload/ajaxfileupload.js');?>

	<div class="form_div">
		 <form class="topic_add_form" method="post" action="<?=site_url('topic/ajax_add_topic/' . $model . '/' . $model_id );?>">
		 
		 	 
			 <p>
				 <!--<label>标题</label>-->
				 <input class="hidden create_topic_title" type="text" name="title" />
				 <a class="create_topic_add_title_btn icon icon_change" title="你可以添加标题，将简短的发话变成一篇文章" href="#">
				 	添加标题
				 </a>
			 </p>
			 
			 <p>
				 <textarea id="content_editor" class="required create_topic_content" name="content"></textarea>

				 <!-- 添加的图片attach_id -->
				 <input type="hidden" name="attach_img_id" id="add_topic_attach_id" />
				 
			 </p>
			 
			 <p>
				 <a class="btn" href="#" onclick="return add_topic_submit();">
					 <span><span>&nbsp;发!&nbsp;</span></span>
				 </a>
				 
				 <script type="text/javascript">
				 	$(function(){
				 		$('#add_topic_pic_btn').click(function(){
				 			$('#add_topic_pic_input').trigger('click');
				 			
				 			return false;
				 		});
				 									// Change 有问题
				 		$('#add_topic_pic_input').change(function(){
							$.ajaxFileUpload({
							  url: '<?=site_url("topic/ajax_topic_upload_pic");?>',//服务器端程序
							  secureuri:false,
							  fileElementId:'add_topic_pic_input',//input框的ID
							  dataType: 'json',//返回数据类型
							  beforeSend:function(){//上传前需要处理的工作，如显示Loading...
							     alert('go?');
							  },
							  success: function (data, status){//上传成功
								if(data.status == 1){
									kk_growl.success( '话题图片上传！' );
									
									// 原图、缩略图
									$('#add_topic_pic_full').removeClass('hidden').fancybox().tipsy().attr('href', $attach_img_url + data.data.file );
									$('#add_topic_pic_thumb').attr( 'src', $attach_img_url + data.data.file_thumb );
								  	
									// 因为只能上传一张图片，所以上传一张之后，“上传图片”按键消失吧
									$('#add_topic_pic_btn').hide();
									
									// 设置topic表单~  以绑定topic与attach联系
									$('#add_topic_attach_id').val( data.data.attach_id );
									
								} else{
								  kk_growl.error('上传失败！');
								}
							  },
							  
							  error: function ( data, status ) {
							  	kk_growl.error( '无法上传～图片不能超过大小1MB' );
							  }
							});
						});
					 });
				 </script>
				 
				 
				 
				 
				 
				 <!--<a href="#" id="add_topic_pic">添加图片</a>-->
				 <!--<a href="#">附件</a>-->
			 </p>
		 </form>
		 
		 <div id="add_topic_pic_div">
		 
		 	<a id="add_topic_pic_btn" class="icon icon_add" href="javascript:void(0);">添加图片</a>
		 	
		 	<a id="add_topic_pic_full" class="sexybox hidden" href="#" title="查看大图">
			 	<img width="100" id="add_topic_pic_thumb" />
		 	</a>
		 	
			<?php // 话题图片 ?>
			<input id="add_topic_pic_input" type="file" size="45" name="userfile" style="visibility: hidden;position:absolute;">
			
		 </div>
		 

	 </div>

<?php
	//$this->load->view('general/general_footer_view');
?>