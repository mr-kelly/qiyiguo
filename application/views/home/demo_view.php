<?php
	$this->load->view('header_view');
?>
	
	<?= import_css('css/app/home/demo.css');?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
			
				<div>
					
					<div>
						
						<img src="<?=static_url('img/howto_0.png');?>" />
						

					</div>
					
					
					
					<div class="demo_left">
						<img src="<?=static_url('img/howto_1.png');?>" />
						

						
						<div class="demo_content">
							<ul>
								<li>
									<a href="#">
										看看北师珠自强社怎样建立群组网络
									</a>
								</li>
								<li>
									<a href="#">
										看看北师珠赛扶怎样建立群组网络
									</a>
								</li>
							</ul>
						</div>
						
						<div class="clearboth"></div>
						
					</div>
					
					<div class="demo_left">
						<img src="<?=static_url('img/howto_2.png');?>" />
						
						<div class="demo_content">
							<ul>
								<li>
									<a href="#">
										看看金融一班和金融二班怎样建立班级关系
									</a>
								</li>
							</ul>
						</div>
					</div>
					
					
					<div class="demo_left">
						<img src="<?=static_url('img/howto_3.png');?>" />
						
						<div class="demo_content">
							<ul>
								<li>
									<a href="#">
										看看海华七栋宿舍楼的同学们怎样保持联系
									</a>
								</li>
							</ul>
						</div>
					</div>
					
					
					<div class="demo_left">
						<img src="<?=static_url('img/howto_4.png');?>" />
						
						<div class="demo_content">
							<ul>
								<li>
									<a href="#">
										看看老师们怎样利用奇异果高效工作
									</a>
								</li>
							</ul>
						</div>
					</div>
					
					
					
					
					<div class="demo_left">
						<img src="<?=static_url('img/howto_5.png');?>" />
						
						<div class="demo_content">
							<ul>
								<li>
									<a href="#">
										看看一群挚友们怎样用奇异果创造他们的生活
									</a>
								</li>
							</ul>
						</div>
					</div>
					
					
					
					<div class="demo_left">
						<img src="<?=static_url('img/howto_6.png');?>" />
						
						<div class="demo_content">
							<ul>
								<li>
									<a href="#">
										看看一个学生部门怎样利用奇异果组织工作
									</a>
								</li>
							</ul>
						</div>
					</div>
					
					
				</div>
				
				
				
				<div class="clearboth"></div>
				
				
				<div class="align_center">
					<div>
						如果你的群组也想成为奇异果的演示例子。<a href="<?=site_url('g/' . '10000');?>">&gt;请联系我</a>
					</div>
					
					<div>
						<a class="kk_btn" href="<?=site_url('page/about_why_qiyiguo');?>">
							奇异果来源
						</a>
					</div>
				</div>
				
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
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
			</div>
		</div>
	</div>


<?php
	$this->load->view('footer_view');
?>