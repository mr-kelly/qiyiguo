

	<? //import_css('css/html.css');?>
	<? //import_css('css/decorator.css');?>
	<? //import_css('css/style.css');?>
	<?=import_js('js/app/chat/ajax_get_chats.js');?>
	<?php
		$ci =& get_instance();
		$chat_width = $ci->input->get('chat_width');
		if ( $chat_width == ''  ) {
			$chat_width = 520;   // 聊天框的默認长度 ~ 默认480
		}
	?>

		 <div class="chat_form_div">
			 <form style="margin: 0;" class="chat_form" method="post" action="<?=site_url('chat/add/' . $model . '/'. $model_id . '?redirect=' . uri_string() . '&chat_width=' . $chat_width );?>">
				 
				 <img class="avatar chat_form_avatar" width="30" src="<?=get_user_avatar_url( get_current_user_profile('id') );?>" />
				 <textarea rows="1" class="no_scroll chat_content input_text" style="width:220px;" type="text" name="chat_content"></textarea>
				 <input type="hidden" name="chat_parent_id" value="0" />
				 
				 <button type="submit" class="kk_btn" title="按下Ctrl+Enter快捷键回复">回复</button>
				 
				 <div class="red target_message"></div>
				 
			 </form>
			 
		 </div>
		 
		 
								
		<?php foreach ( $chats as $key=>$chat ) :?>
			
			<li id="chat_<?=$chat['id'];?>" class="chat_item <?= ( $key % 2 == 0 ) ? 'odd' : '';?> <?= ($chat['depth']==0)?'top_chat':'';?>" style="<?=( $chat['depth'] < 8 ) ? 'margin-left:' . $chat['depth'] * 10 : 'margin-left: 80px;';?>px; width: <?= ( $chat['depth'] < 8 ) ? $chat_width - $chat['depth'] * 10 : $chat_width - 80;?>px; ">
			
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
					
					<a href="#" class="chat_reply icon icon_reply">回复↓</a>

					<?php
						// 聊天层次太长了！！！ 提醒用户可以电邮他
						if ( $chat['depth'] > 8 ):
					?>
					<a class="chat_email icon icon_email" href="<?=site_url('mail?' . 'send_to=' . $chat['User']['id'] );?>" title="聊得起劲？发电邮给他吧">
						电邮他
					</a>
					<?php
						endif;
					?>
					
					<?php
						// chat的发布人。可以删除chat
						if ( $chat['user_id'] == get_current_user_id() ) :
					?>
						<a onclick="return delete_btn(this);" class="icon icon_delete chat_delete" href="#" ajax="<?=site_url('chat/ajax_delete_chat/' . $chat['id'] );?>">删除</a>
					<?php
						endif;
					?>
					

				</div>
				
					 <form class="hidden chat_form" method="post" action="<?=site_url('chat/add/' . $model . '/'. $model_id . '?redirect=' . uri_string() . '&chat_width=' . $chat_width );?>">
						
						 <img class="avatar chat_form_avatar" width="30" src="<?=get_user_avatar_url( get_current_user_profile('id') );?>" />
						 
						 <textarea rows="1" class="no_scroll input_text chat_content" style="width:180px;" type="text" name="chat_content"></textarea>
						 <input type="hidden" name="chat_parent_id" value="<?=$chat['id'];?>" />
						 <input type="hidden" class="chat_id" value="<?=$chat['id'];?>" />
						 
						 <button type="submit" class="kk_btn" title="按下Ctrl+Enter快捷键回复">回复</button>
						 
						 <div class="red target_message"></div>
						 
					 </form>

			</li>
			

		<?php endforeach; ?>
		
