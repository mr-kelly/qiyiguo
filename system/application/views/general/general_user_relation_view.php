            	<?php
            		// 未关注，显示关注按钮
            		$users_relation = get_user_relation( get_current_user_id(), $to_user_id );
            		if ( $users_relation == 'none' ):
            	?>
            	<a class="awesome tipsy_s" href="<?=site_url('relation/ajax_follow_user/' . $to_user_id );?>" title="关注他">
            		关注
            	</a>
            	<?php
            		//当前用户关注了，对方未关注
            		elseif ( $users_relation == 'follow' ):
            	?>
            	<a class="awesome red tipsy_s" href="<?=site_url('relation/ajax_unfollow_user/' . $to_user_id );?>" title="点击取消关注">
            		已关注
            	</a>
            	<?php
            		// 对方是你的 拥趸fans
            		elseif ( $users_relation == 'fans' ):
            	?>
            	<a class="awesome blue tipsy_s" href="<?=site_url('relation/ajax_follow_user/' . $to_user_id );?>" title="点击关注您的粉丝">
            		您的粉丝
            	</a>
            	<?php
            		// 互相关注，朋友
            		elseif ( $users_relation == 'mutual' ):
            	?>
            	<a class="awesome green tipsy_s" href="<?=site_url('relation/ajax_unfollow_user/' . $to_user_id );?>" title="取消关注，解除朋友关系">
            		朋友
            	</a>
            	<?php
            		endif;
            	?>