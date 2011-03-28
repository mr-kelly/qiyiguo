
<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>“奇异果”的来源</h2>
				
				<div class="align_center">
					
					<img src="<?=static_url('img/home_intro.png');?>" />
					
				</div>
				
				<p>
					2010年5月的某一天，来自北京师范大学珠海分校的“奇异果”团队以“图书输送到山区”和“人人都是慈善家”的理念，在广东金融学院获得了联想公益创业大赛的一等奖。
				</p>
				<p>
					就在回去珠海的路上，奇异果的创始人深思，我们的身边，各种各样的团队、学生组织、学校社团在奋斗着，然而，对于这样一群冉有激情的年轻人，却没有人一个简单而有效的网络工具为他们展示和管理。
				</p>
				
				<p>
					奇异果深知，看见了未来，就要去创造它。在接下来的10个月里，创始人度过了一次20年的人生之中最美妙的旅程：产品设计、编程开发、数据挖掘...... （当然之中少不了吃喝玩乐蒲）并将“<a target="_blank" href="http://kiwiguo.net">公益奇异果</a>”的网站界面和名字沿用过来： 「奇异果」希望将水果界的营养之王、维C之王带到现实生活中来，用营养去滋润现实生活中的每一个角落。
				</p>
				
				<p>
					这就是今天的奇异果： 
					<span style="text-decoration:underline;">
					帮助人们在网络上构建社团、组织、班级，并让群组、人之间互相联系。 
					你可以为你所在的社团、班级、朋友圈创建网络群组，邀请你的伙伴们，进来工作沟通、分享生活、课件上传、作业讨论，甚至组织活动、举办活动、看看哪些活动最有趣......
					</span>
				</p>
				
				<p>
					一个人来到世界的价值，并不在于他拥有了多少，而是在于他创造了多少。
					这也是奇异果人在今后最坚定的信念：将水果界的营养之王带到现实生活中，
					用创新为社会和人类创造最有价值的产品。
				</p>
				
				<p>
					祝你拥有最美丽的人生！ ... Mua！
				</p>
				

				<div class="align_center">
					<br />
					<br />
					
					<a href="<?=site_url('home/demo');?>" class="kk_btn tipsy_s" title="看看别人怎么使用奇异果的">
						&gt;范例演示
					</a>
					
					<a target="_blank" href="<?=site_url('g/qiyiguo');?>" class="kk_btn tipsy_s" title="到奇异果的官方果群提意见; 你也可以创造未来。">
						&gt;提意见
					</a>
					
					<a href="<?=site_url('page/recruit');?>" class="kk_btn">
						加入奇异果
					</a>
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
				
				<?php
					$this->load->view('sidebar/sidebar_jiathis');
				?>
				
				<div class="clearboth"></div>
				
			</div>
		</div>
	</div>
<?php
	$this->load->view('footer_view');
?>