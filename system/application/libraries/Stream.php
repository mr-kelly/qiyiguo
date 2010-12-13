<?php

	// 核心 Stream Model
	// Stream 集合 友群信息、聊天信息、微博等多种信息组合的综合用户信息流
	
	// Stream 把信息排序
	
	
	/** 
	 *	Stream 规范
	 
	 		包含
	 			stream_content
	 			stream_user     本网站的用户model
	 			stream_created  本网站可读的日期时间
	 */
	
	class Stream {
		function get_stream( $array , $type ) {
			
		}
		
		
		
		
		
		
		/**
		 *	新浪微博 stream
		 */
		function get_t_sina_stream( $t_sina_stream_array ) {
			$ci =& get_instance();
			// 按时间排序
			// Stream 排序
			usort( $t_sina_stream_array, function( $a,  $b ){
				
				$ci =& get_instance();
									// 处理t_sina的时间字符串
				$a_time = $ci->t_sina->t_sina_timestamp( $a['created_at'] );
				$b_time = $ci->t_sina->t_sina_timestamp( $b['created_at'] );
				
				if ( $a_time == $b_time ) {
					return 0;
				}
			
				return ( $a_time > $b_time ) ? -1 : 1;
			});
			
			
			// 设置 stream 规范, 改变原数据数组，   // stream_content
			foreach ( $t_sina_stream_array as $key=>$t_sina ) {
			
				$t_sina_stream_array[$key]['stream_content'] = $t_sina['text'];
				$t_sina_stream_array[$key]['stream_created'] = date( 'Y-m-d H:i:s', $ci->t_sina->t_sina_timestamp( $t_sina['created_at'] ) );
				
				
				// 通过t_sina_id 获取对应的本网站用户id, 再获取用户信息
				$ci->load->model('user_t_sina_model');
				$user_t_sina = $ci->user_t_sina_model->get_user_t_sina_by_t_sina_id( $t_sina['user']['id'] );
				$user = $ci->user_t_sina_model->_get_user( $user_t_sina['user_id'] );
				
				$t_sina_stream_array[$key]['stream_user'] = $user;
				
			}
			
			return $t_sina_stream_array;
			
		}
		
		
		
		
		
		
		private function t_sina_adapter( $t_sina_array ) {
			
		}
	}