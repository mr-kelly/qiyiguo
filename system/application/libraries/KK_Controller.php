<?php
	class KK_Controller extends Controller {
		function __construct() {

			parent::Controller();
			
			// 让?xxx=xxx  生效$_GET
			parse_str($_SERVER['QUERY_STRING'],$_GET); 
			
			header("Cache-Control: no-cache");
			header("Pragma: no-cache");
		}
		function KK_Controller() {
			$this->__construct();
		}
		
		
		
		
		/**
		 *	创建目录函数，用于上传头像是自动生成用户的头像图片存放文件夹
		 */
		function _createDir($path) {
		   if (!file_exists($path)) {
		   	
			$this->_createDir(dirname($path));
		
			mkdir($path, 0777);
		   }
		}
	}