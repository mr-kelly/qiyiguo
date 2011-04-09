<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1 style="font-size:30px;color:#AAA;text-align:center;">
					&gt;_&lt; 你不是这私密群组的成员
				</h1>
				
				<div style="height: 200px; margin-top:100px;" class="align_center">
					您必须是群组成员，才可以查看
				</div>
			</div>
		</div>
	</div>
	
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<h2>所属群组</h2>
				<?php
					$this->load->view('sidebar/sidebar_group_profile', array(
						'group' => $event['Group'],
					));
				?>
				
				<h2>组织者</h2>
				<?php
					$this->load->view('sidebar/sidebar_user_profile', array(
						'user' => kk_get_user( $event['user_id'] ),
					));
				?>
				
				<div class="align_center">
					<span class="kk_btn_blue">
						<?=$event['page_view'];?>人看过
					</span>
				</div>
				
				<?php
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
				
				<?php
					$this->load->view('sidebar/sidebar_jiathis');
				?>
			</div>
		</div>
	</div>
<?php
	$this->load->view('footer_view');
?>