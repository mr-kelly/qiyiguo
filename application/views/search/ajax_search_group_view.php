<ul class="sidebar_groups_list">
<?php if ( !empty( $search_groups ) ) : ?>

	<?php foreach ( $search_groups as $search_group ) :?>
	<li class="group">
		<div>
			<img src="<?=get_group_logo_url( $search_group['id'] );?>" width="50" />
		</div>
		<div>
			<a target="_blank" href="<?=site_url('group/' . $search_group['id'] );?>"><?=$search_group['name'];?></a>
		</div>
		
		<a class="btn" href="#" onclick="return add_group_relation( $js_from_group_id, <?=$search_group['id'];?> );"><span><span>添加关系</span></span></a>
		
		<div class="clearboth"></div>
		
	</li>
	<?php endforeach; ?>
	
<?php else: ?>
	NO Groups
<?php endif; ?>

</ul>