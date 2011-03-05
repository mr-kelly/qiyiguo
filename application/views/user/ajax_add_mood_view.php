				<?php //if ( get_current_user_id() == $user['id'] ): ?>

					<form class="mood_form" method="post" action="<?=site_url('user/ajax_add_mood');?>">
						<input class="mood_text" name="mood_text" value="" />
						<a onclick="$('.mood_form').submit();return false;" type="submit" class="kk_btn" href="#">
							改心情
						</a>
					</form>

				<?php //endif; ?>
				
				<script>
					$(function(){
						$mood_text_tips = '今天心情怎样？';
						$('.mood_text').input_tips( $mood_text_tips );
						
						$('.mood_form').ajaxForm({
							dataType: 'json',
							beforeSubmit: function() {
								if ( $('.mood_text').val() == $mood_text_tips ) {
									return false;
								}
							},
							success: function(json) {
								if ( json.status == 1 ) {
									kk_growl.success('心情改变了');
									location.reload();
								} else {
									kk_growl.error('心情改变错误.未知');
								}
							}
						});
					});
				</script>