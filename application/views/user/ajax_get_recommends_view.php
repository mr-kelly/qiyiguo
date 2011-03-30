<div class="user_list_big">
<?php foreach( $recommend_users as $user ): ?>
	
	<div class="user">
		<div class="user_avatar_div">
			<img width="50" class="avatar" src="<?=get_user_avatar_url($user['id']);?>" />
		</div>
		<div class="user_name">
			<a href="<?=get_user_url($user['id']);?>"">
				<?=$user['name'];?>
			</a>
		</div>
		<div>
			<a onclick="return delete_btn(this);" class="icon icon_delete" ajax="<?=site_url('user/ajax_delete_recommend/' . $user['recommend_id'] );?>">
				删除
			</a>
		</div>
	</div>


<?php endforeach; ?>
</div>

<div class="clearboth"></div>