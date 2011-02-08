<?php
	$this->load->view('general/general_header_view');
?>

<div class="left">
	<div class="form_div">
		 <form>
			 <p>
				 <label>标题</label>
				 <input type="text" name="title" />
			 </p>
			 
			 <p>
				 <label>正文</label>
				 <input type="text" name="content" />
			 </p>
			 
			 <p>
				 <a class="btn" href="#">
					 <span><span>&nbsp;发!&nbsp;</span></span>
				 </a>
			 </p>
		 </form>
	 </div>
</div>
<?php
	$this->load->view('general/general_footer_view');
?>