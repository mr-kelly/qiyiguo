<?php
	$this->load->view('general/general_header_view');
?>
<style>
	#search_main {
		text-align: center;
	}
	
	
	.search_box_div {
		margin: 10px 0 10px 0;
	}
	.search_btns {
		margin: 20px 0 50px 0;
	}
	
	#search_main #search_box {
		width: 400px;
		height: 25px;
		font-size: 14px;
		line-height: 25px;
		border-left: #CCC 1px solid;
		border-top: #CCC 1px solid;
		
		border-right: #999 1px solid;
		border-bottom: #999 1px solid;
		
	}
</style>

<script>
	$(function(){
		$('#search_box').focus().select();
	});
</script>


<div class="kk_tabs">
	<ul class="tab_menu">
		<li><a href="#search_main">搜索</a></li>
	</ul>
	
	<div id="search_main" class="tab_div">
		
		<form target="_parent" method="get" action="<?=site_url('search');?>">
		
			<div class="search_logo">
				<img height="50" src="<?=static_url('img/logo.png');?>" />
			</div>
			
			<div class="search_box_div">
				<input tabindex="1" id="search_box" type="text" name="q" value="朋友名字、果群名字、话题活动、朋友的果号、果群号" />
			</div>
			
			<div class="search_btns">
				<button type="submit" class="awesome">搜索</button>
				<button type="submit" class="awesome blue">搜朋友</button>
				<button type="submit" class="awesome green">搜果群</button>
			</div>
			
			
			
		</form>
	</div>
	
</div>

<?php
	$this->load->view('general/general_footer_view');
?>