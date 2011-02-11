<div class="user_list_big">
<?php foreach( $recommend_users as $user ): ?>
	
	<div class="user">
		<div class="user_avatar_div">
			<img width="50" class="avatar" src="<?=get_user_avatar_url($user['id']);?>" />
		</div>
		<div class="user_name"><?=$user['name'];?></div>
	</div>


<?php endforeach; ?>
</div>

<div class="clearboth"></div>