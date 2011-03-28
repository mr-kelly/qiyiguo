<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
			
			
			<h1>奇异果群组管理者使用协议</h1>
			
			<div class="align_center">
				<a onclick="window.close()" href="#" class="kk_btn">
					同意
				</a>
				
			</div>
			
			<h3>▶隐私声明</h3>
			<p>
				我们尊重您所建果群的隐私，并为此制定了相关的隐私保护条例来保护您所建果群的信息。但请您不要随意将重要的信息（如银行账号、密码等）在本站内公布。在您使用本网站服务前，请您浏览以下协议。
			</p>
			
			<h3>▶权利与义务</h3>
			<ul>
				<li>1. 必须同意本使用协议才能建立一个属于您的果群；</li>
			 	<li>2. 果群由您负责管理，群主应当对果群进行的所有活动和事件负法律责任；</li>
				<li>3. 您具有群组的信息管理权限，可以删除群组成员发出的话题、活动（不能未经他人同意下随意篡改）；</li>
			 	<li>4. 您具有群组的友情链接管理权限，可以添加、删除关系群组；对于其他群组的友情群组邀请有权斟酌添加；</li>
			 	<li>5. 您具有群组的成员管理权限，可以提升成员为管理员和驱逐成员出群；</li>
			 	<li>6. 您需要对群内进行适当的信息管理，对于虚假的、违法的、色情的及所有不利于网络健康发展的信息予以删除；</li>
			 	<li>7. 您不得滥用其管理权限在对方成员强烈不答应的情况下驱逐对方出群，但您有权利向奇异果网维护人员举报恶意分子。</li>
			</ul>
			
			
			<h3>▶使用声明</h3>
			<ul>
				<li>1. 请确保果群的登记使用信息的真实性；</li>
				<li>2. 本网站工作人员有权利对果群使用情况进行审查和监督；</li>
				<li>3. 若果群存在不法行为，本网站工作人权要求群主更正或采取一定措施。</li>
			</ul>
			
			<h3>▶免责条款</h3>
			<p>
				在如下情况下，本站将不对您的隐私泄露承担责任：
			</p>
			<ul>
			  
				  <li>1. 您同意让第三方共享资料；
				  <li>2. 群内信息出现非法集会、敏感政治问题、色情等不健康信息；
				  <li>3. 本站需要听从法庭传票、法律命令或遵循法律程序；
				  <li>4. 因黑客行为或用户的保管疏忽导致帐号、密码遭他人非法使用。
				  <li>5. 本站不担保一定能满足您的一切服务需要，不确保网络服务不会中断；
				  <li>6. 本站不担保站内信息的及时性、准确性、安全性。
			</ul>
			
			<h3>▶协议声明</h3>
			
			<p>本协议的解释权归珠海边度网络科技公司所有。</p>



  				
  				
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