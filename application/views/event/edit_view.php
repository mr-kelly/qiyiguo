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
					<form action="<?=site_url('event/edit/' . $event_id );?>" method="post">
						<p>
							<label>开始时间:</label>
							
							<?php 
								//年 
								$ci =& get_instance();
							?>
							<select class="birth_year" name="create_event_start_year">
								<?php
									$ci =& get_instance();
									// 用于年份选择，默认1990
									foreach( range(1990,intval(date('Y')) + 10 ) as $year ) :
								?>
								<option <?=( $year == $ci->humanize->get_year( $event['start'] ) ) ? 'selected="selected"' : '';?>><?=$year;?></option>
								<?php
									endforeach;
								?>
							</select>年
							
							<?php //月 ?>
							<select class="birth_select" name="create_event_start_month">
								<?php
									foreach( range(1,12) as $month ) :
								?>
								<option <?=( $month == $ci->humanize->get_month( $event['start'] )  ) ? 'selected="selected"' : '';?>><?=$month;?></option>
								<?php
									endforeach;
								?>
							</select>月
							
							<?php // 日 ?>
							<select class="birth_select" name="create_event_start_day">
								<?php
									foreach( range(1,31) as $day ) :
								?>
								<option <?=( $day == $ci->humanize->get_day( $event['start'] )  ) ? 'selected="selected"' : '';?>><?=$day;?></option>
								<?php
									endforeach;
								?>
							</select>日
							
							<!--
							<input class="datepicker event_date" type="text" name="create_event_start_date" value="<?=date('Y-m-d');?>" />
							-->
							
							<select class="event_time" name="create_event_start_hour">
								<?php foreach ( range(0,23) as $hour ) : ?>
									
									
									<option <?=( $hour == $ci->humanize->get_hour( $event['start'] ) ) ? 'selected="selected"' : '' ; ?> >
										<?=$hour;?>
									</option>
									
									
								<?php endforeach; ?>
							</select>
							:
							<select class="event_time" name="create_event_start_min">
								<?php foreach ( range(00,60) as $min ) : ?>
									<option <?=( $min == $ci->humanize->get_minute( $event['start'] ) ) ? 'selected="selected"' : '' ; ?> >
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
								<option <?=( $year == $ci->humanize->get_year( $event['end'] ) ) ? 'selected="selected"' : '';?>><?=$year;?></option>
								<?php
									endforeach;
								?>
							</select>年
							
							<?php //月 ?>
							<select class="birth_select" name="create_event_end_month">
								<?php
									foreach( range(1,12) as $month ) :
								?>
								<option <?=( $month == $ci->humanize->get_month( $event['end'] ) ) ? 'selected="selected"' : '';?>><?=$month;?></option>
								<?php
									endforeach;
								?>
							</select>月
							
							<?php // 日 ?>
							<select class="birth_select" name="create_event_end_day">
								<?php
									foreach( range(1,31) as $day ) :
								?>
								<option <?=( $day == $ci->humanize->get_day( $event['end'] ) ) ? 'selected="selected"' : '';?>><?=$day;?></option>
								<?php
									endforeach;
								?>
							</select>日
							
							
							<!--
							<input class="datepicker event_date" type="text" name="create_event_end_date" value="<?=date('Y-m-d');?>" />
							-->
							
							<select class="event_time" name="create_event_end_hour">
								<?php foreach ( range(0,23) as $hour ) : ?>
									
									
									<option <?=( $hour == $ci->humanize->get_hour( $event['end'] ) ) ? 'selected="selected"' : '' ; ?> >
										<?=$hour;?>
									</option>
									
									
								<?php endforeach; ?>
							</select>
							:
							<select class="event_time" name="create_event_end_min">
								<?php foreach ( range(00,60) as $min ) : ?>
									<option <?=( $min == $ci->humanize->get_minute( $event['end'] ) ) ? 'selected="selected"' : '' ; ?> >
										<?=$min;?>
									</option>
								<?php endforeach; ?>
							</select>
						</p>
						
						<p>
							<label>活动名称:</label>
							<input type="text" name="create_event_name" class="required" value="<?=$event['name'];?>" />				
						</p>
						
						<p>
							<label>活动内容:</label>
							<textarea class="input_textarea required" name="create_event_content"><?=$event['content'];?></textarea>
						</p>
						
						<div class="align_center">
							<button	type="submit" class="kk_btn">
								<span><span>创建</span></span>
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
						'group' => kk_get_group( $event['model_id'] ),
					));
					$this->load->view('sidebar/sidebar_group_view', array(
						'group' => kk_get_group( $event['model_id'] ),
					));
					
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
			</div>
		</div>
	</div>
	
	





<?php
	$this->load->view('footer_view');
?>	