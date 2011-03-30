<?php
	$this->load->view('header_view');
?>	
	<?=import_js('js/kk.editor/kindeditor.js');?>
	
	
	<script>
		$(function(){
			// 预载KindEditor
	
			KE.init({
				id : 'content_editor',
				resizeMode : 1,
				allowPreviewEmoticons : false,
				allowUpload : false,
				filterMode: true,
				items : [
				'fontname', 'fontsize', '|', 'textcolor', 'bgcolor', 'bold', 'italic', 'underline',
				'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				'insertunorderedlist', '|', 'emoticons', 'link'],
				htmlTags: {
						font : ['color', 'size', 'face', '.background-color'],
						span : ['style'],
						div : ['class', 'align', 'style'],
						table: ['class', 'border', 'cellspacing', 'cellpadding', 'width', 'height', 'align', 'style'],
						'td,th': ['class', 'align', 'valign', 'width', 'height', 'colspan', 'rowspan', 'bgcolor', 'style'],
						a : ['class', 'href', 'target', 'name', 'style'],
						embed : ['src', 'width', 'height', 'type', 'loop', 'autostart', 'quality',
				'style', 'align', 'allowscriptaccess', '/'],
						img : ['src', 'width', 'height', 'border', 'alt', 'title', 'align', 'style', '/'],
						hr : ['class', '/'],
						br : ['/'],
						'p,ol,ul,li,blockquote,h1,h2,h3,h4,h5,h6' : ['align', 'style'],
						'tbody,tr,strong,b,sub,sup,em,i,u,strike' : []
				},
				afterCreate : function(id) {
					KE.util.focus(id);
				}
	
			});
			
			
			KE.create('content_editor');
			
		});
	</script>
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<div class="form_div">
					<form method="post" action="<?=site_url('topic/edit/' . $topic_id );?>">
						<div>
							<div>标题</div>
							<input style="width:90%" type="text" name="title" value="<?=$topic['title'];?>" />
						</div>
						
						<div>
							<label>内容</label>
							<textarea style="width:100%;height:300px;" id="content_editor" name="content"><?=$topic['content'];?></textarea>
							
						</div>
						
						<div class="align_center">
							<button class="kk_btn" type="submit" onclick="$('#loading').show();">
								修改
							</button>
						</div>
						
						
					</form>
				</div>
			</div>
		</div>
	</div>
	
	

	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php
					$this->load->view('sidebar/sidebar_group_profile', array(
						'group' => kk_get_group( $topic['model_id'] ),
					));
					$this->load->view('sidebar/sidebar_group_view', array(
						'group' => kk_get_group( $topic['model_id'] ),
					));
					
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
			</div>
		</div>
	</div>



<?php
	$this->load->view('footer_view');
?>	