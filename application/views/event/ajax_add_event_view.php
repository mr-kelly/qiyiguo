		<?=import_js('js/kk.editor/kindeditor.js');?>
		
		<script>
			function event_add_form_submit() {
				// 绑定
				$('.add_event_form').validate({
					submitHandler: function(form) {
		
						
						
						$('.add_event_form').ajaxSubmit({
							dataType: 'json',
							success: function(data) {
								if ( data.status == 1 ) {
									kk_growl.success(data.info);
									
									
									// 成功提交后刷新
									location.reload();
								} else {
									kk_growl.error(data.info);
								}
							}
						});
					},
					success: function(label) {
						label.text('').addClass('success');
					}
				});
				
				$('.add_event_form').submit();
				
				return false;
			}
			
			$(function(){
				// 编辑器
				KE.init({
					id : 'event_editor',
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
				
				KE.create('event_editor');
			});
		</script>
		
		<div class="add_event_div form_div <?= isset( $hidden ) ? 'hidden' : '';?>">
			
			
			<div id="add_event_pic_div">
			   
			   <?php
				   // 如果是IE， 不通过js转接到“上传”控件, 只显示“添加图片”，让用户点击下面的“浏览”
				   if(strpos(  $_SERVER["HTTP_USER_AGENT"],'MSIE')
					   || strpos( $_SERVER["HTTP_USER_AGENT"],'Firefox') !== false ) :
			   ?>
				   <a id="add_event_pic_btn" class="icon icon_add">添加图片↓</a>
			   <?php
				   else:
			   ?>
				   <a onclick="$('#add_event_pic_input').trigger('click');return false;" id="add_event_pic_btn" class="icon icon_add" href="javascript:void(0);">添加图片</a>
			   <?php endif;?>
			   
			   <a id="add_event_pic_full" class="sexybox hidden" href="#" title="查看大图">
				   <img width="100" id="add_event_pic_thumb" />
			   </a>
			   
			   <?php // ajax 上传 话题图片 ?>
			   <form action="<?=site_url('event/ajax_event_upload_pic');?>" id="ajax_event_upload_pic_form" name="ajax_event_upload_pic_form" enctype="multipart/form-data" encoding="multipart/form-data" method="post" target="ajax_event_upload_pic_iframe">
				   
				   <?php 
					   // IE才显示“浏览” , 非IE的， hidden
				   ?>
				   <input value="添加图片" onchange="$('#ajax_event_upload_pic_form').submit();" id="add_event_pic_input" name="userfile" type="file" style="background:red;width:45px; <?= strpos(  $_SERVER["HTTP_USER_AGENT"],'MSIE') ? '' : 'visibility:hidden;position:absolute;';?>" />
				   <!--<input type="submit" />-->
				   
				   
				   <!--
				   <iframe id="ajax_event_upload_pic_iframe" name="ajax_event_upload_pic_iframe" class="hidden"></iframe>	
				   -->
				   
				   <iframe id="ajax_event_upload_pic_iframe" name="ajax_event_upload_pic_iframe" class="hidden"></iframe>	
			   </form>    <!--onchange="ajax_pic_upload()"-->
			   
		   </div><!-- END add_event_div -->
		   
			
			<form action="<?=site_url('event/ajax_create_event/' . $model . '/' . $model_id);?>" class="add_event_form" method="post">
				<? // 发表活动的群组 ?>
				
				<!--<input type="hidden" name="event_group_id" value="<?=$group['id'];?>" />-->
				
				<p>
					<label>开始时间:</label>
					
					<?php //年 ?>
					<select class="birth_year" name="create_event_start_year">
						<?php
							$ci =& get_instance();
							// 用于年份选择，默认1990
							foreach( range(1990,intval(date('Y')) + 10 ) as $year ) :
						?>
						<option <?=( $year == date('Y') ) ? 'selected="selected"' : '';?>><?=$year;?></option>
						<?php
							endforeach;
						?>
					</select>年
					
					<?php //月 ?>
					<select class="birth_select" name="create_event_start_month">
						<?php
							foreach( range(1,12) as $month ) :
						?>
						<option <?=( $month == date('m') ) ? 'selected="selected"' : '';?>><?=$month;?></option>
						<?php
							endforeach;
						?>
					</select>月
					
					<?php // 日 ?>
					<select class="birth_select" name="create_event_start_day">
						<?php
							foreach( range(1,31) as $day ) :
						?>
						<option <?=( $day == date('d') ) ? 'selected="selected"' : '';?>><?=$day;?></option>
						<?php
							endforeach;
						?>
					</select>日
					
					<!--
					<input class="datepicker event_date" type="text" name="create_event_start_date" value="<?=date('Y-m-d');?>" />
					-->
					
					<select class="event_time" name="create_event_start_hour">
						<?php foreach ( range(0,23) as $hour ) : ?>
							
							
							<option <?=( $hour == date('H') ) ? 'selected="selected"' : '' ; ?> >
								<?=$hour;?>
							</option>
							
							
						<?php endforeach; ?>
					</select>
					:
					<select class="event_time" name="create_event_start_min">
						<?php foreach ( range(00,60) as $min ) : ?>
							<option <?=( $min == date('i') ) ? 'selected="selected"' : '' ; ?> >
								<?=$min;?>
							</option>
						<?php endforeach; ?>
					</select>
					
					
				</p>
				
				<p>
					<label>结束时间:</label>
				
	
					<?php //年 ?>
					<select class="birth_year" name="create_event_end_year">
						<?php
							
							// 用于年份选择，默认1990 , 还有未来10年
							foreach( range(1990,intval(date('Y')) + 10 ) as $year ) :
						?>
						<option <?=( $year == date('Y') ) ? 'selected="selected"' : '';?>><?=$year;?></option>
						<?php
							endforeach;
						?>
					</select>年
					
					<?php //月 ?>
					<select class="birth_select" name="create_event_end_month">
						<?php
							foreach( range(1,12) as $month ) :
						?>
						<option <?=( $month == date('m') ) ? 'selected="selected"' : '';?>><?=$month;?></option>
						<?php
							endforeach;
						?>
					</select>月
					
					<?php // 日 ?>
					<select class="birth_select" name="create_event_end_day">
						<?php
							foreach( range(1,31) as $day ) :
						?>
						<option <?=( $day == date('d') ) ? 'selected="selected"' : '';?>><?=$day;?></option>
						<?php
							endforeach;
						?>
					</select>日
					
					
					<!--
					<input class="datepicker event_date" type="text" name="create_event_end_date" value="<?=date('Y-m-d');?>" />
					-->
					
					<select class="event_time" name="create_event_end_hour">
						<?php foreach ( range(0,23) as $hour ) : ?>
							
							
							<option <?=( $hour == date('H')+1 ) ? 'selected="selected"' : '' ; ?> >
								<?=$hour;?>
							</option>
							
							
						<?php endforeach; ?>
					</select>
					:
					<select class="event_time" name="create_event_end_min">
						<?php foreach ( range(00,60) as $min ) : ?>
							<option <?=( $min == date('i') ) ? 'selected="selected"' : '' ; ?> >
								<?=$min;?>
							</option>
						<?php endforeach; ?>
					</select>
				</p>
				
				<p>
					<label>活动名称:</label>
					<input type="text" name="create_event_name" class="required" />				
				</p>
				
				<p>
					<label>活动内容:</label>
					<textarea maxlength="200" style="width:475px; height:150px;"  id="event_editor" class="input_textarea required" name="create_event_content"></textarea>
				</p>
				
				 <!-- 添加的图片attach_id -->
				 <input type="hidden" name="attach_img_id" id="add_event_attach_img_id" />
				 
				
				<div class="align_left">
					<a onclick="return event_add_form_submit();" class="kk_btn" href="#">
						<span><span>创建</span></span>
					</a>
				</div>
				
			</form>

    	</div>
	</script>
	
<!--</div>-->