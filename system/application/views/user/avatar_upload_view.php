<?php $this->load->view('header_view'); ?>




<div id="content">
	<div class="content_top">
		<div class="content_bottom">

	
	
	<?php
		if ( isset($upload_data) ):
			// 用户按了上传并且文件上传成功, 显示图片裁剪界面
	?>
			<link rel="stylesheet" type="text/css" media="all" href="<?=static_url();?>js/jquery.imgareaselect/css/imgareaselect-animated.css" /> 
			<?=import_js('js/jquery.imgareaselect/scripts/jquery.imgareaselect.pack.js');?>
		
		
		
			<script>
				$(function(){
					// imgAreaSelect 上传后手工调整头像大小
					$('#upload_pic').imgAreaSelect({ 
						x1:0, y1:0, x2:480, y2:480, 
						aspectRatio: '1:1', 
						handles:true ,
						onSelectChange: function(img, selection) {
							var scaleX = 100 / (selection.width || 1);
							var scaleY = 100 / (selection.height || 1);
						  
							$('#avatar_pic').css({
								width: Math.round(scaleX * $('#upload_pic').attr('width') ) + 'px',  // 设置round值，令图片正常缩略显示
								height: Math.round(scaleY * $('#upload_pic').attr('height')) + 'px',
								marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
								marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
							});
						},
						onSelectEnd: function (img, selection) {
							$('input[name=x1]').val(selection.x1);
							$('input[name=y1]').val(selection.y1);
							$('input[name=x2]').val(selection.x2);
							$('input[name=y2]').val(selection.y2);            
						}
						
					});
				});
			</script>
		
		
			
			<?php // 头像显示，利用imgAreaSelect选择区域 ?>
			
			
			<div>
				<h2>拖动鼠标，选择要裁剪的部分</h2>
				<img id="upload_pic" src="<?=$avatar_url;?>" />
			
				<div style="float:right;overflow:hidden;position:relative;width:100px;height:100px;">
					<img id="avatar_pic" src="<?=$avatar_url;?>" />
				</div>
			</div>
			
			
			<?php // Crop，用户修剪 ?>
			<form action="<?=site_url('user/avatar_crop');?>" method="post">
			  <input type="hidden" name="x1" value="0" />
			  <input type="hidden" name="y1" value="0" />
			  <input type="hidden" name="x2" value="480" />
			  <input type="hidden" name="y2" value="480" />
			  <input type="hidden" name="avatar_file" value="<?=$upload_data['file_name'];?>" />
			  
			  <input type="submit" value="提交修改" />
			</form>
	<?php else: ?>
		
		<?php
			// 用户压根还没按上传！！显示上传组件
		?>
		
		<?=isset($page_message) ? $page_message : ''; ?>
		
		<?php // 上传控件 ?>
		<form action="<?=site_url('user/avatar_upload');?>" method="post" enctype="multipart/form-data">
			<input type="file" name="userfile" size="20" />
			
			<input type="submit" />
		</form>
	<?php
		endif;
	?>
	
	
		</div>
	</div>
</div><!-- End Content -->

<?php $this->load->view('footer_view'); ?>