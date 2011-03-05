<?php
	$this->load->view('orchard/orchard_header_view');
?>

<h2>创建自定义用户</h2>
<div class="form_div">
	<form method="post" action="<?=site_url('orchard/user/create_user');?>">
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
			<label>用户角色</label>
			<select name="role">
				<option value=" ">普通用户</option>
				<option value="editor">管理者</option>
				<option value="admin">最高管理员</option>
			</select>
		</p>
		
		
		<p>
			<button type="submit">确认</button>
		</p>
	</form>
</div>

<?php
	$this->load->view('orchard/orchard_footer_view');
?>