<?php

	/**
	 *	创建分页的pagination
	 */
	class KK_Pagination {
		
		
		function create_links( $current_start=0, $total_rows=100, $per_page=10 ) {
			
			$pages = ceil( $total_rows / $per_page);
			
			// 当前页数判断...$start / per_page . 
			$current_page = ceil( $current_start / $per_page ) + 1;
			
			// 如果只有一页！不创建翻页条 或者，没有数据...
			if ( $pages == 1 || $total_rows == 0 ) return;
			
			
			$return = '<div class="pagination">';
			
			// 如果start!=0,添加上一页
			if ( $current_start != 0 ) {
				$return .= sprintf( '<a href="?start=%d">&lt;上一页</a>', $current_start - $per_page );
			}
			
			// 创建页数条..   !!!只显示当前页数的前10、后10
			foreach( range( 1, $pages ) as $page ) {
			
				// 当page大于10 显示省略号好了
				if ( $page < 10 ) {
					$return .= sprintf( '<a class="%s" href="?start=%d">%s</a>', 
											$current_page == $page ? 'current_page':'', 
											$per_page * ($page-1) , 
											$page );
				} else {
					$return .= '.';
				}
										
			}
			
			// 如果不是最后一页，添加“下一页”
			if ( $pages != $current_page ) {
				$return .= sprintf('<a href="?start=%d">下一页&gt;</a>', $current_start+$per_page);
			}
			$return .= '</div>';

			
			return $return;
// 			$option = $option + array( 
// 								'get' => 'page',
// 								'total_rows' => 1000,
// 								'per_page' => 10,
// 									);
// 					ceil
// 			$pages = ceil( $option['total_rows'] / $option['per_page'] );
// 			
// 			$ci =& get_instance();
// 			// 读取get[page], 如果没有，page为1
// 			$current_page = $ci->input->get( $option['get'] );
// 			if ( ! $current_page ) {
// 				$current_page = 1;
// 			}
// 			
// 			$return = '<div class="pagination">';
// 			
// 			
// 			// 如果当前页不是在第一页，那么提供“上一页”链接
// 			if ( $current_page != 1 ) {
// 				$return .= sprintf( '<a href="%s">上一页</a>', $this->return_url( $option['get'], $current_page-1) );
// 				//$return .= sprintf( '<a href="?%s=%s">上一页</a>', $option['get'], $current_page-1 );
// 			}
// 			foreach ( range(1, $pages) as $page ) {
// 
// 				
// 				// 当前页面的页面按钮链接，不可选
// 				if ( $current_page == $page ) {
// 					$return .= sprintf('<span>%s</span>&nbsp;', $page);
// 				} else {
// 					//$return .= sprintf('<a href="?%s=%s">%s</a>&nbsp;', $option['get'], $page, $page); //'<a href="?page=' . $page .  '">' . $page . '</a>&nbsp;&nbsp;';
// 					$return .= sprintf('<a href="%s">%s</a>&nbsp;', $this->return_url( $option['get'], $page) , $page);
// 				}
// 				
// 				
// 
// 			}
// 			
// 			// 如果当前页不是到了最后一页，那么提供“下一页”链接
// 			if ( $page != $current_page ) {
// 				//$return .= sprintf( '<a href="?%s=%s">下一页</a>', $option['get'], $current_page+1 );
// 				$return .= sprintf( '<a href="%s">下一页</a>', $this->return_url( $option['get'], $current_page+1 ) );
// 			}
// 
// 			$return .= '</div>';
// 			
// 			return $return;
		}
		
		
		/**
		 *	根据是否已get， 网址是添加? 还是&
		 
		 	将网址判断做成一个函数
		 */
		private function return_url( $get_string, $page ) {
			$current_url = $_SERVER['REQUEST_URI'];
			if ( $_GET == array() ) {
				// query string为空！那么直接?page=xx
				$current_url .= sprintf('?%s=%s', $get_string, $page );
			} else if ( isset($_GET['page'] ) ) {
				//PHP 字符串处理
				$current_url = str_replace( 'page='.$_GET['page'] , 'page='.$page, $current_url);
				
			} else {
				// query string 不存在&page， 那马加&page=xx
				$current_url .= sprintf('&%s=%s', $get_string, $page );
			}
			
			return $current_url;
		}
	
	}