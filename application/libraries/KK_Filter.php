<?php
	
	/**
	 *	奇异果 关键字 过滤器～
	 */
	class KK_Filter {
		function __construct() {
		
			$this->replace_chr = '***'; // 用于替换的字符串`
			
			
			// 定义非法字符。  后面应该在数据库去读取
			$this->keywords_to_filter = array(
				'共产党',
				'操你',
				
			);
		}
		/**
		 *	行动！ 过滤！
		 
		 	这个默认配置， 允许<a>标签存在
		 		
		 		TODO 如果设置了user_id, 记录该用户....!随时封杀呢
		 		
		 */
		function filter( $string, $option = array(), $user_id=null ) {
			
			$default_option = array( 
									'without_html' => true, 
									'htmlspecialchars' => false,
									);
									
			$option += $default_option;
			
			
			$string = $this->keywords_filter( $string );
			
			
			// 这个在 先～ 否则html都被htmlspecialchars转义了
			if ( $option['without_html'] ) {
				$string = $this->_html_tags_filter( $string );
			}
			
			if ( $option['htmlspecialchars'] ) {
				$string = htmlspecialchars( $string );
			}
			
			
			return $string;
		}
		
		
		/** 
		 *	过滤 Html 标签的函数    奇异果允许<a>
		 */
		private function _html_tags_filter( $string ) {
			return strip_tags( $string , '<a>');
		}
	
		
		
		/**
		 *	关键字过滤， 将指定的关键字过滤成 ***
		 */
		private function keywords_filter( $string ) {

			
			foreach( $this->keywords_to_filter as $kw ) {
				// 替换非法字符～
				$string = str_replace( $kw, $this->replace_chr, $string );
			}
			
			
			return $string;
		}
	
	
	
	}