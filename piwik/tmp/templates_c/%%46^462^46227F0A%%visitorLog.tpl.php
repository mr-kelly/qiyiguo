<?php /* Smarty version 2.6.26, created on 2011-03-02 13:11:46
         compiled from Live/templates/visitorLog.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'translate', 'Live/templates/visitorLog.tpl', 3, false),array('modifier', 'capitalize', 'Live/templates/visitorLog.tpl', 60, false),array('modifier', 'escape', 'Live/templates/visitorLog.tpl', 69, false),array('modifier', 'count', 'Live/templates/visitorLog.tpl', 98, false),array('modifier', 'truncate', 'Live/templates/visitorLog.tpl', 110, false),array('function', 'cycle', 'Live/templates/visitorLog.tpl', 32, false),)), $this); ?>
<div class="home" id="content" style="display: block;">
<a graphid="VisitsSummarygetEvolutionGraph" name="evolutionGraph"></a>
<h2><?php echo ((is_array($_tmp='Live_VisitorLog')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
</h2>
<div id="<?php echo $this->_tpl_vars['properties']['uniqueId']; ?>
" class="visitorLog">

<?php if (isset ( $this->_tpl_vars['arrayDataTable']['result'] ) && $this->_tpl_vars['arrayDataTable']['result'] == 'error'): ?>
		<?php echo $this->_tpl_vars['arrayDataTable']['message']; ?>

	<?php else: ?>
		<?php if (count ( $this->_tpl_vars['arrayDataTable'] ) == 0): ?>
		<a name="<?php echo $this->_tpl_vars['properties']['uniqueId']; ?>
"></a>
		<div class="pk-emptyDataTable"><?php echo ((is_array($_tmp='CoreHome_ThereIsNoDataForThisReport')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
</div>
		<?php else: ?>
			<a name="<?php echo $this->_tpl_vars['properties']['uniqueId']; ?>
"></a>

	<table class="dataTable" cellspacing="0" width="100%" style="width:100%;">
	<thead>
	<tr>
	<th style="display:none"></th>
	<th id="label" class="sortable label" style="cursor: auto;width:12%" width="12%">
	<div id="thDIV"><?php echo ((is_array($_tmp='General_Date')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
<div></th>
	<th id="label" class="sortable label" style="cursor: auto;width:13%" width="13%">
	<div id="thDIV"><?php echo ((is_array($_tmp='General_Visitors')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
<div></th>
	<th id="label" class="sortable label" style="cursor: auto;width:15%" width="15%">
	<div id="thDIV"><?php echo ((is_array($_tmp='Live_Referrer_URL')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
<div></th>
	<th id="label" class="sortable label" style="cursor: auto;width:62%" width="62%">
	<div id="thDIV"><?php echo ((is_array($_tmp='General_ColumnNbActions')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
<div></th>
	</tr>
	</thead>
	<tbody>

<?php $_from = $this->_tpl_vars['arrayDataTable']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['visitor']):
?>
	<tr class="label<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td style="display:none;"></td>
	<td class="label" style="width:12%" width="12%">

				<strong><?php echo $this->_tpl_vars['visitor']['columns']['serverDatePretty']; ?>
 - <?php echo $this->_tpl_vars['visitor']['columns']['serverTimePretty']; ?>
</strong>
				<?php if (! empty ( $this->_tpl_vars['visitor']['columns']['ip'] )): ?> <br/>IP: <?php echo $this->_tpl_vars['visitor']['columns']['ip']; ?>
<?php endif; ?>
				<?php if (( isset ( $this->_tpl_vars['visitor']['columns']['provider'] ) && $this->_tpl_vars['visitor']['columns']['provider'] != 'IP' )): ?> 
					<br />
					<?php echo ((is_array($_tmp='Provider_ColumnProvider')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
: 
					<a href="<?php echo $this->_tpl_vars['visitor']['columns']['providerUrl']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['visitor']['columns']['providerUrl']; ?>
" style="text-decoration:underline;">
						<?php echo $this->_tpl_vars['visitor']['columns']['provider']; ?>

					</a>
				<?php endif; ?>
				
	</td>
	<td class="label" style="width:13%" width="13%">
		&nbsp;<img src="<?php echo $this->_tpl_vars['visitor']['columns']['countryFlag']; ?>
" title="<?php echo $this->_tpl_vars['visitor']['columns']['country']; ?>
, Provider <?php echo $this->_tpl_vars['visitor']['columns']['provider']; ?>
" />
		&nbsp;<img src="<?php echo $this->_tpl_vars['visitor']['columns']['browserIcon']; ?>
" title="<?php echo $this->_tpl_vars['visitor']['columns']['browser']; ?>
 with plugins <?php echo $this->_tpl_vars['visitor']['columns']['plugins']; ?>
 enabled" />
		&nbsp;<img src="<?php echo $this->_tpl_vars['visitor']['columns']['operatingSystemIcon']; ?>
" title="<?php echo $this->_tpl_vars['visitor']['columns']['operatingSystem']; ?>
, <?php echo $this->_tpl_vars['visitor']['columns']['resolution']; ?>
 (<?php echo $this->_tpl_vars['visitor']['columns']['screen']; ?>
)" />
		&nbsp;<?php if ($this->_tpl_vars['visitor']['columns']['isVisitorGoalConverted']): ?><img src="<?php echo $this->_tpl_vars['visitor']['columns']['goalIcon']; ?>
" title="<?php echo $this->_tpl_vars['visitor']['columns']['goalType']; ?>
" /><?php endif; ?>
		<?php if ($this->_tpl_vars['visitor']['columns']['isVisitorReturning']): ?>
			&nbsp;<img src="plugins/Live/templates/images/returningVisitor.gif" title="Returning Visitor" />
		<?php endif; ?>
		<br/>
		<?php if (count ( $this->_tpl_vars['visitor']['columns']['pluginIcons'] ) > 0): ?>
			<hr />
			<?php echo ((is_array($_tmp='UserSettings_Plugins')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
:
				<?php $_from = $this->_tpl_vars['visitor']['columns']['pluginIcons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pluginIcon']):
?>
					<img src="<?php echo $this->_tpl_vars['pluginIcon']['pluginIcon']; ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['pluginIcon']['pluginName'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['pluginIcon']['pluginName'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
" />
				<?php endforeach; endif; unset($_from); ?>
		<?php endif; ?>
	</td>

	<td class="column" style="width:20%" width="20%">
		<div class="referer">
			<?php if ($this->_tpl_vars['visitor']['columns']['refererType'] == 'website'): ?>
				<?php echo ((is_array($_tmp='Referers_ColumnWebsite')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
:
				<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['visitor']['columns']['refererUrl'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" target="_blank" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['visitor']['columns']['refererUrl'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" style="text-decoration:underline;">
					<?php echo ((is_array($_tmp=$this->_tpl_vars['visitor']['columns']['refererName'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

				</a>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['visitor']['columns']['refererType'] == 'campaign'): ?>
				<?php echo ((is_array($_tmp='Referers_Campaigns')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>

				<br />
				<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['visitor']['columns']['refererUrl'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" target="_blank" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['visitor']['columns']['refererUrl'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" style="text-decoration:underline;">
					<?php echo ((is_array($_tmp=$this->_tpl_vars['visitor']['columns']['refererName'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

				</a>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['visitor']['columns']['refererType'] == 'searchEngine'): ?>
				<?php if (! empty ( $this->_tpl_vars['visitor']['columns']['searchEngineIcon'] )): ?>
					<img src="<?php echo $this->_tpl_vars['visitor']['columns']['searchEngineIcon']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['visitor']['columns']['refererName'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" /> 
				<?php endif; ?>
				<?php echo ((is_array($_tmp=$this->_tpl_vars['visitor']['columns']['refererName'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

				<br />
				<?php if (! empty ( $this->_tpl_vars['visitor']['columns']['keywords'] )): ?><?php echo ((is_array($_tmp='Referers_Keywords')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
:<?php endif; ?>
				<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['visitor']['columns']['refererUrl'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" target="_blank" style="text-decoration:underline;">
					<?php if (! empty ( $this->_tpl_vars['visitor']['columns']['keywords'] )): ?>
						"<?php echo ((is_array($_tmp=$this->_tpl_vars['visitor']['columns']['keywords'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"
					<?php endif; ?>
				</a>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['visitor']['columns']['refererType'] == 'directEntry'): ?><?php echo ((is_array($_tmp='Referers_DirectEntry')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
<?php endif; ?>
		</div>
	</td>
	<td class="column <?php if ($this->_tpl_vars['visitor']['columns']['isVisitorGoalConverted']): ?>highlightField<?php endif; ?>" style="width:55%" width="55%">
			<strong>
				<?php echo count($this->_tpl_vars['visitor']['columns']['actionDetails']); ?>

				<?php if (count($this->_tpl_vars['visitor']['columns']['actionDetails']) <= 1): ?>
					<?php echo ((is_array($_tmp='Live_Action')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
 
				<?php else: ?>
					<?php echo ((is_array($_tmp='Live_Actions')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>

				<?php endif; ?>
				- <?php echo $this->_tpl_vars['visitor']['columns']['visitLengthPretty']; ?>

			</strong>
			<br />
			<ol style="list-style:decimal inside none;">
			<?php $_from = $this->_tpl_vars['visitor']['columns']['actionDetails']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['action']):
?>
				<li>
					<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['action']['pageUrl'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" target="_blank" style="text-decoration:underline;" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['action']['pageUrl'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['action']['pageUrl'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('truncate', true, $_tmp, 80, "...", true) : smarty_modifier_truncate($_tmp, 80, "...", true)); ?>
</a>
					<?php if ($this->_tpl_vars['visitor']['columns']['goalUrl'] == $this->_tpl_vars['action']['pageIdAction']): ?>
						<ul class="actionGoalDetails">
							<li>
								<img src="<?php echo $this->_tpl_vars['visitor']['columns']['goalIcon']; ?>
" title="<?php echo $this->_tpl_vars['visitor']['columns']['goalType']; ?>
" /> 
								<strong><?php echo $this->_tpl_vars['visitor']['columns']['goalName']; ?>
</strong>, 
								<?php if ($this->_tpl_vars['visitor']['columns']['goalRevenue'] > 0): ?><?php echo ((is_array($_tmp='Live_GoalRevenue')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
: <strong><?php echo $this->_tpl_vars['visitor']['columns']['goalRevenue']; ?>
 <?php echo $this->_tpl_vars['visitor']['columns']['siteCurrency']; ?>
</strong><?php endif; ?>
							</li>
						</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; endif; unset($_from); ?>
			</ol>
	</td>
	</tr>
<?php endforeach; endif; unset($_from); ?>
	</tbody>
	</table>

		<?php endif; ?>
		
		<?php if (count ( $this->_tpl_vars['arrayDataTable'] ) == 20): ?>
				<?php $this->_tpl_vars['javascriptVariablesToSet']['totalRows'] = 100000;  ?>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['properties']['show_footer']): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CoreHome/templates/datatable_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php endif; ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CoreHome/templates/datatable_js.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
</div>

<?php echo '
<style>
 hr {
	background:none repeat scroll 0 0 transparent;
	border-color:-moz-use-text-color -moz-use-text-color #EEEEEE;
	border-style:none none solid;
	border-width:0 0 1px;
	color:#CCCCCC;
	margin:0 2em 0.5em;
	padding:0 0 0.5em;
 }

</style>
'; ?>

</div>