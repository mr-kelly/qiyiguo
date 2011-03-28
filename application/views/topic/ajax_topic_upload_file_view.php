<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>话题Ajax上传附件</title>
	<meta name="generator" content="BBEdit 9.6">
</head>
<body>

	<?php
		//上传图片后对 发送页 进行处理
	?>
	
	<?=import_js('js/lib/lib.js');?>
	
	
	<script>
		//parent.alert('ok now');
		
		// 设置topic表单~  以绑定topic与attach联系
		$(parent.document).find("#add_topic_attach_file_id").attr("value", '<?=$attach_id;?>');
		
		//$(parent.document).find('#add_topic_file_full').removeClass('hidden').attr('href', '<?=site_url("/static/upload/attach_img");?>' + '<?=$file;?>' );
		
		//$(parent.document).find('#add_topic_file_thumb').attr( 'src', '<?=site_url("/static/upload/attach_img");?>' + '<?=$file_thumb;?>' );
		
		$(parent.document).find('#add_topic_file_display').text( '<?=$file_name;?>' ).addClass('icon');
		
		// 扩展名判断，给予图标
		file_ext = '<?=$file_ext;?>';
		
		if  ( file_ext == '.doc' ) {
		   $(parent.document).find('#add_topic_file_display').addClass('icon_doc');
		} else if ( file_ext == '.xls' ) {
		   $(parent.document).find('#add_topic_file_display').addClass('icon_xls');
		} else if ( file_ext == '.zip' ) {
		   $(parent.document).find('#add_topic_file_display').addClass('icon_zip');
		} else if ( file_ext == '.rar' ) {
		   $(parent.document).find('#add_topic_file_display').addClass('icon_rar');
		} else if ( file_ext == '.ppt' ) {
		   $(parent.document).find('#add_topic_file_display').addClass('icon_ppt');
		} else if ( file_ext == '.pdf' ) {
		   $(parent.document).find('#add_topic_file_display').addClass('icon_pdf');
		}
		
		//$(parent.document).find('#add_topic_pic_btn').hide();
		//$(parent.document).find('#add_topic_pic_input').hide();
		
		//parent.alert('ok now');
		
	</script>
	upload ok


</body>
</html>
