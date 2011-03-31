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
						

						<!-- 

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
 -->
						
						<div class="clearboth"></div>
						
					</div>
					
					<div class="align_center">
						<h2>看看学生会和它的部门怎样建立群组网络</h2>
						<div>
							<embed src='http://player.youku.com/player.php/sid/XMjU1MDk2NjM2/v.swf' quality='high' width='480' height='400' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash'></embed>
						</div>
						
						<h2>群组连接的综合演示</h2>
						<div>
							<embed src='http://player.youku.com/player.php/sid/XMjU0NzQ5MDU2/v.swf' quality='high' width='480' height='400' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash'></embed>
						</div>
						
					</div>
					
					<div class="demo_left">
						<img src="<?=static_url('img/howto_2.png');?>" />
						
						<!--
						<div class="demo_content">
							<ul>
								<li>
									<a href="#">
										看看金融一班和金融二班怎样建立班级关系
									</a>
								</li>
							</ul>
						</div>
						-->
					</div>
					
					<div class="align_center">
						<h2>看看金融一班和金融二班怎样建立班级关系</h2>
						<div>
							<embed src='http://player.youku.com/player.php/sid/XMjU1MDk1Mjgw/v.swf' quality='high' width='480' height='400' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash'></embed>
						</div>
					</div>
					
					
					<div class="demo_left">
						<img src="<?=static_url('img/howto_3.png');?>" />
						
						<div class="demo_content">
							<ul>
								<li>
									<span>
										宿舍楼的同学们可建立 楼群、宿舍群，来组织DotA游戏
									</span>
								</li>
							</ul>
						</div>
					</div>
					
					
					<div class="demo_left">
						<img src="<?=static_url('img/howto_4.png');?>" />
						
						<div class="demo_content">
							<ul>
								<li>
									<span>
										老师们可以建立教务群，与学生分享知识和通知公告
									</span>
								</li>
							</ul>
						</div>
					</div>
					
					
					
					
					<div class="demo_left">
						<img src="<?=static_url('img/howto_5.png');?>" />
						
						<div class="demo_content">
							<ul>
								<li>
									<span>
										一群挚友们可以利用奇异果记录生活的点滴、分享美丽的人生
									</span>
								</li>
							</ul>
						</div>
					</div>
					
					
					
					<div class="demo_left">
						<img src="<?=static_url('img/howto_6.png');?>" />
						
						<div class="demo_content">
							<ul>
								<li>
									<span>
										学生部门可以利用奇异果管理、组织工作
									</span>
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