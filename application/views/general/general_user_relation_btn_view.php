			<div class="lookup_relation_btn">
            	<?php
            		// 未关注，显示关注按钮
            		$users_relation = get_user_relation( get_current_user_id(), $to_user_id );
            		if ( $users_relation == 'none' ):
            	?>
            	<a onclick="return user_relation_btn(this);" class="user_relation_btn kk_btn" href="<?=site_url('relation/ajax_follow_user/' . $to_user_id );?>" title="关注他">
            		收藏
            	</a>
            	<?php
            		//当前用户关注了，对方未关注
            		elseif ( $users_relation == 'follow' ):
            	?>
            	<a onclick="return user_relation_btn(this);" class="user_relation_btn kk_btn" href="<?=site_url('relation/ajax_unfollow_user/' . $to_user_id );?>" title="点击取消关注">
            		已收藏
            	</a>
            	<?php
            		// 对方是你的 拥趸fans
            		elseif ( $users_relation == 'fans' ):
            	?>
            	
            	<span title="他是你的拥趸(对方收藏了你)" class="tipsy_s kk_btn_blue">拥趸</span>
            	<a onclick="return user_relation_btn(this);" class="user_relation_btn kk_btn" href="<?=site_url('relation/ajax_follow_user/' . $to_user_id );?>" title="点击关注您的粉丝">
            		也收藏
            	</a>
            	<?php
            		// 互相关注，朋友
            		elseif ( $users_relation == 'mutual' ):
            	?>
            	<span title="你们是朋友(互相收藏)" class="tipsy_s kk_btn_blue">朋友</span>
            	<a onclick="return user_relation_btn(this);" class="user_relation_btn kk_btn" href="<?=site_url('relation/ajax_unfollow_user/' . $to_user_id );?>" title="取消关注，解除朋友关系">
            		解除朋友
            	</a>
            	<?php
            		endif;
            	?>
            	
            	<script type="text/javascript">
            		$(function(){
            			// Tipsy Them
            			//$('.user_relation_btn').tipsy();
            		});
            	</script>
            	

            	
			</div>