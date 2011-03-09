<?php
	// 此页用于ajax，所以需要在外面先读取js functions
	
	
	//$this->load->view('general/general_header_view');
?>
	<?=import_js('js/kk.ajaxfileupload/ajaxfileupload.js');?>
	<?=import_js('js/kk.editor/kindeditor.js');?>
	
	<?=import_js('js/app/topic/ajax_add_topic.js');?>

	
	
	

						
<div class="add_topic_div <?=isset( $hidden ) ? 'hidden' :'';?>">				
						
	<div class="form_div">
		 <form class="topic_add_form" method="post" action="<?=site_url('topic/ajax_add_topic/' . $model . '/' . $model_id );?>">
		 
		 	 
			 <p>
				 <!--<label>标题</label>-->
				 <input class="hidden create_topic_title" type="text" name="title" />
				 <a class="tipsy_w create_topic_add_title_btn icon icon_change" title="你可以添加标题，将简短的发话变成一篇文章" href="#">
				 	添加标题
				 </a>
			 </p>
			 
			 <p>
				 <textarea style="width:475px; height:150px;" id="content_editor" class="required create_topic_content" name="content"></textarea>

				 <!-- 添加的图片attach_id -->
				 <input type="hidden" name="attach_img_id" id="add_topic_attach_img_id" />
				 
				 <?php // 添加附件的attach_id ?>
				<input type="hidden" name="attach_file_id" id="add_topic_attach_file_id" />
			 </p>
			 
			 <p>
				 <a class="btn" href="#" onclick="return add_topic_submit();">
					 <span><span>&nbsp;发!&nbsp;</span></span>
				 </a>
				 
				 <a id="add_topic_file_btn" class="icon icon_add" href="javascript:void(0);">添加附件(小于1MB)</a>
				 
				 <?php // 上传文件成功后用于显示文件的标签 ?>
				 <span id="add_topic_file_display"></span>
				 
				 
				 
				 
				 
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
			<input onchange="ajax_pic_upload()" id="add_topic_pic_input" type="file" size="45" name="userfile" style="visibility: hidden; position: absolute;">
			
			<!--<form action="<?=site_url('topic/ajax_topic_upload_file');?>" enctype="MULTIPART/FORM-DATA" method="post">-->
				<?php // 话题 附件 ?>
				<input onchange="ajax_file_upload()" id="add_topic_file_input" type="file" size="45" name="userfile" style="visibility: hidden; position: absolute;">
				<!--<input type="submit" />-->
			<!--</form>-->
		 </div>
		 

	 </div>
	 
</div>
<?php
	//$this->load->view('general/general_footer_view');
?>