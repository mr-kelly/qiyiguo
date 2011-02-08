
<ul class="stream_container">
	<?php foreach ( $stream as $s ) : ?>
		<li class="stream_item">
			<div class="stream_avatar">
				<img width="30" height="30" src="<?=get_user_avatar_url( $s['stream_user']['id'] );?>?ajax=<?=rand();?>" />
			</div>
			
			<div class="stream_detail">
			
			
				<?php
					$ci =& get_instance();
					$ci->load->library('humanize');
				?>
				<span class="stream_date">
					<?=$ci->humanize->datetime( $s['stream_created'] );?>
				</span>
				
				
				
				<?=$s['stream_content'];?> - <?=$s['stream_user']['name'];?>
			</div>
		</li>			
	<?php endforeach; ?>
</ul>


<?php
	// 		参考·  微博
// 	 [0] => Array
//         (
//             [created_at] => Sat Sep 04 13:09:42 +0800 2010
//             [id] => 2297643652
//             [text] => Sina api via PHP try
//             [source] => <a href="http://t.sina.com.cn" rel="nofollow">鏂版氮寰崥</a> 
//             [favorited] => 
//             [truncated] => 
//             [in_reply_to_status_id] => 
//             [in_reply_to_user_id] => 
//             [in_reply_to_screen_name] => 
//             [geo] => 
//             [user] => Array
//                 (
//                     [id] => 1654692724
//                     [screen_name] => mrkelly_ghk
//                     [name] => mrkelly_ghk
//                     [province] => 44
//                     [city] => 4
//                     [location] => 骞夸笢 鐝犳捣
//                     [description] => 
//                     [url] => 
//                     [profile_image_url] => http://tp1.sinaimg.cn/1654692724/50/0
//                     [domain] => 
//                     [gender] => m
//                     [followers_count] => 7
//                     [friends_count] => 0
//                     [statuses_count] => 1
//                     [favourites_count] => 0
//                     [created_at] => Sun Oct 18 00:00:00 +0800 2009
//                     [following] => 
//                     [allow_all_act_msg] => 
//                     [geo_enabled] => 
//                     [verified] => 
//                 )
//  
//         )
?>