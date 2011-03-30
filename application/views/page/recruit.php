
<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>活出你的未来 ── 在边度？在奇异果！</h2>
				<p>试试向别人说出这样的一句话： “我来自奇异果”。 这代表了什么？？</p>
				
				<ul>
					<li>“我来自奇异果，来自边度网络科技有限公司。”</li>
					<li>“我们不像OICQ那样，山寨ICQ”</li>
					<li>“我们不像校内网那样，山寨Facebook”</li>
					<li>“我们不像微博那样，山寨Twitter”</li>
					<li>“我们不像美团网那样，山寨Groupon”</li>
					<li>“我们用创新，铸造我们的人生”</li>
					<li>“我们是世界上第一个群组网络”</li>
					
					<li>“我们是一群有理想的人”</li>

				</ul>
				
				<p>
					不屈不挠地用创新与创造力去构建美丽人生。你，准备好了吗？
				</p>
				
				<h2>数据挖掘工程师</h2>
				<ul>
					<li>求真务实</li>
					<li>相信技术、相信算法能够改变生活</li>
					<li>MySQL</li>
					
				</ul>
				
				
				<h2>软件工程师</h2>
				
				<h2>前端工程师</h2>
				
				<h2>产品经理</h2>
				
				<h2>移动产品经理</h2>
				
				<h2>公关关系经理</h2>
				
				
			</div>
		</div>
	</div>
	
	
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php
					$this->load->view('sidebar/sidebar_group_profile', array(
						'group' => kk_get_group( 10000 ),
					));
				?>
			</div>
		</div>
	</div>
<?php
	$this->load->view('footer_view');
?>