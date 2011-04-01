<?php
	// 此页用于ajax，所以需要在外面先读取js functions
	
	
	//$this->load->view('general/general_header_view');
?>
	<? //import_js('js/kk.ajaxfileupload/ajaxfileupload.js');?>
	
	<? //import_js('js/kk.uploadify/jquery.uploadify.v2.1.4.min.js');?>
	<? //import_js('js/kk.uploadify/swfobject.js');?>
	
	<?=import_js('js/kk.editor/kindeditor.js');?>
	
	<?=import_js('js/app/topic/ajax_add_topic.js');?>

	
	

<!-- 
<form target="ajax_topic_upload_pic_iframe" method="post" action="<?=site_url("topic/ajax_topic_upload_pic");?>"  enctype="multipart/form-data">
	<input name="userfile" type="file" />
	<input type="submit" onclick=" alert( $('#ajax_topic_upload_pic_iframe').document.html() );"/>
	
	<iframe id="ajax_topic_upload_pic_iframe" name="ajax_topic_upload_pic_iframe"></iframe>
	
</form>
 -->

<div class="add_topic_div <?=isset( $hidden ) ? 'hidden' :'';?>">				
						
	<div class="form_div">
		 <form class="topic_add_form" method="post" action="<?=site_url('topic/ajax_add_topic/' . $model . '/' . $model_id );?>">
		 
		 	 
			 <p>
				 <!--<label>标题</label>-->
				 <input class="hidden create_topic_title" type="text" name="title" />
				 <a class="tipsy_w create_topic_add_title_btn icon icon_change" title="你可以添加标题，将简短的发话变成一篇文章" href="#">
				 	添加标题(更多字数)
				 </a>
			 </p>
			 
			 <p>
				 <textarea maxlength="200" style="width:475px; height:150px;" id="content_editor" class="required create_topic_content" name="content"></textarea>

				 <!-- 添加的图片attach_id -->
				 <input type="hidden" name="attach_img_id" id="add_topic_attach_img_id" />
				 
				 <?php // 添加附件的attach_id ?>
				<input type="hidden" name="attach_file_id" id="add_topic_attach_file_id" />
			 </p>
		 </form>
		 
			 <p>

				 

				 
				 
			
				 <?php // 话题 附件 ?>
				 <form action="<?=site_url('topic/ajax_topic_upload_file');?>" id="ajax_topic_upload_file_form" name="ajax_topic_upload_file_form" enctype="multipart/form-data" encoding="multipart/form-data" method="post" target="ajax_topic_upload_file_iframe">
				 
					 <a class="kk_btn" href="#" onclick="return add_topic_submit();">
						 <span><span>&nbsp;确定发布&nbsp;</span></span>
					 </a>
					 
				<?php
					// 如果是IE， 不通过js转接到“上传”控件, 只显示“添加图片”，让用户点击下面的“浏览”
					if( strpos( $_SERVER["HTTP_USER_AGENT"],'MSIE') !== false
							|| strpos( $_SERVER["HTTP_USER_AGENT"],'Firefox') !== false ) :
				?>
					<a id="add_topic_pic_btn" class="icon icon_add tipsy_s"  title="可上传doc, xls,ppt, zip, rar文件，容量小于1MB">
						添加附件→
					</a>
				<?php
					else:
				?>
					 <a style="margin-left: 20px; " id="add_topic_file_btn" class="icon icon_add tipsy_s" href="javascript:void(0);" title="可上传doc, xls,ppt, zip, rar文件，容量小于1MB">
						添加附件
					 </a>
				 <?php endif;?>
				 
					 <input onchange="$('#ajax_topic_upload_file_form').submit();" id="add_topic_file_input" type="file" size="45" name="userfile" style="width:45px; <?= strpos(  $_SERVER["HTTP_USER_AGENT"],'MSIE') ? '' : 'visibility:hidden;position:absolute;';?>" />
					 

					 <iframe id="ajax_topic_upload_file_iframe" name="ajax_topic_upload_file_iframe" class="hidden"></iframe>	

					 <?php // 上传文件成功后用于显示文件的标签 ?>
					 <span id="add_topic_file_display"></span>
				 </form>
				 

				 
				 
			 </p>
		
		 
		 <div id="add_topic_pic_div">
		 	
		 	<?php
		 		// 如果是IE， 不通过js转接到“上传”控件, 只显示“添加图片”，让用户点击下面的“浏览”
				if(strpos(  $_SERVER["HTTP_USER_AGENT"],'MSIE')
					|| strpos( $_SERVER["HTTP_USER_AGENT"],'Firefox') !== false ) :
		 	?>
		 		<a id="add_topic_pic_btn" class="icon icon_add">添加图片↓</a>
		 	<?php
		 		else:
		 	?>
		 		<a onclick="$('#add_topic_pic_input').trigger('click');return false;" id="add_topic_pic_btn" class="icon icon_add" href="javascript:void(0);">添加图片</a>
		 	<?php endif;?>
		 	
		 	<a id="add_topic_pic_full" class="sexybox hidden" href="#" title="查看大图">
			 	<img width="100" id="add_topic_pic_thumb" />
		 	</a>
		 	
			<?php // ajax 上传 话题图片 ?>
			<form action="<?=site_url('topic/ajax_topic_upload_pic');?>" id="ajax_topic_upload_pic_form" name="ajax_topic_upload_pic_form" enctype="multipart/form-data" encoding="multipart/form-data" method="post" target="ajax_topic_upload_pic_iframe">
				
				<?php 
					// IE才显示“浏览” , 非IE的， hidden
				?>
				<input value="添加图片" onchange="$('#ajax_topic_upload_pic_form').submit();" id="add_topic_pic_input" name="userfile" type="file" style="background:red;width:45px; <?= strpos(  $_SERVER["HTTP_USER_AGENT"],'MSIE') ? '' : 'visibility:hidden;position:absolute;';?>" />
				<!--<input type="submit" />-->
				
				<iframe id="ajax_topic_upload_pic_iframe" name="ajax_topic_upload_pic_iframe" class="hidden"></iframe>	
				
			</form>    <!--onchange="ajax_pic_upload()"-->
			
			
			
			
			

			
		 </div>
		 

	 </div>
	 
</div>
<?php
	//$this->load->view('general/general_footer_view');
?>