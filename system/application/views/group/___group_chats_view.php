<?php
	$this->load->view('import');
	foreach ( $chats as $chat ):
?>
	<div id="chat-<?=$chat['id'];?>" style="margin-left:<?=$chat['depth'] * 20;?>px">
		<?php if ( $chat['title'] != '' ): ?>
			<h2><?=$chat['title'];?></h2>
		<?php endif; ?>
		
		<p><?=$chat['User']['name'];?> : <?=$chat['content'];?></p>
		
		
		<form onsubmit="return false;" method="post" action="<?=site_url('chat/add/group/'.$group_id );?>">
			<textarea class="chat_content" name="chat_content"></textarea>
			<input class="chat_parent_id" type="hidden" name="chat_parent_id" value="<?=$chat['id'];?>" />
			<!-- <input type="submit" /> -->
			<a href="<?=site_url('chat/add/group/'.$group_id);?>" class="comment_btn awesome small" onclick="return false;">
				回复
			</a>
		</form>
		

		
		
		
	</div>
<?php
	endforeach;
?>

		<script>
			$(function(){
				$('.comment_btn').click(function(){
										// form
					chat_content = $(this).parent().find('.chat_content').val();
					chat_parent_id = $(this).parent().find('.chat_parent_id').val();
					$.post(
						$(this).attr('href'),
						{
							chat_content:chat_content,
							chat_parent_id:chat_parent_id
						},
						function(data) {
							data = $.parseJSON(data);
							alert(data.info);
						}
					);
				});
			});
		</script>