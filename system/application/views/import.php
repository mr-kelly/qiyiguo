    
    <? // jQuery ?>
    <script type="text/javascript" src="<?=static_url();?>js/lib/lib.js"></script>
    

    <script type="text/javascript" src="<?=static_url();?>js/css_fixed.js"></script> 
   
   
    <? // jQuery UI ?>
    <script type="text/javascript" src="<?=static_url();?>js/ui/js/jquery-ui-1.8.4.min.js"></script> 
    <link rel="stylesheet" type="text/css" media="all" href="<?=static_url();?>js/ui/css/cupertino/jquery-ui-1.8.4.css" />
    <!--<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/cupertino/jquery-ui.css" type="text/css" />-->
   
   
    <? // CSS ?>
    <link rel="stylesheet" type="text/css" media="all" href="<?=static_url();?>css/html.css" /> 
    <link rel="stylesheet" type="text/css" media="all" href="<?=static_url();?>css/decorator.css" /> 
    <link rel="stylesheet" type="text/css" media="all" href="<?=static_url();?>css/style.css" />


	<?php // CKEditor ?>
	<?=import_js('js/ckeditor/ckeditor_basic.js');?>
	<?//import_js('ckeditor/adapters/jquery.js');?>
	
	<? // jQuery Lightbox ?>
	<?=import_js('js/jquery-lightbox/js/jquery.lightbox-0.5.min.js');?>
	<?=import_css('js/jquery-lightbox/css/jquery.lightbox-0.5.css');?>
	
	<? // jQuery Form ?>
	<?=import_js('js/jquery.form.js');?>
	
	<? //jQuery input tips ?>
	<?=import_js('js/jquery.input_tips.js');?>
		
	<? // jQuery jSCroll 滚动条 ?>
	<?=import_js('js/jquery.jscroll.js');?>
	
	<? // jQuery iframe auto height ?>
	<?=import_js('js/jquery.iframeAutoHeight.js');?>
	
	<? // jQueryr pozFixed Position Fixed ?>
	<?=import_js('js/jquery.pozFixed.js');?>

	<? // jQueryr Center ?>
	<?=import_js('js/jquery.center.js');?>
	
	
	
	
	<? // jQuery Tipsy ?>
	<?=import_js('js/tipsy/jquery.tipsy.js');?>
	<?=import_css('js/tipsy/tipsy.css');?>
	
	<!-- jQuery Fancybox-->
	<?=import_js('js/fancybox/jquery.easing-1.3.pack.js');?>
	<?=import_js('js/fancybox/jquery.mousewheel-3.0.4.pack.js');?>
	
	<?=import_js('js/fancybox/jquery.fancybox-1.3.4.pack.js');?>
	<?=import_css('js/fancybox/jquery.fancybox-1.3.4.css');?>
	
	
	
	
	<? // jQuery Sticky Scroller ?>
	<? //import_js('js/StickyScroller.min.js');?>
	<? //import_js('js/GetSet.js');?>
	
	
	<?=import_js('js/global.js');?>
	
	
	<? // 简繁转换 ?>
	<?=import_js('js/tw_cn.js');?>
	
	
	
	<?php // jQuery Corner   not for IE?>
	<?php  if (strspn("MSIE",$_SERVER["HTTP_USER_AGENT"]) != 4 ): ?>
	
		<?=import_js('js/jquery.corner.js');?>
		<script>
			$(function(){
				$('img').corner('5px');
			});
		</script>
		
	<?php endif; ?>
	
	
	<script>
		$(function(){
			//$('body').jscroll();
		});
		
	</script>
