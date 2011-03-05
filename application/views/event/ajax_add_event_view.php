
		<script>
			$(function(){
				
			});
		</script>
		
		<div class="add_event_div form_div <?= isset( $hidden ) ? 'hidden' : '';?>">
			
			<?php
				//$datetime = getdate();
			?>
			
			<form action="<?=site_url('event/ajax_create_event/' . $model . '/' . $model_id);?>" id="create_event_form" method="post">
				<? // 发表活动的群组 ?>
				
				<!--<input type="hidden" name="event_group_id" value="<?=$group['id'];?>" />-->
				
				<p>
					<label>开始时间:</label>
					
					<?php //年 ?>
					<select class="birth_year" name="create_event_start_year">
						<?php
							$ci =& get_instance();
							// 用于年份选择，默认1990
							foreach( range(1890,intval(date('Y'))) as $year ) :
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
							
							// 用于年份选择，默认1990
							foreach( range(1890,intval(date('Y'))) as $year ) :
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
					<input type="text" name="create_event_name" />				
				</p>
				
				<p>
					<label>活动内容:</label>
					<textarea class="input_textarea" name="create_event_content"></textarea>
				</p>
				

				<a class="awesome small" href="#">创建</a>
				
				<input type="submit" />
			</form>
			
			
		</div><!-- END add_event_div -->
            	
	<script>
		//$(function(){
// 			$('.add_event_btn').click(function(){
// 				$('.add_event_div').toggle();
// 				return false;
// 			});
		//});
	
	</script>
	
<!--</div>-->