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
				 <input type="hidden" name="attach_img_id" id="add_topic_attach_id" />

			 </p>
			 
			 <p>
				 <a class="btn" href="#" onclick="return add_topic_submit();">
					 <span><span>&nbsp;发!&nbsp;</span></span>
				 </a>
				 
				 <a id="" class="icon icon_add" href="javascript:void(0);">需要添加附件?</a>

				 
				 
				 
				 
				 
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
			<input onchange="ajax_upload()" id="add_topic_pic_input" type="file" size="45" name="userfile" style="visibility: hidden; position: absolute;">
			
		 </div>
		 

	 </div>
	 
</div>
<?php
	//$this->load->view('general/general_footer_view');
?>