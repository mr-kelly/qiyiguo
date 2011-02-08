<?php
	
	/**
	 *	奇异果 关键字 过滤器～
	 */
	class KK_Filter {
		
		/**
		 *	行动！ 过滤！
		 
		 	这个默认配置， 允许<a>标签存在
		 */
		function filter( $string, $option = array() ) {
			
			$default_option = array( 
									'without_html' => true, 
									'htmlspecialchars' => false,
									);
									
			$option += $default_option;
			
			
			
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
	
		
	
		private function keywords_filter( $string ) {
			
		}
	
	
	
	}