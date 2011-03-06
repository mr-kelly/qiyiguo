				<?php //if ( get_current_user_id() == $user['id'] ): ?>

					<form onsubmit="return mood_form();" class="mood_form" method="post" action="<?=site_url('user/ajax_add_mood');?>">
						<input class="mood_text" name="mood_text" value="" />
						<a onclick="$('.mood_form').submit();return false;" type="submit" class="kk_btn" href="#">
							改心情
						</a>
					</form>
					
					
					<script>
						$(function(){
							$mood_text_tips = '今天心情怎样？';
							$('.mood_text').input_tips( $mood_text_tips );
							
						});
					</script>
				<?php //endif; ?>
				
