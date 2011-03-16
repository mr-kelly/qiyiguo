<?php
	/**
	 *  母控制器，所有控制器继承KK_Controller
	 */
	class KK_Controller extends CI_Controller {
	
		function __construct() {
			parent::__construct();

			// 让?xxx=xxx  生效$_GET
// 			parse_str($_SERVER['QUERY_STRING'],$_GET); 
// 			
// 			header("Cache-Control: no-cache");
// 			header("Pragma: no-cache");
			
		}

		
		
		
		
		/**
		 *	创建目录函数，用于上传头像是自动生成用户的头像图片存放文件夹
		 */
		function _createDir($path) {
		   
		   if (!file_exists($path)) {
		   	
			$this->_createDir(dirname($path));
		
			mkdir($path, 0755);
			
		   }
		}
	}