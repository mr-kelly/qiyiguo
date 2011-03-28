<ul class="groups_show">
<?php if ( !empty( $search_groups ) ) : ?>

	<?php foreach ( $search_groups as $search_group ) :?>
	<li class="group">
		<div>
			<img src="<?=get_group_logo_url( $search_group['id'] );?>" width="18" />

			<a target="_blank" href="<?=site_url('group/' . $search_group['id'] );?>"><?=$search_group['name'];?></a>

		
			<a class="kk_btn" href="#" onclick="return add_group_relation( $js_from_group_id, <?=$search_group['id'];?> );"><span><span>添加关系</span></span></a>
		</div>
		<div class="clearboth"></div>
		
	</li>
	<?php endforeach; ?>
	
<?php else: ?>
	找不到群
<?php endif; ?>

</ul>