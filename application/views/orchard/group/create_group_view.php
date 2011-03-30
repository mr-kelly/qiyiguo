<?php
	$this->load->view('orchard/orchard_header_view');
?>

<h2>创建自定义果群</h2>
<div class="form_div">
	<form method="post" action="<?=site_url('orchard/group/create_group');?>">
		<p>
			<label>果群ID</label>
			<input type="text" name="id" />
		</p>
		
		<p>
			<label>果群名</label>
			<input type="text" name="name" />
		</p>
		
		<p>
			<label>创始人ID</label>
			<input type="text" name="owner_id" />
		</p>
		
		<p>
			<label for="group_privacy">公开程度</label>

			<input onclick="$('#group_verify_p').hide();" id="group_privacy" type="radio" checked="checked" name="group_privacy" value="public" />公开
			<input onclick="$('#group_verify_p').show();" id="group_privacy" type="radio" name="group_privacy" value="private" />私密
		</p>
		
		<p id="group_verify_p" class="hidden">
			<label for="group_verify">加入方式</label>
			<select id="group_verify" name="group_verify" class="tipsy_nw" title="其他人加入你果群的方式">
				
				<option value="request">需要管理员审核加入</option>
				<option value="closed">不允许任何人加入</option>
				<? //<option value="everyone">任何人都可以直接加入</option>?>
			
			</select>
		</p>
		
		<p>
			<label for="group_category">果群种类</label>
			<select id="group_category" name="category_id">
			
			<?php foreach ($group_categories as $cat) {?>
				<option value="<?=$cat['id'];?>"><?=$cat['name'];?></option>
			<?php } ?>
			
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