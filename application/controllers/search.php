<?php

	class Search extends KK_Controller {
		
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
		
			$query_string = trim($this->input->get( 'q' ));
			
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