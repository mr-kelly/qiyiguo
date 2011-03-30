<?php
	$this->load->view('header_view');
?>
	<?=import_js('js/app/topic/general_topics_list.js');?>
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>我的话题</h1>
				
				<h2>我发布的话题</h2>
				<?php
				$this->load->view('topic/general_topics_showlist', array(
						'topics' => $user_topics,
					));
				?>
				
				<h2>我的群话题</h2>
				<div class="grey">
					&gt;我所加入的群组的最新话题
				</div>
				
				<?php
					kk_pagination( $start, $my_topics_count,  $per_page );
					$this->load->view('topic/general_topics_list', array(
						'topics' => $user_groups_topics,
						'show_group_logo' => true,
					));
				?>
			</div>
		</div>
	</div>
	
	
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php
					$this->load->view('sidebar/sidebar_user_profile', array(
						'user' => kk_get_user( get_current_user_id() ),
					));
					
					$this->load->view('sidebar/sidebar_user_view', array(
						'user' => kk_get_user( get_current_user_id() ),
					));
					
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
			</div>
		</div>
	</div>
<?php
	$this->load->view('footer_view');
?>