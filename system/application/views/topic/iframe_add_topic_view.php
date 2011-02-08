<?php
	$this->load->view('general/general_header_view');
?>

<div class="left">
	<div class="form_div create_topic_div">
		 <form method="post" action="<?=site_url('topic/ajax_create_topic/' . $model . '/' . $model_id );?>">
		 
		 	 
			 <p>
				 <!--<label>标题</label>-->
				 <input class="hidden create_topic_title" type="text" name="title" />
				 <a class="create_topic_add_title_btn icon icon_change" href="#">
				 	转成文章
				 </a>
			 </p>
			 
			 <p>
				 <!--<label>正文</label>-->
				 <textarea class="create_topic_content" name="content"></textarea>
			 </p>
			 
			 <p>
				 <a class="btn" href="#">
					 <span><span>&nbsp;发!&nbsp;</span></span>
				 </a>
				 <button type="submit">
				 	发~
				 </button>
			 </p>
		 </form>
	 </div>
</div>

<div style="height:10px;"></div>

<?php
	$this->load->view('general/general_footer_view');
?>