<?php
	$this->load->view('orchard/orchard_header_view');
?>

<h2>创建自定义用户</h2>
<div>
	<form>
		<p>
			<label>果ID</label>
			<input type="text" name="id" />
		</p>
		
		<p>
			<label>电邮</label>
			<input type="text" name="email" />
		</p>
		
		<p>
			<label>密码</label>
			<input type="password" name="password">
		</p>
		
		
		
		<p>
			<button type="submit">确认</button>
		</p>
	</form>
</div>

<?php
	$this->load->view('orchard/orchard_footer_view');
?>