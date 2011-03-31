<?php

	class Search extends KK_Controller {
		
		/**
		 *	主搜索页
		 */
		function index() {
			$this->load->model('search_model');
			$this->load->model('group_model');
			
			// 搜索字符串
			$q = $this->input->get('q');
			
			if ( !empty ( $q ) ) {	
				// 查询字符串为空。。什么也不做！
				
				if ( is_numeric( $q ) ) { //纯数字？ 找指定ID的群或用户吧
				
					if ( $specific_group = $this->group_model->get_group_by_id ( $q ) ) {
						// 找到组
						$render['search_groups'][] = $specific_group;
					}
					
					
					if ( $specific_user = $this->user_profiles_model->_get_user( $q ) ) {
						// 找到用户
						if ( $specific_user['id'] != 0 ) {  // 未非「已注销」的用户
							$render['search_users'][] = $specific_user;
						}
					}
					
				} else {
					// 非纯数字，那么字符串搜索...
					$render['search_groups'] = $this->group_model->search_groups( array(
						'name' => $q,
						'intro' => $q,
					));
					
					$render['search_users'] = $this->user_profiles_model->search_users( array(
						'realname' => $q,
						'nickname' => $q,
					));
					
					// Stream Search : 话题/活动
					$this->load->model('stream_model');
					$render['search_stream'] = $this->stream_model->search_stream( $q );
					
					
				}
				
				// 搜索记录
				$this->search_model->search_record( $q );
			}
			
			
			$render['q'] = $q;
			$render['footer_ad'] = true;
			
			kk_show_view('search/index_view', $render);
			
		}
		
		/**
		 *	iframe 搜索页
		 */
		function iframe_search() {
			$data = array();
			kk_show_view('search/iframe_search_view', $data);
		}
		
		
		/**
		 *	JS ModelWindow 获取指定学校
		 */
		function window_choose_school() {
			kk_show_view('search/window_choose_school_view');
		}
		
		
		function ajax_search_group_by_id( $group_id=0 ) {
			//$group_id = $this->input->get('group_id');
			
			$this->load->model('group_model');
			$group = $this->group_model->_get_group( $group_id );
			$render['search_groups'] = empty($group) ? false :  array( $group );
			
			kk_show_view('search/ajax_search_group_view', $render);
		}
		
		
		/** 
		*	JS Ajax.  通过搜索获取指定学校
		*/
		function ajax_search_groups_by_string() {
			header("Content-Type: text/html; charset=utf-8");
			
			
			$query_string = trim($this->input->get( 'q' ));
			
			//print( $query_string );
			//exit();
			
			if ( empty( $query_string ) ) {
				$render['search_groups'] = false;
			} else {
				$this->load->model( 'group_model');
				$render['search_groups'] = $this->group_model->search_groups( array(
					'name' => $query_string,
					'intro' => $query_string,
				), 20); // 限制搜索结果
			}
			
			kk_show_view('search/ajax_search_group_view', $render);
		
		}
		
	}
