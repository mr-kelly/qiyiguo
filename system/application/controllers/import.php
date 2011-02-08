<?php

	/**
	 *	用于动态PHP导入 JS、CSS文件等的控制器
	 */
	class Import extends KK_Controller {
		function js_vars() {
			header("Content-type: text/javascript");
			kk_show_view('import/js_vars_view');
		}
	}