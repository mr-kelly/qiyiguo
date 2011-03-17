<?php
	$this->load->view('header_view');
?>

<div id="content">
	<div class="content_top">
		<div class="content_bottom align_center">
			
			<h1 style="font-size:30px;color:#AAA;text-align:center;">
				&gt;_&lt; ... 私有群组
			</h1>
			
			<div>
				<div>
					<img width="100" src="<?=get_group_logo_url( $group['id'] );?>" />
				</div>
				
				<div>
					<h2 class="group_intro">
						<?=$group['name'];?> 
					</h2>
					
					<div>
						<?=kk_get_province_name( $group['province_id'] );?>
						<?=kk_get_city_name( $group['city_id'] );?>
					</div>
					
					<div class="group_intro grey">
						

						
						<div>
							<?=$group['intro'];?>
						</div>
						
						<div>
							(<?=$group_users_count;?>个成员)
						</div>
					</div>
				</div>
				
				<div>
					「<?=$group['name'];?>」成员才能进入查看
				</div>
				
				<div>
					<?php
						$this->load->view('group/general_join_group_view');
					?>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="sidebar">
	<div class="sidebar_top">
		<div class="sidebar_bottom">
			<?php
				$this->load->view('sidebar/sidebar_ad_pic');
			?>
		</div>
	</div>
</div>

<?php
	$this->load->view('footer_view');
?>