<?php /* Smarty version 2.6.26, created on 2011-03-02 16:28:18
         compiled from /Users/Mrkelly/Sites/kiwiguo/piwik/plugins/Widgetize/templates/iframe.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'loadJavascriptTranslations', '/Users/Mrkelly/Sites/kiwiguo/piwik/plugins/Widgetize/templates/iframe.tpl', 3, false),)), $this); ?>
<html>
<head>
<?php echo smarty_function_loadJavascriptTranslations(array('plugins' => 'CoreHome'), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CoreHome/templates/js_global_variables.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CoreHome/templates/js_css_includes.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>

<div class="widget">
<?php echo $this->_tpl_vars['content']; ?>

</div>

</body>
</html>