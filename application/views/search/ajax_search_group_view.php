<?php if ( !empty( $group ) ) :?>
<div class="group">
	
	<img src="<?=get_group_logo_url( $group['id'] );?>" width="50" />
	<div><?=$group['name'];?></div>
	
	<a class="btn" href="#" onclick="return add_group_relation( $js_from_group_id, <?=$group['id'];?> );"><span><span>添加关系</span></span></a>
	
</div>

<?php else: ?>
	NO Groups
<?php endif; ?>

