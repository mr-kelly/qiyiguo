

	<? //import_css('css/html.css');?>
	<? //import_css('css/decorator.css');?>
	<? //import_css('css/style.css');?>
	<?=import_js('js/app/chat/ajax_get_chats.js');?>
	<?php
		$chat_width = 480;  // 聊天框的长度 ~
	?>

		 <div class="chat_form_div">
			 <form class="chat_form" method="post" action="<?=site_url('chat/add/' . $model . '/'. $model_id . '?redirect=' . uri_string() );?>">
				 
				 <img class="avatar hidden chat_form_avatar" width="30" src="<?=get_user_avatar_url( get_current_user_profile('id') );?>" />
				 <textarea rows="1" class="no_scroll chat_content input_text" style="width:250px;" type="text" name="chat_content"></textarea>
				 <input type="hidden" name="chat_parent_id" value="0" />
				 
				 <button type="submit" class="hidden awesome small blue">回复</button>
				 
				 <div class="red target_message"></div>
				 
			 </form>
			 
		 </div>
		 
		 
								
		<?php foreach ( $chats as $key=>$chat ) :?>
			
			<li id="chat_<?=$chat['id'];?>" class="chat_item <?= ( $key % 2 == 0 ) ? 'odd' : '';?>" style="margin-left:<?=$chat['depth'] * 10;?>px; width: <?= $chat_width - $chat['depth'] * 10;?>px; ">
			
				<div class="chat_avatar">
					<a target="_top" href="<?=site_url( 'user/' . $chat['User']['id']);?>">
						<img class="avatar" width="30" src="<?=get_user_avatar_url($chat['User']['id']);?>" />
					</a>
				</div>
				
				<div class="chat_detail">


					
					<?php
						$ci =& get_instance();
						$ci->load->library('humanize');
					?>
					<span class="chat_date float_right">

						<?=$ci->humanize->datetime( $chat['created'] );?>
					</span>
					
					
					
					
					
					<a target="_top" href="<?=site_url( 'user/' . $chat['User']['id']);?>">
						<?=$chat['User']['name'];?>
					</a>
					
					
					
					<div class="chat_content">
						
						
						
						
						<?=$chat['content'];?>
						
						
					</div>
					<a href="#" class="chat_reply"> &nbsp;[回复↓]</a>
					

				</div>
				
					 <form class="hidden chat_form" method="post" action="<?=site_url('chat/add/' . $model . '/'. $model_id . '?redirect=' . uri_string() );?>">
						
						 <img class="avatar hidden chat_form_avatar" width="30" src="<?=get_user_avatar_url( get_current_user_profile('id') );?>" />
						 
						 <textarea rows="1" class="no_scroll input_text chat_content" style="width:200px;" type="text" name="chat_content"></textarea>
						 <input type="hidden" name="chat_parent_id" value="<?=$chat['id'];?>" />
						 <input type="hidden" class="chat_id" value="<?=$chat['id'];?>" />
						 
						 <button type="submit" class="hidden awesome small blue">回复</button>
						 
						 <div class="red target_message"></div>
						 
					 </form>

			</li>
			

		<?php endforeach; ?>
		
